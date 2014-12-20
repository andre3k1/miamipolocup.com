<?php
/**
 * Functions: ajax-functions.php
 *
 * Static methods for AJAX and dynamic CSS generation
 *
 * @package WordPress
 * @subpackage Launch Effect
 *
 */

function compress($buffer) {
	/* remove comments */
	$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
	/* remove tabs, spaces, newlines, etc. */
	$buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);
	/* fixes color hex saved without hash mark */
	$buffer = str_replace('##', '#', $buffer);
	return $buffer;
}

function dynamic_css_headers() {
	// Set the header according to when the CSS was last updated
	$max_age = 2419200; // 4 weeks
	$now = gmdate('D, d M Y H:i:s', time()).' GMT';
	$last_modified = get_theme_mod('lefx_dynamic_css_last_modified',$now);
	$etag = md5($last_modified);

	header("ETag: {$etag}");
	header("Expires: " . gmdate('D, d M Y H:i:s', time()+$max_age) . ' GMT');
	header("Cache-Control: max-age={$max_age}, public, must-revalidate");
	header("Last-Modified: {$last_modified}");
	header('Content-type: text/css; charset: UTF-8');
}

add_action('wp_ajax_le_submit', 'le_submit' );
add_action('wp_ajax_nopriv_le_submit', 'le_submit' );

