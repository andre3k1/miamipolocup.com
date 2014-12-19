<?php 
/**
 * Functions: optionspanel.php
 *
 * Core functionality for all theme options pages
 *
 * @package WordPress
 * @subpackage Launch_Effect
 *
 */

add_action('wp_ajax_remove_col', 'remove_col' );

function remove_col() {
	// check nonce
	if ( ! wp_verify_nonce( $_POST['nonce'], 'remove-col-nonce' ) ) die( 'Wrong Action!');
	if ( ! is_user_logged_in() || !is_admin() ) die( 'Not logged in to admin!');

	$col_index = $_POST['column'];
	clearColumn(LE_TABLE, "custom_field$col_index");

	exit();
}

// A Weber List Generation ////////////////////
function aweber_get_list($consumerKey, $consumerSecret, $option){
	$listname = '';
	$aweber = new AWeberAPI($consumerKey, $consumerSecret);
	$access_msg = false;
	$token = get_option('lefx_awebertoken');
	$secret = get_option('lefx_awebersecret');

	# do the authentication process
	if (empty($token) || empty($secret)) {
		if ((empty($token) && empty($_GET['oauth_token'])) || empty($secret)) {

			# step 1: get a request token
			$callback = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			list($token, $secret) = $aweber->getRequestToken($callback);
			//setcookie('secret', $secret);
			update_option('lefx_awebersecret', $secret);
			//invalidate token
			update_option('lefx_awebertoken', '');

			try{
		        # step 2: prompt user to connect app
				$auth_url = $aweber->getAuthorizeUrl();
				echo "<a href='$auth_url'>Allow Access</a> <br /><small>Allow Launch Effect to access your AWeber subscriber lists.</small>";
				$access_msg = true;
			} catch(AWeberOAuthDataMissing $exc) {
				print "There is a problem. Your authorization code may be invalid. Please generate a new one by following the Authorize link above.";
			}
	    } else {
			# step 3: exchange request token for access token
			$aweber->user->tokenSecret = get_option('lefx_awebersecret');//$_COOKIE['secret'];
			$aweber->user->requestToken = $_GET['oauth_token'];
			$aweber->user->verifier = $_GET['oauth_verifier'];

			list($token, $secret) = $aweber->getAccessToken();

			update_option('lefx_awebersecret', $secret);
			update_option('lefx_awebertoken', $token);
		}
	    # redirect to self, so we can make api calls
	    //$app_url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	    //header('Location: '.$app_url);
	}

	# access the api
	if (!$access_msg) {
		try {
			$account = $aweber->getAccount($token, $secret);
			$account_id = $account->id;
			update_option('lefx_aweberaccountid',$account_id);
		} catch(AWeberAPIException $exc) {
			if($exc == "UnauthorizedError") {
				echo "Unauthorized Error: please obtain another authorization code";
			}
		}

		echo '<select name="' . $option['option_name'] . '"  class="submit-select"><option value="">Please Select a List</option>';
		foreach($account->lists as $list) {
			echo '<option value="' . $list->id . '"';

			if (get_option($option['option_name']) == $list->id) {
				echo ' selected="selected"';
				$listname = $list->name;
			}

			echo ">{$list->name} ({$list->total_subscribers} subscribers)</option>";
		}
		echo '</select>';
		echo "<small>{$option['desc']}</small>";
	}
}

function clearAweberOptions(){
	update_option('lefx_aweberconsumerkey', '');
	update_option('lefx_aweberconsumersecret', '');
	update_option('lefx_aweberaccesskey', '');
	update_option('lefx_aweberaccesssecret', '');
	update_option('lefx_awebertoken', '');
	update_option('lefx_awebersecret', '');
}

function lefx_form($optionspanel_name, $optionspanel_array) {

	// Custom Fields
	$premium = null;
	$aweber_custom_fields = array();
	$chimp_custom_fields = array();
	$cm_custom_fields = array();
	$custom_field_names = array();
	$mc_firstname = '';
	$mc_lastname = '';

	if (lefx_version() == 'premium') {
		$premium = array();
		$premium['fields'] = array();
		$premium['values'] = array();

		// Custom Fields
		for($i=1; $i<=10; $i++) {
			$option = trim(preg_replace('/[^a-zA-Z 0-9]+/', '', get_option("lefx_cust_field{$i}")));
			if( $option != '') {
				$is_name = $is_mcfirst = $is_mclast = false;
				$trimmed_opt = strtolower(trim($option));

				// MailChimp
				if ($trimmed_opt != 'first name' && $trimmed_opt != 'last name') {
					$chimp_custom_fields[$i] = array('tag' => "LEFIELD{$i}", 'name' => $option);
				} elseif($trimmed_opt == 'first name') {
					$is_mcfirst = 1;
					$chimp_custom_fields[$i] = array('tag' => "FNAME", 'name' => $option);
				} elseif(strtolower(trim(get_option("lefx_cust_field{$i}"))) == 'last name') {
					$is_mclast = 1;
					$chimp_custom_fields[$i] = array('tag' => "LNAME", 'name' => $option);
				}

				// Aweber
				$aweber_custom_fields[$i] = ($trimmed_opt != 'name') ? array(
					'name' => "LE " . str_replace(' ','_', $option)
				) : array(
					'name' => "name"
				);

				// Campaign Monitor
				if ($trimmed_opt != 'name') {
					$cm_custom_fields[$i] = array('name' => "LE " . $option);
					array_push($custom_field_names, "LE " . $option);
				} else {
					$cm_custom_fields[$i] = array('name' => "name");
				}
			}
		}
	}
	if (isset($_POST['reset'])) {
		update_option($optionspanel_name,'');
		foreach ($optionspanel_array as $key => $value) {
			foreach ($value as $subsection) {
				foreach ($subsection as $op) {
					update_option($op['option_name'],@$op['std']);
				}
			}
		}
	} ?>

	<form method="post" action="" enctype="multipart/form-data" onsubmit="return confirm('Are you really sure you want to reset the entire theme?  You will lose all of the custom styling and text content you have entered.  The theme will return to its default style.')">
		<span class="submit"><input name="reset" type="submit" value="Reset to Defaults" class="button button-primary"/></span>
		<input type="hidden" name="action" value="reset" />
	</form>
	<form method="post" action="options.php" enctype="multipart/form-data">
		<div id="le_floatnav">
			<ul>
				<li class="le-icons icon32 heading"><?php
					$tab_title = @$_GET['page'];
					if (isset($tab_title) && !empty($tab_title)) {
						switch($tab_title){
							case "lefx_integrations": echo "Integrations"; break;
							default: echo "Designer"; break;
						}
					}
				?></li>
				<?php foreach ($optionspanel_array as $key => $value) : ?>

				<li><a href="#<?php echo str_replace(' ', '', $key); ?>"><?php echo $key; ?></a></li>
				<?php endforeach; ?>

				<li><a href="#" id="FloatNavCollapse">Collapse All</a></li>
			</ul>
			<span class="submit"><input class="button" name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" /></span>
		</div>
		<?php settings_fields($optionspanel_name); ?>

		<a href="#" id="collapse-all">Collapse All</a>
		<?php foreach ($optionspanel_array as $key => $value): ?>

			<div class="le-section">
				<div class="le-title">
					<h3><?php echo $key; ?></h3>
					<span class="expand" id="<?php echo str_replace(' ', '', $key); ?>">+</span>
					<a href="http://www.launcheffectapp.com/premium" target="_blank" class="premiumbutton">Go Premium</a>
				</div>
				<div class="le-sectioncontent">
				<?php foreach ($value as $subsection): ?>

					<div class="le-sub_section">
					<?php foreach ($subsection as $op): ?>

						<div class="le-input<?php
							echo ' '.$op['class'];
							if($op['premium']=='section'&&lefx_version()=='free') echo ' premium-section';
							else if($op['premium']=='item'&&lefx_version()=='free') echo ' premium-item';
						?>">
							<label for="<?php echo $op['option_name']; ?>"><?php 
								echo $op['label'];
							?><br /><a href="http://www.launcheffectapp.com/premium" target="_blank" class="premiumlink">Go Premium &raquo;</a></label>

							<?php lefx_field($op, $optionspanel_name); ?>

						</div>
					<?php endforeach; ?>

					</div>
				<?php endforeach; ?>

				</div>
			</div>
		<?php endforeach; ?>
		<?php
		$new_lefx_dynamic_css_version = get_theme_mod('lefx_dynamic_css_version') + 0.01;
		set_theme_mod('lefx_dynamic_css_version',$new_lefx_dynamic_css_version);
		set_theme_mod('lefx_dynamic_css_last_modified',gmdate('D, d M Y H:i:s',time()).' GMT');
		?>

	</form>
	<?php 
	if ($tab_title == "lefx_integrations") {
		chimp_sync($aweber_custom_fields); 
		aweber_sync($aweber_custom_fields); 
		cm_sync($cm_custom_fields, $custom_field_names);
	}
}