function le_submit() {
	if ( !isset($_POST['verify_pre_signup']) || !wp_verify_nonce($_POST['verify_pre_signup'],'pre_signup') ) {
	   wp_die("We're missing something.", "Error");
	}
	require_once dirname(__FILE__) . '/../inc/MCAPI.class.php';

	// grab an API Key from http://admin.mailchimp.com/account/api/
	$chimpkey = get_option('lefx_mcapikey');
	$cmkey = get_option('lefx_cmapikey');
	$cmclient = get_option('lefx_cmclientid');
	$cmlist = get_option('lefx_cmlistid');
	$admin_notify = get_option('lefx_admin_notify');
	$auto_reply = get_option('lefx_response_replyto');
	$auto_copy = get_option('lefx_response_copy');
	$auto_responder = (!empty($auto_reply) && !empty($auto_copy));

	$api = new MCAPI($chimpkey);

	$aweberConsumerKey = get_option('lefx_aweberconsumerkey');
	$aweberConsumerSecret = get_option('lefx_aweberconsumersecret');

	// grab your List's Unique Id by going to http://admin.mailchimp.com/lists/
	// Click the "settings" link for the list - the Unique Id is at the bottom of that page.
	$list_id = get_option('lefx_mclistid');

	$opt_in = (get_option('lefx_mcdouble') == true) ? false : true;
	$referralpost = (!empty($_REQUEST['referredBy'])) ? $_REQUEST['referredBy'] : '';

	// POST FORM WITH AJAX
	$email_check = '';
	$reuser = '';
	$clicks = '';
	$conversions = '';
	$returncode = null;
	$return_arr = array();
	$required = array();
	$pass_thru_error = '';

	if (isset($_POST['email'])) {
		if ($postEmail = is_email($_POST['email'])) {
			$email_check = 'valid';
			$count = countCheck(LE_TABLE, 'email', $postEmail);

			if ($count > 0) {
				$reuser = 'true';
				$stats = getDetail(LE_TABLE, 'email', $postEmail);

				foreach ($stats as $stat) {
					$clicks = $stat->visits;
					$conversions = $stat->conversions;
					$returncode = $stat->code;
				}
			} else {
				$reuser = 'false';
				$premium = null;
				$aweber_custom_fields = array();
				$chimp_custom_field = array();
				$aweber_name = '';
				$cm_custom_field_values = array();
				$cm_le_fields = array();
				$cm_name = '';
				$mc_firstname = '';
				$mc_lastname = '';

				// Custom Fields
				if(lefx_version() == 'premium') {
					$premium = array();
					$premium['fields'] = $premium['values'] = $postfields = $custom_fields = array();

					for($i=1; $i<=10; $i++) {
						$_idx = "field$i";
						if(isset($_POST[$_idx])) {
							$opt_val = get_option("lefx_cust_field{$i}");
							$option = trim(preg_replace('/[^a-zA-Z 0-9]+/', '', $opt_val));
							$fieldname =  "LE " . $option;

							if (is_array($_POST[$_idx]))
								$postfields[$_idx] = implode(',', $_POST[$_idx]);
							else
								$postfields[$_idx] = $_POST[$_idx];

							$_field = $postfields[$_idx];
							if(get_option("lefx_cust_field{$i}_required") == "on" && (!$_field || trim($_field) == ''))
								array_push($required, "lefx_cust_field{$i}");

							array_push($premium['fields'], "custom_field$i");
							array_push($premium['values'], $_field);
							if (!empty($_field)) $custom_fields[] = "$opt_val: $_field";

							// Mail Chimp
							switch( strtolower(trim($option)) ) {
								case 'first name':
									$mc_firstname = $_field;
									break;
								case 'last name' :
									$mc_lastname = $_field;
									break;
								default:
									$chimp_custom_fields["LEFIELD{$i}"] = array('name' => $fieldname, 'value' => $_field);
							}

							// AWeber
							if (strtolower(trim($option)) != 'name') {
								if ( !empty($_field) ) {
									$aweber_custom_fields["LE " . str_replace(' ','_', $option)] = substr($_field,0,100);
								}
							} else {
								$aweber_name = substr($_field,0,100);
							}

							//Campaign Monitor
							if (strtolower(trim($option)) != 'name') {
								$cm_le_fields[$fieldname] = $_field;
								array_push($cm_custom_field_values, array('Key' => $fieldname, 'Value' => $_field));
							} elseif (strtolower(trim($option)) == 'name') {
								// use aweber name, or else combine mailchimp first and last, else empty
								$cm_name = $aweber_name;
							}

						} else {
							if( get_option("lefx_cust_field{$i}") != '' && get_option("lefx_cust_field{$i}_required") == "on")
								array_push($required, "lefx_cust_field{$i}");
						}
					}

					// Use firstname & lastname if available
					if (($mc_firstname || $mc_lastname) && empty($aweber_name) ) {
						$aweber_name = $cm_name = trim($mc_firstname . ' ' . $mc_lastname);
					}
				}

				// set field names
				$le_fields = array('LE Referral Code', 'LE Visits', 'LE Signups');
			    $aweber_le_fields = array_merge($le_fields, array_keys($aweber_custom_fields));
			    $cm_le_fields = array_merge($le_fields, array_keys($cm_le_fields));

				if (!count($required)) {
					postData(LE_TABLE, $referralpost, $premium);

					if ($auto_responder||$admin_notify) {
						$site_title = get_bloginfo('name');
						$the_url = sprintf(site_url('?ref=%s'), @$_POST['code']);
						$the_link = sprintf("<a href=\"%s\">referral link</a>", $the_url);
					}

					// auto responder
					if ($auto_responder) {
						$headers = "From: $site_title <$auto_reply>". "\r\n";
						$headers .= "MIME-Version: 1.0". "\r\n";
						$headers .= "Content-Type: text/html; charset=UTF-8". "\r\n";
						$subj = get_option('lefx_response_subj');
						$subject = !empty($subj)?$subj:$site_title. ": Auto-Response";
						$the_shortcode = '[launchcode]';
						$has_shortcode = strpos( $auto_copy, $the_shortcode);

						if ( $has_shortcode ) {
							$auto_copy = str_replace( $the_shortcode, $the_link, $auto_copy );
						}
						$emailed = @wp_mail( $postEmail, $subject, $auto_copy, $headers );
					}

					// admin notifier
					if ($admin_notify) {
						$site_title = get_bloginfo('name');
						$admin_email = get_bloginfo('admin_email');
						$headers = "From: $site_title <$admin_email>". "\r\n";
						$headers .= "MIME-Version: 1.0". "\r\n";
						$headers .= "Content-Type: text/html; charset=UTF-8". "\r\n";
						$subject = "[$site_title] New User Signup";
						$copy = "A new user has signed up.<br/><br/>User Email: $postEmail<br/>Signup Code: $the_link<br/><br/>";
						$copy .= implode('<br/><br/>',$custom_fields);
						$emailed = @wp_mail( $admin_email, $subject, stripslashes($copy), $headers );
					}

					// MailChimp integration
					if($chimpkey) {
						$chimpvars = $api->listMergeVars(get_option('lefx_mclistid'));
						$tags = array();
						$names = array();
						foreach($chimpvars as $var) {
							array_push($tags, $var['tag']);
							array_push($names ,$var['name']);
						}
						$chimpvars = array_flatten($chimpvars);

						if (!in_array('LECODE', $chimpvars, true)) {
							$api->listMergeVarAdd(get_option('lefx_mclistid'), 'LECODE', 'LE Referral Code', array('public' => false));
							$api->listMergeVarAdd(get_option('lefx_mclistid'), 'LEVISITS', 'LE Visits', array('public' => false));
							$api->listMergeVarAdd(get_option('lefx_mclistid'), 'LESIGNUPS', 'LE Signups', array('public' => false));
						}

						$mergeVars = array('FNAME' => $mc_firstname, 'LNAME' => $mc_lastname, 'LECODE' => $_POST['code']);

						if(isset($chimp_custom_fields)) {
							foreach($chimp_custom_fields as $fieldtag => $field) {
								$pos = array_search($fieldtag, $tags);
								if ($pos === false) {
									$api->listMergeVarAdd($list_id, $fieldtag, $field['name'], array('public' => false));
								} elseif ($names[$pos] != $field['name']) {
									$api->listMergeVarUpdate($list_id, $fieldtag, array('name' => $field['name']));
								}
								$mergeVars[$fieldtag] = $field['value'];
							}
						}

						$api->listSubscribe($list_id, $postEmail,$mergeVars,'html',$opt_in );
					}

					//Campaign Monitor Integration
					if ( !empty($cmkey) && !empty($cmclient) && !empty($cmlist) ) {
						// if client is undefined, ignore list value
						$list = new CS_REST_Lists($cmlist, $cmkey);
						$subscribers = new CS_REST_Subscribers($cmlist, $cmkey);
						$cust_fields = $list->get_custom_fields();
						$existing_fields = $cust_fields->response;

						if ($cm_le_fields) {
							foreach ($existing_fields as $field) {
								$pos = array_search($field->FieldName, $cm_le_fields);
								if ($pos !== false) unset($cm_le_fields[$pos]);
							}
							foreach ($cm_le_fields as $name) {
								$result = $list->create_custom_field(array(
								    'FieldName' => $name,
								    'DataType' => CS_REST_CUSTOM_FIELD_TYPE_TEXT
								));
							}
						}

						array_push($cm_custom_field_values, array('Key' => "LE Referral Code", 'Value' => $_POST['code']));
						array_push($cm_custom_field_values, array('Key' => "LE Visits", 'Value' => '0'));
						array_push($cm_custom_field_values, array('Key' => "LE Signups", 'Value' => '0'));

						$result = $subscribers->add(
							array(
							    'EmailAddress' => $postEmail,
							    'Name' => ($cm_name==false?'':$cm_name),
							    'CustomFields' => $cm_custom_field_values,
							    'Resubscribe' => true
							)
						);
					}

					// AWeber integration
					if ( !empty($aweberConsumerKey) && !empty($aweberConsumerSecret) ) {
						$aweberAccessKey = get_option('lefx_aweberaccesskey');
						$aweberAccessSecret = get_option('lefx_aweberaccesssecret');
						$aweberListId  = get_option('lefx_aweberlistid');
						$aweberAccountId = get_option('lefx_aweberaccountid');

						$aweber = new AWeberAPI($aweberConsumerKey, $aweberConsumerSecret);
						try {
						    $account = $aweber->getAccount($aweberAccessKey, $aweberAccessSecret);
						    $listURL = "/accounts/{$aweberAccountId}/lists/{$aweberListId}";
						    $list = $account->loadFromUrl($listURL);

						    # create a subscriber
						    $params = array(
						        'email' => $postEmail,
						        'ip_address' => $_SERVER['REMOTE_ADDR'],
						        'ad_tracking' => 'launch_effect',
						        'last_followup_message_number_sent' => 0,
						        'misc_notes' => 'launch effect subscription',
						        'name' => $aweber_name,
						    );

						    //add custom fields
						    //if(isset($list->custom_fields)){
							$aweber_fields = $list->custom_fields;
							$existing_field_names = array();
							foreach ($aweber_fields as $field)
								$existing_field_names[] = $field->name;
							foreach ($aweber_le_fields as $fieldname) {
								// Aweber will not allow additional name fields
								if (!in_array($fieldname, $existing_field_names)) {
						    		$aweber_fields->create(array('name' => $fieldname));
								}
							}
							if (count($aweber_custom_fields))
								$params['custom_fields'] = $aweber_custom_fields;
							$params['custom_fields']['LE Referral Code'] = $_POST['code'];
							$params['custom_fields']['LE Visits'] = "0";
							$params['custom_fields']['LE Signups'] = "0";
							$subscribers = $list->subscribers;
							$new_subscriber = $subscribers->create($params);
							//}
						    # success!

						} catch(AWeberAPIException $exc) {
						    if (trim($exc->message) == "email: Subscriber already subscribed.") {}
						    elseif (trim($exc->message)  == "email: Email address blocked. Please refer to http://www.aweber.com/faq/questions/518/.") {
						    	$pass_thru_error = 'blocked';
						    } else {
						    	$pass_thru_error = array('AWeberAPIException' => array(
						    		"type" => $exc->type,
						    		"msg" => $exc->message,
						    		"docs" => $exc->documentation_url,
						    	));
						    }
						}
					}
				}
			}
		} else {
			$email_check = 'invalid';
		}
		$return_arr["email_check"] = $email_check;
		$return_arr["required"] = $required;
		$return_arr["pass_thru_error"] = $pass_thru_error;
		$return_arr["reuser"] = $reuser;
		$return_arr["clicks"] = $clicks;
		$return_arr["conversions"] = $conversions;
		$return_arr["returncode"] = $returncode;
		$return_arr["email"] = $postEmail;
		$return_arr["code"] = $_POST['code'];
	}

	header("Content-type: text/json");
	echo json_encode($return_arr);
	exit;
}