function lefx_field($op, $optionspanel_name) {
	$opt_value = get_option($op['option_name']);
	$is_not_free = (in_array($op['premium'], array('section','item') ) && lefx_version() == 'free');
	$protected = array('datepicker', 'color', 'tinymce');
	$op['type'] = in_array($op['type'], $protected) && $is_not_free ? 'text' : $op['type'];

	// upgrade stored colors with inclusion of hash
	if ( 'color' == $op['type'] ) {
		$hash = ('#' == substr($opt_value, 0, 1));
		if (!$hash) {
			$opt_value = '#'.$opt_value;
			update_option($op['option_name'], $opt_value);
		}
	}
	
	switch( $op['type'] ) :	case 'color': ?>

			<input name="<?php echo $op['option_name']; ?>" type='text' value="<?php 
				if (!empty($opt_value)) echo stripslashes($opt_value); 
			?>" class="colorpicker" <?php if($is_not_free) echo 'disabled'; ?>/>
			<small><?php echo $op['desc']; ?></small>

		<?php break; case 'radio': ?>

			<small><?php echo $op['desc']; ?></small>
			<div class="radiobuttons">
			<?php

			$options = get_option($optionspanel_name);
			$optionname = $op['option_name'];
			$radioarray = $op['radioarray'];
			$radioimages = $op['radioimages'];

			foreach ($radioarray as $k => $option) {
				$firstfive = substr($option, 0, 5);
				$nospace = str_replace(' ','',$firstfive);
				vprintf('<label>%s<br/>%s<input type="radio" name="%s" class="%s" value="%s" %s %s /></label>', array(
					$radioimages[$k],
					$option,
					$optionname,
					$nospace,
					$option,
					(($opt_value == $option) ? ' checked="checked"' : ''),
					(($is_not_free) ? 'disabled' : ''),
				));
			} ?>
		
			</div>

		<?php break; case 'select': ?>

			<small><?php echo $op['desc']; ?></small>
			<?php
			$options = get_option($optionspanel_name);
			$optionname = $op['option_name'];
			$selectarray = $op['selectarray'];
			$sel_off = ($is_not_free)?'disabled':'';
			?>

			<select name="<?php echo $optionname; ?>" <?php echo $sel_off; ?>>
			<?php foreach ($selectarray as $option) : ?>
				<?php
				$firstfive = substr($option, 0, 5);
				$nospace = str_replace(' ','',$firstfive);
				$nospace = str_replace('"','',$nospace);
				$sel_sel = ($opt_value==$option)?'selected="selected"':''; 
				?>

				<option class="<?php echo $nospace; ?>" <?php echo $sel_sel; ?>><?php echo $option; ?></option>
			<?php endforeach; ?>

			</select>

			<?php // SUBTYPE: SELECTBOX: WEBFONTS //////////////////////////////
			if ($op['subtype'] == 'webfont') {
				$selectarray = $op['selectarray'];
				echo '<ul>';
				foreach ($selectarray as $selectarray) {
					if ($selectarray != '') {
						$firstfive = substr($selectarray, 0, 5);
						$nospace = str_replace(' ','',$firstfive);
						printf(
							'<li class="%s"><img src="%s/functions/im/webfont-previews/%s.png" alt="" /></li>%s', 
							$nospace, 
							get_template_directory_uri(), 
							$nospace,
							"\n"
						);
					}
				}
				echo '</ul>';
			} ?>

		<?php break; case 'chimpkey': ?>

			<div class="le-apply">
				<input name="<?php echo $op['option_name']; ?>" type='text' value="<?php echo $opt_value; ?>" />
				<span class="submit apply"><input class="button" name="Submit" type="submit" value="<?php esc_attr_e('Apply'); ?>" /></span>
			</div>
			<small>You can generate your API key by following these <a href="http://kb.mailchimp.com/article/where-can-i-find-my-api-key/" target="_blank">instructions</a> or by logging into MailChimp and navigating to Account &raquo; API Keys &amp; Authorized Apps.</small>

		<?php break; case 'chimplist': ?>

			<?php if(($chimpkey = get_option('lefx_mcapikey')) != '') :

				$api = new MCAPI($chimpkey);
				$chimplists = $api->lists(array(),0,100);
				$chimplists = $chimplists['data'];
				$optionname = $op['option_name'];

				// we are on the integrations page
				$can_chimp_sync = true;
				//echo '<pre>'; print_r($chimplists); echo '</pre>';
				echo '<select name="' . $optionname . '">';

				foreach($chimplists as $list) {
					echo '<option value="' . $list['id'] . '"';
					if ( $opt_value == $list['id']) {
						echo ' selected="selected"';
					}
					echo "> {$list['name']} ({$list['stats']['member_count']} members) </option>";
				}
				echo '</select>'; ?>

				<small>Select the subscriber list you'd like your Launch Effect signups to be added to and save your changes.  <?php if(!get_option('lefx_mclistid')) { ?><br />Once you save your changes, you will have the option to sync your existing Launch Effect entries to your MailChimp account.<?php } ?></small>
			<?php else: ?>

				<select disabled="disabled">
					<option>(API Key Undefined)</option>
				</select>
				<small>Enter your API key above and hit "Apply" in order for all of your subscriber lists to appear in the dropdown.</small>
			<?php endif; ?>

		<?php break; case 'cmkey': ?>

			<div class="le-apply">
				<input name="<?php echo $op['option_name']; ?>" type='text' value="<?php echo $opt_value; ?>" />
				<span class="submit apply"><input class="button" name="Submit" type="submit" value="<?php esc_attr_e('Apply'); ?>" /></span>
			</div>
			<small>You can generate your API key by following these <a href="http://www.campaignmonitor.com/api/getting-started/" target="_blank">instructions</a> or by logging into Campaign Monitor and navigating to Account Settings &raquo; Generate API Key.</small>

		<?php break; case 'cmclient': ?>

			<?php if(($cmkey = get_option('lefx_cmapikey')) != '') :

				$cmapi = new CS_REST_General($cmkey);
				$clients = $cmapi->get_clients();

				echo "<select name='{$op['option_name']}' class='submit-select'>";
				echo "<option value=''>Please Select a Client</option>";
				foreach($clients->response as $client) {
					$selected = '';
					if($client->ClientID == get_option('lefx_cmclientid')) {
						$selected = 'selected';
					}
					echo "<option value='{$client->ClientID}' $selected>{$client->Name}</option>";
				}
				echo "</select>";

				?>

				<small></small>
			<?php else : ?>

				<select disabled="disabled">
					<option>(API Key Undefined)</option>
				</select>
				<small>Enter your API key above and hit "Apply" in order for all of your subscriber lists to appear in the dropdown.</small>

			<?php endif; ?>

		<?php break; case 'cmlist': ?>

			<?php if(($cmkey = get_option('lefx_cmapikey')) != '' && ($cmclient = get_option('lefx_cmclientid')) != '') :

				$cmapi = new CS_REST_General($cmkey);
				$cmclient = new CS_REST_Clients($cmclient, $cmkey);
				$lists = $cmclient->get_lists();

				echo "<select name='{$op['option_name']}' class='submit-select'>";
				echo "<option value=''>Please Select a List</option>";
				print_r($lists->response);
				foreach($lists->response as $list)
				{
					$selected = '';
					if($list->ListID == get_option('lefx_cmlistid'))
					{
						$selected = 'selected';
					}
					echo "<option value='{$list->ListID}' $selected>{$list->Name}</option>";
				}
				echo "</select>";
				?>

				<small></small>
			<?php else : ?>

				<select disabled="disabled">
					<option>(Client Undefined)</option>
				</select>
				<small>Enter your API key above and hit "Apply" in order for all of your subscriber lists to appear in the dropdown.</small>
			<?php endif; ?>

		<?php break; case 'aweberauthurl': ?>
		
			<?php 
				$auth_url = get_template_directory_uri() .  '/inc/aweber/authorize.php';
				echo $op['desc'],  "<br/ ><a href='$auth_url' target='_blank'>Authorize Launch Effect</a>";

				// we are on the integrations page
				$can_aweber_sync = true;
			?>

		<?php break; case 'aweberauthcode': ?>

			<?php
				$consumerKey = get_option('lefx_aweberconsumerkey');
				$consumerSecret = get_option('lefx_aweberconsumersecret');
			?>
			<?php if(($op['premium'] == true && lefx_version() == 'premium') || ($op['premium'] == false)): ?>

			<div class="le-apply">

				<?php if( $opt_value == '' || $consumerKey == '' || $consumerSecret == ''): ?>

				<input name="<?php echo $op['option_name']; ?>" type='text' value="<?php echo $opt_value; ?>" id="aweber-authcode" />
				<span class="submit apply"><input class="button" name="Submit" type="submit" value="<?php esc_attr_e('Apply'); ?>" /></span>
				<?php else: ?>

				<input name="<?php echo $op['option_name']; ?>" type='text' value="<?php echo $opt_value; ?>" id="aweber-authcode" readonly="readonly" />
				<span class="submit apply"><input class="button" name="Submit" type="button" value="<?php esc_attr_e('Reset'); ?>" id="reset_aweber" /></span>
				<?php endif; ?>

			</div>
			<small><?php echo $op['desc']; ?></small>
			<?php endif; ?>

		<?php break; case 'aweberlist': ?>

			<?php
				$authCode = get_option('lefx_aweberauthcode');
				$consumerKey = get_option('lefx_aweberconsumerkey');
				$consumerSecret = get_option('lefx_aweberconsumersecret');

				if (empty($authCode)) {
					clearAweberOptions();
					echo 'No Authorization Code.';
				} elseif(!empty($consumerKey) && !empty($consumerSecret)) {
					//access
					aweber_get_list($consumerKey, $consumerSecret, $op);
				} else {
					try {
					    # set authCode to the code that is given to you from
					    # https://auth.aweber.com/1.0/oauth/authorize_app/YOUR_APP_ID

					    $auth = AWeberAPI::getDataFromAweberID($authCode);
					    list($consumerKey, $consumerSecret, $accessKey, $accessSecret) = $auth;

						update_option('lefx_aweberconsumerkey', $consumerKey);
						update_option('lefx_aweberconsumersecret', $consumerSecret);
						update_option('lefx_aweberaccesskey', $accessKey);
						update_option('lefx_aweberaccesssecret', $accessSecret);


					    # Store the Consumer key/secret, as well as the AccessToken key/secret
					    # in your app, these are the credentials you need to access the API.

					    if(!$consumerKey || !$consumerSecret)
						{
							print "Your authorization code may be invalid.  Please generate a new one by following the Authorize link above.";
						}
					}
					catch(AWeberAPIException $exc) {
					    print "<h3>AWeberAPIException:</h3>";
					    print " <li> Type: $exc->type              <br>";
					    print " <li> Msg : $exc->message           <br>";
					    print " <li> Docs: $exc->documentation_url <br>";
					    print "<hr>";
					}
					catch(AWeberOAuthDataMissing $exc)
					{
						print "Your authorization code may be invalid.  Please generate a new one by following the Authorize link above.";
					}
					aweber_get_list($consumerKey, $consumerSecret,  $op);

				}
			?>

		<?php break; case 'information': ?>

			<?php echo $op['desc']; ?>

		<?php break; case 'text': ?>

			<input name="<?php echo $op['option_name']; ?>" type='text' value="<?php echo $opt_value; ?>" <?php if($is_not_free) echo 'disabled'; ?> />
			<small><?php echo $op['desc']; ?></small>

		<?php break; case 'text-small': ?>

			<input name="<?php echo $op['option_name']; ?>" type='text' value="<?php echo $opt_value; ?>" <?php if($is_not_free) echo 'disabled'; ?> class="small" />
			<small class="text-small"><?php echo $op['desc']; ?></small>

		<?php break; case 'instructions': ?>

			<small class="instructions"><?php echo $op['desc']; ?></small>

		<?php break; case 'textarea': ?>

			<?php $descriptionText = $opt_value; ?>
			<textarea name="<?php echo $op['option_name']; ?>" type='text' value="<?php echo htmlentities($descriptionText); ?>" <?php if($is_not_free) echo 'disabled'; ?>/><?php echo ($descriptionText); ?></textarea>
			<small><?php echo $op['desc']; ?></small>

		<?php break; case "tinymce": ?>
				
			<div class="editor-container clear"><?php wp_editor($opt_value, $op['option_name'], array('textarea_name' => $op['option_name']) ); ?></div>

		<?php break; case 'image': ?>

			<input type="button" class="button-primary button-upload" value="Upload or Select Image" <?php if($is_not_free) echo 'disabled'; ?>/>
			<input type="hidden" name="<?php echo $op['option_name']; ?>" value="<?php echo $opt_value; ?>" />
			<small><?php echo $op['desc']; ?></small>
			<?php if (isset($op['option_disable'])): $opt_disable = get_option($op['option_disable']);?>

			<div class="le-check-delete clearfix">
				<?php $checked = ($opt_disable == true) ? "checked=\"checked\"" : ""; ?>
				<input type="checkbox" name="<?php echo $op['option_disable']; ?>" id="<?php echo $op['option_disable']; ?>" value="true" <?php echo $checked; ?> <?php if($is_not_free) echo 'disabled'; ?>/>
				<label for="<?php echo $op['option_disable']; ?>">Check to disable <?php echo $op['label']; ?>.</label>
			</div>
			<?php else: ?>

			<div class="clearfix"></div>
			<?php endif; ?>

			<?php if(!empty($opt_value)) printf('<div class="le-preview"><img src="%s" class="le-logopreview" /></div>', $opt_value); ?>

		<?php break; case 'check': ?>

			<?php $checked = ($opt_value == true) ? "checked=\"checked\"" : ""; ?>
			<input type="checkbox" name="<?php echo $op['option_name']; ?>" id="<?php echo $op['option_name']; ?>" value="true" <?php echo $checked; ?> <?php if($is_not_free) echo 'disabled'; ?>/>
			<small class="clearfix" style="float:left;width:auto;"><?php echo $op['desc']; ?></small>

		<?php break; case 'datepicker': ?>

			<input name="<?php echo $op['option_name']; ?>" type="text" class="datepicker" value="<?php
				if (!empty($opt_value)) echo stripslashes($opt_value);
				else echo date("m/d/Y");
			?>" <?php if($is_not_free) echo 'disabled'; ?> />

		<?php break; case 'customfield': ?>

			<input name="<?php echo $op['option_name']; ?>" id="<?php echo $op['option_name']; ?>" type="text" class="customfield<?php 
				echo (!empty($opt_value) ? ' populated' : ''); 
			?>" value="<?php
				if (!empty($opt_value)) echo stripslashes($opt_value); 
			?>" <?php if($is_not_free) echo 'disabled '; ?>/>
			<small><?php echo $op['desc']; ?>

			<?php if(get_option('lefx_aweberlistid') != '' && get_option('lefx_aweberconsumerkey') != '' && get_option('lefx_aweberconsumersecret') != ''):?>

			<br /><br /><strong>AWEBER NOTE:</strong> AWeber only allows 100 characters for custom fields.  Entries that are longer will be truncated in the AWeber database.</small>
			<?php endif;?>

			</small>

		<?php break; case 'customfield_type': ?>

			<select name="<?php echo $op['option_name']; ?>" id="<?php echo $op['option_name']; ?>" <?php if(lefx_version() == 'free') echo 'disabled'?>>
				<?php foreach($op['selectarray'] as $opt): $split = explode(' ',$opt); $val = strtolower($split[0] . $split[1]); ?>

				<option value="<?php echo $val;?>" <?php if($opt_value == $val) echo 'selected'; ?>><?php echo $opt; ?></option>
				<?php endforeach; ?>

			</select>
			<small><?php echo $op['desc']; ?></small>

		<?php break; case 'customfield_req': ?>

			<input type="checkbox" name="<?php echo $op['option_name']; ?>" id="<?php echo $op['option_name']; ?>" <?php echo ($opt_value == "on") ? "checked" : ""?> />
			<?php $n = trim(trim($op['option_name'], "_required"), "lefx_cust_field"); ?>
			<a href="javascript:void(0);" class="add_custom_field-button  <?php if(lefx_version() == 'free') echo 'disabled'?> <?php if(get_option("lefx_cust_field$n") != '') echo 'remove' ?>" rel="<?php echo $op['option_name']; ?>"> <?php echo (get_option("lefx_cust_field$n") == '') ? '<span>+</span> Add Another Field' : '<span>&times;</span> Remove Field'  ?> </a>

		<?php break; case 'customfield_order': ?>

			<input type="hidden" name="<?php echo $op['option_name']; ?>" value="" class="field_order"/>

		<?php break; case 'prod-opt-name': ?>

			<input name="<?php echo $op['option_name']; ?>" type='text' value="<?php echo $opt_value; ?>" <?php if($is_not_free) echo 'disabled'; ?> />

		<?php break; case 'prod-opt-price': ?>

			<input name="<?php echo $op['option_name']; ?>" type='text' value="<?php echo $opt_value; ?>" <?php if($is_not_free) echo 'disabled'; ?> />

		<?php break; ?>
	
	<?php endswitch;
	
}

function chimp_sync($chimp_custom_fields){
	$mc_list_id = get_option('lefx_mclistid');
	$mc_api_key = get_option('lefx_mcapikey');
	if (empty($mc_list_id) || empty($mc_api_key)) return; 
	$api = new MCAPI($mc_api_key); ?>

	<div id="chimpSync">
		<?php
			$chimplists = $api->lists(array(),0,100);
			$chimplists = $chimplists['data'];

			foreach($chimplists as $chimplist) {
				if($chimplist['id'] == $mc_list_id) {
					$chimplistname = $chimplist['name'];
				}
			}

			$chimplists = array_flatten($chimplists);
		?>
		<?php if (in_array($mc_list_id, $chimplists, true)): ?>

		<label>Sync Data [Beta]</label>
		<form action="" method="post" id="chimpBatchSync">
			<input name="chimplist" type="hidden" value="<?php echo $mc_list_id; ?>" />
			<span class="submit apply"><input class="button" name="Submit" type="submit" value="Sync Launch Effect &rarr; MailChimp: <?php echo $chimplistname; ?>"  style="width:auto !important; padding-right:10px; padding-left:10px; margin-left:0px;" id="submitChimpSync"/></span>
			<input type="image" id="submit-button-loader" src="<?php echo get_template_directory_uri(); ?>/functions/im/spinner.gif" />
		</form>
		<?php
			$chimpvars = $api->listMergeVars($mc_list_id);
			$mc_tags = array();
			$mc_names = array();
			foreach ($chimpvars as $var) {
				array_push($mc_tags, $var['tag']);
				array_push($mc_names, $var['name']);
			}

			$chimpvars = array_flatten($chimpvars);
			$chimps = $api->listMembers($mc_list_id, 'unsubscribed');
			$chimpemails = array();
			foreach ($chimps['data'] as $key => $values) {
				$values['email'] = "'" . $values['email'] . "'";
			  	array_push($chimpemails, $values['email']);
			}

			$chimpemails = implode(', ', $chimpemails);

			if (isset($_POST['chimplist'])) {

				if (!in_array('LECODE', $chimpvars, true)) {
					$api->listMergeVarAdd($_POST['chimplist'], 'LECODE', 'LE Referral Code', array('public' => false));
					$api->listMergeVarAdd($_POST['chimplist'], 'LEVISITS', 'LE Visits', array('public' => false));
					$api->listMergeVarAdd($_POST['chimplist'], 'LESIGNUPS', 'LE Signups', array('public' => false));
				}

				if(empty($chimpemails)) {
					$stats = getData(LE_TABLE);
				} else {
					$stats_table = LE_TABLE;
					$stats = wpdbQuery("SELECT * FROM $stats_table WHERE email NOT IN ($chimpemails) ORDER BY time DESC", 'get_results');
				}

				foreach ($stats as $stat) {
					$email = $stat->email;
					$code = $stat->code;
					$ip = $stat->ip;
					$clicks = $stat->visits;
					$conversions = $stat->conversions;
					$data = array(
						'EMAIL'=>$email, 
						'EMAIL_TYPE'=>'html', 
						'LECODE'=>$code, 
						'LEVISITS'=>$clicks, 
						'LESIGNUPS'=>$conversions
					);

					// add custom fields
					/*
					foreach($chimp_custom_fields as $k=> $field)
					{
						if (!in_array($field['tag'], $chimpvars, true)) {

							$api->listMergeVarAdd($_POST['chimplist'], $field['tag'], $field['name'], array('public' => false));
						}
						$fieldname = "custom_field$k";
						$data[$field['tag']] = $stat->{$fieldname};
					}
					*/
					if (count($chimp_custom_fields)) {
						foreach($chimp_custom_fields as  $k=> $field){
							$pos = array_search($field['tag'], $mc_tags);

							if ($pos === false) {
								$api->listMergeVarAdd($_POST['chimplist'], $field['tag'], $field['name'], array('public' => false));
							} elseif ($mc_names[$pos] != $field['name']) {
								$api->listMergeVarUpdate($_POST['chimplist'], $field['tag'], array('name' => $field['name']));
							}

							$fieldname = "custom_field$k";
							$data[$field['tag']] = $stat->{$fieldname};
						}
					}
					$batch[] = $data;
				}

				$opt_in = (get_option('lefx_mcdouble') == true) ? false : true;
				$up_exist = true;
				$replace_int = false;
				$vals = $api->listBatchSubscribe($_POST['chimplist'], $batch, $opt_in, $up_exist, $replace_int);

				if ($api->errorCode){
					echo '<div id="chimpSyncErrors"><h3>Oh No! Sync Failed.</h3><p><strong>Error Code:</strong> ' . $api->errorCode . '<br /><strong>Reason:</strong> ' . $api->errorMessage . '</p></div>';
				} else {

					if ($vals['error_count'] < 1) {
						echo '<div id="chimpSyncSuccess"><h3>Great Success! Sync Summary:</h3><p><strong>Added:</strong> ' . $vals['add_count'] . '<br /><strong>Updated:</strong> ' . $vals['update_count'] . '</p></div>';
					} else {
						echo '<div id="chimpSyncSummary"><h3>Moderate Success! Sync Summary:</h3><p><strong>Added:</strong> ' . $vals['add_count'] . '<br /><strong>Updated:</strong> ' . $vals['update_count'] . '</p><p><span class="error"><strong>Errors:</strong> ' . $vals['error_count'] . ' (see below)<br />';
						foreach($vals['errors'] as $val){
							if(isset($val['email_address'])) {
								echo $val['email_address'] . '&mdash;';
							}
							echo $val['message'] . '<br />';
						}
						echo '</span></p></div>';
					}
				}
			}
		?>
		<small>Click to add existing Launch Effect emails to your MailChimp account, and sync visit and conversion values from Launch Effect to MailChimp.  Please note, if you have a large list, syncing could take a few minutes.<br /><br /><strong>IMPORTANT MAILCHIMP SYNC CAVEAT</strong><br />MailChimp does not expose any data about users that are unconfirmed, e.g. people that have been sent a double opt-in request yet never opted-in nor opted-out.  Therefore, there is no way for us to filter these people from the sync.  If you have double opt-in enabled, these unconfirmed users will receive an email from MailChimp again asking them if they would like to confirm their subscription.  If you do not have double opt-in enabled, these users will be automatically added to your MailChimp list even though they did not confirm their opt-in in your previous request (nor did they deny it).</small>
		<?php endif;?>

	</div>
	<?php 
}