add_action('wp_ajax_dynamic_css', 'dynamic_css' );
add_action('wp_ajax_nopriv_dynamic_css', 'dynamic_css' );

function dynamic_css() {
	dynamic_css_headers();
	ob_start("compress");

	/* Variables
	================================================== */
	$textShadow  = '0px 2px 1px #333';
	$letterPress = '0px 1px 1px #' . lighter('container_background_color');
	$dropShadow  = '-webkit-box-shadow: 0px 0px 10px #111; -moz-box-shadow: 0px 0px 10px #111; box-shadow: 0px 0px 10px #111;';
	$glow        = '-webkit-box-shadow: 0px 0px 10px #FFF;	-moz-box-shadow: 0px 0px 10px #FFF; box-shadow: 0px 0px 10px #FFF;';
	$noShadow    = '-webkit-box-shadow: 0px 0px 0px #FFF; -moz-box-shadow: 0px 0px 0px #FFF; box-shadow: 0px 0px 0px #FFF;';
	$pg_bg_color = '#D4DEE0';
	$ct_bg_color = '#D4DEE0';

	?>

/* Background Color/Image
================================================== */

	html,
	body {
		background: <?php echo $pg_bg_color; ?>

	}
	<?php if ( $supersize = leimg('supersize', 'supersize_disable', 'plugin_options')) : ?>

	#background {
		display:block;
		position:fixed;
		top:0;
		z-index:1;
		height:100%;
		width:100%;
		background: <?php printf('url("%s") no-repeat fixed center center %s;', $supersize, $pg_bg_color); ?>
		-webkit-background-size: cover;
		-moz-background-size: cover;
		-o-background-size: cover;
		background-size: cover;
	}
	#background.slideshow {
		background-color: <?php echo $pg_bg_color; ?>
		background-image: none;
		filter: none;
		-ms-filter: none;
	}
	#background div {
		background-position: 50% 0%;
		background-repeat: no-repeat;
		background-size: cover;
		height: 100%;
		left: 0;
		opacity: 0;
		position: absolute;
		top: 0;
		width: 100%;
	}
	#signup-bodytag #background {
		opacity:0;
	}
	<?php endif; ?>