function aweber_sync($aweber_custom_fields){
	$aweberListId = get_option('lefx_aweberlistid');
	$aweberConsumerKey = get_option('lefx_aweberconsumerkey');
	$aweberConsumerSecret = get_option('lefx_aweberconsumersecret');
	if (empty($aweberListId) || empty($aweberConsumerKey) || empty($aweberConsumerSecret)) return;

	$aweber = new AWeberAPI($aweberConsumerKey, $aweberConsumerSecret);
	$account = $aweber->getAccount(get_option('lefx_aweberaccesskey'), get_option('lefx_aweberaccesssecret'));
	$aweberAccountId = get_option('lefx_aweberaccountid');
	$listURL = "/accounts/{$aweberAccountId}/lists/{$aweberListId}";
	$list = $account->loadFromUrl($listURL);
	$has_cust_fields = count($aweber_custom_fields);
	?>

	<div id="aweberSync">
		<label>Sync Data [Beta]</label>
			<form action="" method="post" id="aweberBatchSync">
			<input name="aweberlistsync" type="hidden" value="<?php echo $aweberListId; ?>" />
			<span class="submit apply"><input name="Submit" type="submit" value="Sync Launch Effect &rarr; AWeber: <?php echo $list->name ?>" class="button" style="width:auto !important; padding-right:10px; padding-left:10px; margin-left:0px;" id="submitAWSync"/></span>
			<input type="image" id="aw-submit-button-loader" src="<?php echo get_template_directory_uri(); ?>/functions/im/spinner.gif" />
			</form>
		<br />
		<?php
		if(isset($_POST['aweberlistsync'])) {
			$added=0;
			$updated=0;
			$unverified=0;
			$init_errors=array();
			$errors=array();
			$aweberemails = array();

			// add new subscribers
			$stats = getData(LE_TABLE);
			try {
				$le_fields = array('LE Referral Code', 'LE Visits', 'LE Signups');
				$custom_fields = $list->custom_fields;
				$existing_field_names = array();
				foreach($custom_fields as $field) array_push($existing_field_names, $field->name);
				foreach($le_fields as $fieldname) {
					// Aweber will not allow additional name fields
					if(!in_array($fieldname, $existing_field_names))
			    		$custom_fields->create(array('name' => $fieldname));
			    }
				foreach($aweber_custom_fields as $field) {
					// Aweber will not allow additional name fields
					if($field['name'] != 'name' && !in_array($field['name'], $existing_field_names)) {
			    		$custom_fields->create(array('name' => $field['name']));
			    	}
			    }
			} catch(AWeberAPIException $exc) {
				array_push($init_errors, array('message' => $exc->message));
			}

			if(count($init_errors)) {
				echo '<div id="chimpSyncErrors"><h3>Oh No! Sync Failed.</h3><p><strong>Reason:</strong> ' . $init_errors['message'] . '</p></div>';
			} else {
				$subscribers = $list->subscribers;

				foreach ($stats as $stat) {
					$email = $stat->email;
					$code = $stat->code;
					$ip = $stat->ip;
					$clicks = $stat->visits;
					$conversions = $stat->conversions;

					try {
					    $params = array('email' => $email);
					    $found_subscribers = $subscribers->find($params);
					    $aweb_fn = $aweb_ln = '';

					    if(count($found_subscribers)) {
							foreach($found_subscribers as $subscriber) {
								//can only update verified subscribers
								if($subscriber->is_verified) {
									$updated++;

									$subscriber->custom_fields['LE Visits'] = $clicks;
									$subscriber->custom_fields['LE Referral Code'] = $code;
									$subscriber->custom_fields['LE Signups'] = $conversions;
									$subscriber->save();
								} else {
									$unverified++;
								}
							}
						} else {
						    // create a subscriber
						    $params = array(
						        'email' => $email,
						        'ip_address' => $_SERVER['REMOTE_ADDR'],
						        'ad_tracking' => 'launch_effect',
						        'last_followup_message_number_sent' => 0,
						        'misc_notes' => 'launch effect subscription',
								'custom_fields' => array(
						            'LE Referral Code' => $code,
						            'LE Visits' => "$clicks",
						            'LE Signups' => "$conversions",
						        ),
						    );
						    foreach($aweber_custom_fields as $k => $field) {
						    	$fieldname = "custom_field$k";
						    	$stat_field = $stat->{$fieldname};

						    	if($stat_field && $stat_field != "" && $stat_field != null) {

									if($field['name'] != 'name') {
										if(strtolower($field['name']) == 'le first_name') {
											$aweb_fn = $stat_field;
										} else if (strtolower($field['name']) == 'le last_name') {
											$aweb_ln = $stat_field;
										}

										$params['custom_fields'][$field['name']] =	substr($stat_field,0,100);
									} else $params['name'] = substr($stat_field,0,100);
								}
							}
						    if(!isset($params['name']) && ($aweb_fn != '' || $aweb_ln != '')) {
						    	$params['name'] = substr(trim($aweb_fn . ' ' . $aweb_ln), 0, 100);
						    }

				   			$new_subscriber = $subscribers->create($params);
				   			$added++;
						}

					} catch(AWeberAPIException $exc) {
						array_push($errors, array('message' => $exc->message, 'email_address' => $email));
					} catch(AWeberOAuthDataMissing $exc) {
						print "AuthDataMissing";
					}

				} ?>

				<?php if(!count($errors)) : ?>

					<div id="chimpSyncSuccess">
						<h3>Great Success! Sync Summary:</h3>
						<p><strong>Added:</strong> <?php echo $added; ?>
						<br /><strong>Updated:</strong> <?php echo $updated; ?>
						<br /><strong>Unverified:</strong> <?php echo $unverified; ?><br /></p>
					</div>

				<?php else : ?>

					<div id="chimpSyncSummary">
						<h3>Moderate Success! Sync Summary:</h3>
						<p><strong>Added:</strong> <?php echo $added; ?>
						<br /><strong>Updated:</strong> <?php echo $updated; ?>
						<br /><strong>Unverified:</strong> <?php echo $unverified; ?><br /></p>
					<p><span class="error"><strong>Errors:</strong> <?php echo count($errors); ?> (see below)<br /><?php
					foreach($errors as $val){
						if(isset($val['email_address'])) {
							echo $val['email_address'] . '&mdash;';
						}
						echo $val['message'] . '<br />';
					}
					echo '</span></p></div>'; ?>

				<?php endif;
			}
		}
		?>
		<small>Click to add existing Launch Effect emails to your AWeber account, and also to sync visit and conversion values from Launch Effect to AWeber.<br /><br /><strong>Warning:</strong> for those who signed up through Launch Effect prior to the activation of the AWeber integration, syncing will automatically send them an opt-in message message from AWeber<br /><br />
		If you have a large list, syncing could take a few minutes.<br /><br />

		<?php if($has_cust_fields): ?>
		<strong>CUSTOM FIELDS NOTE:</strong> AWeber only allows 100 characters for custom fields.  Entries that are longer will be truncated in the AWeber database.<br /><br />
		<?php endif; ?>
		<strong>BETA NOTE:</strong> Help us improve this feature!  If you're experiencing any issues, we'd really love to hear about them.  Feel free to drop us a line at our <a href="http://launcheffect.tenderapp.com">support desk</a>.</small>
	</div>
	<?php
}

function cm_sync($cm_custom_fields, $custom_field_names){
	$cmapikey = get_option('lefx_cmapikey');
	$cmclientid = get_option('lefx_cmclientid');
	$cmlistid = get_option('lefx_cmlistid');
	
	if ( empty($cmapikey) || empty($cmapikey) || empty($cmapikey)) return;
	$cmlist = new CS_REST_Lists($cmlistid, $cmapikey);
	$monlist = $cmlist->get()->response; ?>
	<?php if(isset($monlist->Title)) : $cmlistname = $monlist->Title; ?>

	<div id="cmSync">
		<label>Sync Data [Beta]</label>
		<form action="" method="post" id="aweberBatchSync">
			<input name="cmlistsync" type="hidden" value="<?php echo $cmlistid; ?>" />
			<span class="submit apply"><input class="button" name="Submit" type="submit" value="Sync Launch Effect &rarr; Campaign Monitor: <?php echo $cmlistname ?>"  style="width:auto !important; padding-right:10px; padding-left:10px; margin-left:0px;" id="submitCMSync" /></span>
			<input type="image" id="cm-submit-button-loader" src="<?php echo get_template_directory_uri(); ?>/functions/im/spinner.gif" />
		</form>
		<br />
		<small>Click to add existing Launch Effect emails to your Campaign Monitor account, and also to sync visit and conversion values from Launch Effect to Campaign Monitor.<br /><br /><strong>Warning:</strong> for those who signed up through Launch Effect prior to the activation of the Campaign Monitor integration, syncing will automatically send them an opt-in message message from Campaign Monitor<br /><br />If you have a large list, syncing could take a few minutes.<br /><br /></small>
	<?php
		if(isset($_POST['cmlistsync'])) {
			$subscribers = new CS_REST_Subscribers($cmlistid, $cmapikey);
			$cust_fields = $cmlist->get_custom_fields();
			$active_subs = $cmlist->get_active_subscribers('1970-01-01');
			$sub_emails = array();

			foreach ($active_subs->response->Results as $sub) array_push($sub_emails, $sub->EmailAddress);

			$existing_fields = $cust_fields->response;
			$added = 0;
			$updated = 0;
			$errors = array();

			// add new subscribers
			$stats = getData(LE_TABLE);

			$le_fields = array('LE Referral Code', 'LE Visits', 'LE Signups');
			$custom_field_names = array_merge($custom_field_names, $le_fields);

			if($custom_field_names) {
				foreach($existing_fields as $field) {
					$pos = array_search($field->FieldName, $custom_field_names);
					if($pos !== false) unset($custom_field_names[$pos]);
				}
				foreach($custom_field_names as $name) {
					$result = $cmlist->create_custom_field(array(
					    'FieldName' => $name,
					    'DataType' => CS_REST_CUSTOM_FIELD_TYPE_TEXT
					));
				}
			}

			foreach($stats as $stat) {
				$email = $stat->email;
				$code = $stat->code;
				$ip = $stat->ip;
				$clicks = $stat->visits;
				$conversions = $stat->conversions;
				$cm_name = $cm_ln = $cm_fn = '';
				$cm_custom_field_values = array(
					array('Key' => 'LE Referral Code', 'Value' => $code),
					array('Key' => 'LE Visits', 'Value' => $clicks),
					array('Key' => 'LE Signups', 'Value' => $conversions),
				);

				foreach($cm_custom_fields as $k => $field) {
					$fieldname = "custom_field$k";
			    	$stat_field = $stat->{$fieldname};
			    	if($field['name'] != 'name') {
			    		if(strtolower($field['name']) == 'le first name') $cm_fn = $stat->{$fieldname};
						else if(strtolower($field['name']) == 'le last name') $cm_ln = $stat->{$fieldname};

						array_push($cm_custom_field_values, array(
							'Key' => $field['name'],
							'Value' => $stat->{$fieldname}
						) );
					} else {
						$cm_name = $stat->{$fieldname};
					}
				}

				if($cm_name == '' && ($cm_fn != '' || $cm_ln != '')) $cm_name = trim($cm_fn . ' ' . $cm_ln);

				// add works as update in Campaign Monitor
				$result = $subscribers->add( array(
			    	'EmailAddress' => $email,
			    	'Name' => $cm_name,
			    	'CustomFields' => $cm_custom_field_values,
			    	'Resubscribe' => true
				) );

				// iterate counts
				if($result->http_status_code == 201) {
					if(in_array($email, $sub_emails)) $updated++;
					else $added++;
				} else array_push($errors, $email);
			}

			//success message ?>
			<?php if(!count($errors)) : ?>

				<div id="chimpSyncSuccess">
					<h3>Great Success! Sync Summary:</h3>
					<p><strong>Added:</strong><?php echo $added; ?><br /><strong>Updated:</strong><?php echo $updated; ?><br /></p>
				</div>
			<?php else : ?>

				<div id="chimpSyncSummary">
					<h3>Moderate Success! Sync Summary:</h3>
					<p><strong>Added:</strong><?php echo $added; ?><br /><strong>Updated:</strong><?php echo $updated; ?></p>
					<p><span class="error"><strong>Errors:</strong><?php echo count($errors); ?> (see below)<br />
					<span>The following emails could not be synched: <?php echo implode(",", $errors); ?></span></p>
				</div>
			<?php endif;
		}
	?>

	</div>
	<?php endif;
}