/* Container
================================================== */

	#signup {
		<?php if ($background = leimg('background','background_disable', 'launchmodule_options')) : ?>

		background-image:url("<?php echo $background; ?>");
		background-color:transparent;
		<?php elseif ( $ct_bg_color ) : ?>background-color: <?php echo $ct_bg_color; endif; ?>;
		border-width:<?php le('container_border_width'); ?>;
		border-color:<?php le('container_border_color'); ?>;
		border-style:solid;
		<?php
			switch( get_option('container_effects') ) {
				case 'dropshadow': echo $dropShadow; break;
				case 'glow': echo $glow; break;
				default: echo $noShadow;
			}
		?>

	}
	#signup-page header h1 {
		text-align: center;
	}
	#signup-page header h1 {
		font-family: Raleway;
		font-weight: 700;
		font-style: normal;
		color: #13224d;
		text-shadow: #13224d -1px 1px 0,
			#13224d -2px 2px 0,
			#aa893a -3px 3px 0,
			#aa893a -4px 4px 0;
		font-size:2.5em;
	}
	#signup-page header h1 span {
		display: block;
		text-align: center;
	}
	#signup a,
	#privacy-policy a {
		color:<?php le('description_link_color'); ?> !important;
	}
	#signup h2,
	#privacy-policy h2 {
		font-family:<?php legogl('subheading_font_goog', 'subheading_font'); ?>;
		font-size:<?php echo $subheading_size = ler('subheading_size'); ?>em;
		font-weight:<?php lewt('subheading_style'); ?>;
		font-style:<?php lestyle('subheading_style'); ?>;
		color:<?php echo $subheading_color = ler('subheading_color'); ?>;
		text-shadow: <?php
			switch( get_option('subheading_effects') ) {
				case 'letterpress': echo $letterPress; break;
				case 'shadow': echo $textShadow; break;
				default: echo 'none';
			}
		?>;
	}

	#signup h3, #signup h4 {
		color:<?php echo $subheading_color; ?>;
	}
	#signup h3 {
		font-size:<?php echo ($subheading_size*0.85); ?>em;
		font-family:<?php legogl('subheading_font_goog', 'subheading_font'); ?>;
	}
	#signup h4 {
		font-size:<?php echo ($subheading_size*0.7); ?>em;
		font-family:<?php legogl('subheading_font_goog', 'subheading_font'); ?>;
	}

	#signup h2.social-heading,
	#signup label {
		font-family:<?php legogl('label_font_goog', 'label_font'); ?>;
		font-size:<?php le('label_size'); ?>em;
		font-weight:<?php lewt('label_style') ?>;
		font-style:<?php lestyle('label_style') ?>;
		color:<?php echo $label_color = ler('label_color'); ?>;
		text-shadow: <?php
			switch( get_option('label_effects') ) {
				case 'letterpress': echo $letterPress; break;
				case 'shadow': echo $textShadow; break;
				default: echo 'none';
			}
		?>;
	}

	#signup p,
	#signup span.calc,
	#privacy-policy p {
		font-size:<?php echo $desc_size = ler('description_size'); ?>em !important;
		font-family:<?php legogl('description_font_goog', 'description_font'); ?>;
		font-weight:<?php echo $desc_weight = ler('description_weight'); ?>;
		color:<?php echo $desc_color = ler('description_color'); ?>;
	}

	#presignup-content ul,
	#success-content ul,
	#signup ol,
	#signup-editor-content ul {
		font-size:<?php echo $desc_size; ?>em !important;
		font-family:<?php legogl('description_font_goog', 'description_font'); ?>;
		font-weight:<?php echo $desc_weight; ?>;
		color:<?php echo $desc_color; ?>;
		margin-left: 20px;
	}

	#signup ol li {
		list-style: decimal;
	}

	#presignup-content li,
	#success-content li,
	#signup-editor-content li {
		font-size: 1em;
		line-height:<?php echo $desc_size; ?>em !important;
		list-style: disc;
	}

/* Privacy Policy Modal
================================================== */

	span.privacy-policy {
		color:<?php echo $desc_color; ?>;
	}

	#privacy-policy {
		background-color: <?php echo (!($priv_bgcolor = ler('lefx_privacy_policy_bgcolor'))?'white':$priv_bgcolor); ?>;
	}

	#privacy-policy h2 {
		color:<?php echo $subheading_color; ?> !important;
	}

	#privacy-policy p {
		color:<?php echo $desc_color; ?> !important;
	}

	#privacy-policy a.close:hover {
		color:<?php echo darker('description_link_color'); ?> !important;
	}

/* Form
================================================== */

	#signup input#submit-button,
	#signup #submit-button-spinner {
		background-color:<?php echo $label_color; ?>;
	}

	#signup span#submit-button-border {
		border-color:<?php echo ($label_dark = darker('label_color')); ?>;
		background:<?php echo $label_dark; ?>;
	}

	#signup input#submit-button:hover {
		background-color:<?php echo $label_dark; ?>;
	}

/* Media Queries
================================================== */

	@media screen and <?php
		switch( ler('container_width') ) {
			case 'large': echo '(max-width: 768px) '; break;
			case 'medium': echo '(max-width: 590px) '; break;
			default: echo '(max-width: 420px) ';
		}
	?>{
		html,
		body{
			background-color:<?php echo ($ct_bg_color ? $ct_bg_color : $pg_bg_color); ?>;
		}
		<?php if ($heading_size > 5) : ?>

		#signup-page header {
			font-size: 0.7em;
		}
		<?php endif; ?>

	}
	<?php
	ob_end_flush();
	exit;
}
