<?php
/**
 * Functions
 *
 * @package WordPress
 * @subpackage Launch_Effect
 *
 */

/* Version
================================================== */
define("LE_VERSION", "2.41");
function lefx_version() {
	include('functions/version.php');
	$lefx_version = $version;
	return $lefx_version;
}

/* Create/Update tables upon theme activation
================================================== */
function theme_activation(){
	global $wpdb;

	$version_mode = lefx_version();
	$lefx_db_version = "1.1";
	$lefx_db_current = get_option('launcheffect_db_version');

	// Create stats table, and make it a constant
	$stats_table = $wpdb->prefix . "launcheffect";
	define('LE_TABLE', $stats_table);

	// Check for current version
	if((abs(($lefx_db_current-$lefx_db_version)/$lefx_db_version) > 0.00001) || get_option('lefx_version') != $version_mode) {
	    if($version_mode == 'premium') {
			$sql2 = "CREATE TABLE $stats_table (
				id mediumint(9) NOT NULL AUTO_INCREMENT,
				time VARCHAR(19) DEFAULT '0' NOT NULL,
				email VARCHAR(55),
				code VARCHAR(9),
				referred_by VARCHAR(9),
				visits int(10),
				conversions int(10),
				ip VARCHAR(20),
				UNIQUE KEY id (id),
				custom_field1 VARCHAR(2000),
				custom_field2 VARCHAR(2000),
				custom_field3 VARCHAR(2000),
				custom_field4 VARCHAR(2000),
				custom_field5 VARCHAR(2000),
				custom_field6 VARCHAR(2000),
				custom_field7 VARCHAR(2000),
				custom_field8 VARCHAR(2000),
				custom_field9 VARCHAR(2000),
				custom_field10 VARCHAR(2000)
			);";
		} else {
			$sql2 = "CREATE TABLE $stats_table (
				id mediumint(9) NOT NULL AUTO_INCREMENT,
				time VARCHAR(19) DEFAULT '0' NOT NULL,
				email VARCHAR(55),
				code VARCHAR(9),
				referred_by VARCHAR(9),
				visits int(10),
				conversions int(10),
				ip VARCHAR(20),
				UNIQUE KEY id (id)
			);";
		}
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql2);
		update_option("launcheffect_db_version", $lefx_db_version);
		update_option('lefx_version', $version_mode);
	}
}
add_action('after_setup_theme','theme_activation');

/* Enqueue CSS
================================================== */
function re_register_jquery(){
	global $wp_version;
	if ( is_admin() || in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php')) ) return;
	wp_enqueue_script( 'jquery' );
	// Check to see if we're on 3.6 or newer (changed the jQuery handle)
	$jquery_handle = ( version_compare( $wp_version, '3.6-alpha1', '>=' ) ? 'jquery-core' : 'jquery');
	$wp_jquery_ver = $GLOBALS['wp_scripts']->registered[$jquery_handle]->ver;
	$jquery_google_url = '//ajax.googleapis.com/ajax/libs/jquery/'.$wp_jquery_ver.'/jquery.min.js';
	wp_deregister_script( $jquery_handle );
	wp_register_script( $jquery_handle, $jquery_google_url, '', null, true );
}
add_action('init', 're_register_jquery');

/* Enqueue JS/CSS
================================================== */
function lefx_scripts() {
	$lefx_twitter_message = get_option('lefx_twitter_message');
	$lefx_twitter_message = (!empty($lefx_twitter_message)) ? $lefx_twitter_message : ler('heading_content');
	$meta_desc = str_replace(array("\r\n", "\r", "\t", "\n"), " ", ler('bkt_metadesc'));
	$sharing = array();
	
	if (get_option('lefx_disable_twitter') != 'true') $sharing[] = 'twttr';
	if (get_option('lefx_disable_facebook') != 'true') $sharing[] = 'FB';
	if (get_option('lefx_disable_plusone') != 'true') $sharing[] = 'gapi';
	if (get_option('lefx_disable_linkedin') != 'true') $sharing[] = 'IN';
	
	wp_register_style('lefx_css_main', get_template_directory_uri() . '/ss/launch-effect.min.css', false, LE_VERSION);
	wp_enqueue_style('lefx_css_main');

	wp_register_style('lefx_css_dynamic', admin_url('admin-ajax.php?action=dynamic_css'), false, get_theme_mod('lefx_dynamic_css_version','1.00'));
	wp_enqueue_style('lefx_css_dynamic');

	wp_register_script('lefx_js_googlewebfonts', 'https://ajax.googleapis.com/ajax/libs/webfont/1.0.22/webfont.js', array('jquery'), null );
	wp_enqueue_script('lefx_js_googlewebfonts');

	wp_register_script('lefx_js_init', get_template_directory_uri() . '/js/launch-effect.min.js', array('jquery'), LE_VERSION, true );
	wp_enqueue_script('lefx_js_init');

    wp_localize_script( 'lefx_js_init', 'wp_js', array(
		'themeDir' => get_template_directory_uri(),
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'blogURL' => home_url(),
		'meta_title' => wp_title( '|', false, 'right' ),
		'meta_description' => (!empty($meta_desc)?$meta_desc:get_bloginfo('description')),
		'twitterMessage' => $lefx_twitter_message,
		'sharing_enabled' => get_option('disable_social_media')=='true'?0:1,
		'sharing_platforms' => $sharing,
		'l10n' => array(
			'invalid_email' => __('This email address is invalid.', 'launcheffect'),
		),
	) );
}
add_action('wp_enqueue_scripts', 'lefx_scripts');

/**
 * Starts session, granting access to $_SESSION global
 */
function session_starter() {
	$session_duration = 24*60*60;
	$session_expire = ini_get("session.gc_maxlifetime");
	if ($session_expire < $session_duration) ini_set("session.gc_maxlifetime", $session_duration);
	if ( !session_id() ) session_start();
}
add_action( 'init', 'session_starter', 1);

/**
 * Destroys session, removing any data saved in the session
 */              
function session_kill() {
	session_destroy();
}
add_action( 'wp_logout', 'session_kill');
add_action( 'wp_login', 'session_kill');

/* Includes
================================================== */
// Create posts upon activation
if (isset($_GET['activated']) && is_admin() && current_user_can('edit_posts')){
	require_once(TEMPLATEPATH . '/functions/activation-posts.php');
}

// Premium functions.php
if (lefx_version() == 'premium') {
	require_once(TEMPLATEPATH . '/premium/functions.php');
	require_once(TEMPLATEPATH . '/premium/ajax-functions.php');
}

// Launch Effect functions
require_once(TEMPLATEPATH . '/functions/theme-functions.php');
require_once(TEMPLATEPATH . '/functions/ajax-functions.php');

// Functions to build admin options panels
require_once(TEMPLATEPATH . '/functions/optionspanel.php');
require_once(TEMPLATEPATH . '/functions/class-le-admin-page.php');

// MailChimp API
require_once(TEMPLATEPATH . '/inc/MCAPI.class.php');

// Aweber API
require_once(TEMPLATEPATH . '/inc/aweber/api/aweber_api.php');

// Campaign Monitor API
require_once(TEMPLATEPATH . '/inc/campaignmonitor/csrest_general.php');
require_once(TEMPLATEPATH . '/inc/campaignmonitor/csrest_lists.php');
require_once(TEMPLATEPATH . '/inc/campaignmonitor/csrest_clients.php');
require_once(TEMPLATEPATH . '/inc/campaignmonitor/csrest_subscribers.php');

// Functions to format get_options results
require_once(TEMPLATEPATH . '/functions/designer-functions.php');

// Designer > Global Settings admin options panel
require_once(TEMPLATEPATH . '/functions/designer-global.php');

// Designer > Sign-Up Page admin options panel
require_once(TEMPLATEPATH . '/functions/designer-launchmodule.php');

// Designer > Theme admin options panel
require_once(TEMPLATEPATH . '/functions/designer-pages.php');

// Designer > product admin options panel
require_once(TEMPLATEPATH . '/functions/designer-product.php');

// Integrations admin options panel
require_once(TEMPLATEPATH . '/functions/integrations.php');

// Admin stats panel
require_once(TEMPLATEPATH . '/functions/stats.php');

// Update default sizes
if (! get_option('lefx_pages_thumbnail_override') ) {
	update_option('thumbnail_size_w', 140);
	update_option('thumbnail_size_h', 80);
	update_option('thumbnail_crop', 1);
	update_option('medium_size_w', 470);
	update_option('medium_size_h', 9999);
}
if ( ! isset( $content_width ) ) $content_width = 780;

/* Enqueue Admin CSS & JS
================================================== */
function lefx_admin_scripts($hook){
	if (!strpos($hook, "lefx")) return;

    wp_register_style( 'lefx_css_admin_main', get_template_directory_uri() . '/functions/ss/launch-effect-admin.min.css', false, '1.0.0' );
    wp_enqueue_style( 'lefx_css_admin_main' );

	wp_register_script('lefx_js_admin_googlewebfonts', 'https://ajax.googleapis.com/ajax/libs/webfont/1.0.22/webfont.js', array('jquery'), '1.0' );
	wp_enqueue_script('lefx_js_admin_googlewebfonts');

	wp_register_script('lefx_js_admin_init', get_template_directory_uri() . '/functions/js/launch-effect-admin.min.js', array('jquery', 'jquery-ui-core', 'jquery-ui-widget', 'jquery-ui-datepicker', 'wp-color-picker'), '1.0' );
	wp_enqueue_script('lefx_js_admin_init');

    wp_localize_script( 'lefx_js_admin_init', 'wp_js', array(
		'themeDir' => get_template_directory_uri(),
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'delcol' => wp_create_nonce( 'remove-col-nonce' ),
	) );
	
	if ( function_exists('wp_enqueue_media')) {
		wp_enqueue_media(); 
	}
	wp_enqueue_style( 'wp-color-picker' );

}
add_action('admin_enqueue_scripts', 'lefx_admin_scripts');

function lefx_admin_inline_scripts(){
	// load up our inline javascript if jquery is enqueued
	if ( wp_script_is('jquery', 'done') && isset($_GET['page']) && strpos($_GET['page'], 'lefx_') !== FALSE) : ?>

	<script type="text/javascript">
		jQuery(document).ready(function($){
			var frame;
			
			/*
			 * Upload button click event, which builds the choose-from-library frame.
			 *
			 */
			$('.le-input').on('click', '.button-upload', function( event ) {
				var $el = $(this);
				event.preventDefault();

				// Create the media frame.
				frame = wp.media.frames.customHeader = wp.media({
					title: $el.data('choose'),
					library: { // broad spectrum upload types; do not hide anything
						type: 'image'
					},
					button: {
						text: $el.data('update'),
						close: true
					}
				});

				// When an image is selected, run a callback.
				frame.on( 'select', function() {
					// Grab the selected attachment.
					var attachment = frame.state().get('selection').first(),
						link = $el.data('updateLink');

					file = attachment.attributes.url;
					$el.next('input').val( file );
					$preview = $el.nextAll('.le-preview');
					if (!$preview.length) {
						$preview = $("<div class=\"le-preview\"></div>");
						$preview.appendTo( $el.parent() );
						$('<img/>').addClass('le-logopreview').appendTo($preview);
						$("<div class=\"clearfix\"></div>").insertAfter( $preview );
					}
					//file_ext = file.substr(file.lastIndexOf("."));
					$preview.find('img').attr('src', file);
					$el.val('Upload or Select Image');
				});

				frame.open();
			}).on( 'click', '.le-preview', function (){
				var $el = $(this),
					conf = confirm('This will remove the image as an option but will not delete the image from your library.');
				
				if (conf) {
					$el.parent().find('input[type="hidden"]').val('');
					$el.remove();
				}
			});

			if($('.awebersync').length) $('#aweberSync').appendTo('.awebersync').show();

			if($('.chimpsync').length) $('#chimpSync').appendTo('.chimpsync').show();

			if($('.cmsync').length) $('#cmSync').appendTo('.cmsync').show();

			//loaders
			$('#submitChimpSync').click(function(){
				$('#submit-button-loader').fadeIn('fast');
			});
			$('#submitCMSync').click(function(){
				$('#cm-submit-button-loader').fadeIn('fast');
			});
			$('#submitAWSync').click(function(){
				$('#aw-submit-button-loader').fadeIn('fast');
			});

			//update aweber
			$('.submit-select').change(function(e){
				$th = $(this);
				if($th.closest('div').hasClass('cmclient') && $th.val() == '')
					$('.cmsync').find('.submit-select').val('');

				$th.closest('form').submit();
			});

			$('#reset_aweber').click(function(){
				$auth = $('#aweber-authcode');
				$auth.val('');
				$auth.closest('form').submit();
			});

			/********* Custom Fields  *********/
			var LE_CF = {
				evalCustomOptions : function() {
					var $th = $(this),
						$field = $th.parent().next('.custom_field_opt');

					switch($th.val()) {
						case 'dropdown' :
						case 'radiobuttons' :
						case 'checkboxes' : $field.fadeIn(); break;
						default : $field.fadeOut(); break;
					}
				},
				fixOrdering : function (i){
					var $this = $(this),
						base = 'lefx_cust_field',
						base_replace = $this.find('input.customfield').attr('name'),
						old_idx = parseInt(base_replace.replace(base, '')),
						order = base_replace+'_order',
						cur_idx = i+1;

					if (i>=0) {
						if (i==0) $('.field_order').val('');
						$this.find('input[name="'+order+'"]').val(i);
						$this.find('input, label, select, .remove').each( function (){
							var $el = $(this),
								tag = this.tagName.toLowerCase();
						
							switch(tag){
							case 'label':
								tags = ['for'];
								break;
							case 'a':
								tags = ['rel'];
								break;
							default:
								tags = ['id','name'];
							}
							for (t=0;t<tags.length;t++){
								tagName = tags[t];
								target = $el.attr(tagName);
								if ( typeof(target) == 'undefined') continue;
								$el.attr(tagName, target.replace(base_replace, base+cur_idx));
							}
						});
					}
				}
			}

			$('.le-input.le-cf:first-child input').each( function (i){
				var $this = $(this),
					$parent = $this.parents('.le-sub_section'),
					$section = $parent.parent(),
					$added = $section.find('.le-sub_section.added');
				if ( $this.hasClass('populated') ) {
					$parent.addClass('added');
				} else {
					// hide all unreserved fields except first
					if ( !$parent.prev().hasClass('added')) $parent.hide();
				}
				
				// no saved fields, show first
				if ( $parent.is(':last-child') ) {
					if ($added.length == 0) $section.find('.le-sub_section:first-child').show();
				} 
				$('.le-sub_section', $section).each( LE_CF.fixOrdering );
				$parent.find('.custom_field_type :input').change(LE_CF.evalCustomOptions).change();
			});

			<?php if(lefx_version() == 'premium'):?>

			$('.add_custom_field-button').click(function(){
				$this = $(this);
				$limit = 10;
				$sp = $this.attr('rel').split('lefx_cust_field');
				$sp = $sp[1].split('_')[0];
				$parent = $this.closest('.le-sectioncontent');
				$sect = $this.closest('.le-sub_section');
				$next = $sect.nextAll(':not(.added)').eq(0);
				$count = $parent.find('.added').length;

				if (!$this.hasClass('remove')) {
					if ($next.length) {
						$sect.addClass('added');
						$next.show().addClass('added new-added');
						$this.html('<span>&times;</span> Remove Field').addClass('remove');

						if ($count == $limit - 1) {
							$next.find('.add_custom_field-button').hide();
						}
					}
					$('.le-sub_section.added', $parent).each( LE_CF.fixOrdering );
				} else {
					$confirm = confirm('Any data that users may have already entered will be lost.\n\nAre you sure you want to remove this column?');
					if ($confirm) {
						$sect.find('.customfield').val('');
						$sect.removeClass('added').hide();
						$this.html('<span>+</span>  Add Another Field').removeClass('remove');
						$parent.append($this.closest('.le-sub_section'));

						if ($count-1 <= $limit) {
							$parent.find('.added:last').find('.add_custom_field-button').show();
						}
						//ajax delete data
						$.post( wp_js.ajaxurl, {
							action: 'remove_col',
							nonce: wp_js.delcol,
							column: $sp
						}, function(data){
							if (data == 'success') {
								$sect.find('.custom_field_type select').val('textbox');
								$sect.find('.custom_field_opt input').val('');
								$sect.find('.field_order').val('');
								$sect.find('.le-check input').val('');
								$('.le-sub_section.added', $parent).each( LE_CF.fixOrdering );
								$sect.closest('form').submit();
							}
						});
					}
				}
			});

			/* TODO: Must determine a way to keep the data in sync with resort
			$('#lefx_cust_field1').parents('.le-sectioncontent').sortable({ 
				items: "> .le-sub_section",
				stop: function ( event, ui ) {
					$moved = ui.item;
					if (! $moved.hasClass('added') || $moved.hasClass('new-added') ) {
						$moved.addClass('added').removeAttr('style');
						$cf = $moved.find('input.customfield');
						if ( $cf.val() == '' ) $cf.val('Undefined');
						$moved.find('a.add_custom_field-button:not(.remove)').click();
					}
					
					$('.le-sub_section.added', $(this)).each( LE_CF.fixOrdering );
				}
			});
			*/

			<?php endif;?>
		});
	</script>
	<?php endif;
}
add_action('admin_footer', 'lefx_admin_inline_scripts');

/* Title Tag
================================================== */
function launcheffect_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'launcheffect' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'launcheffect_wp_title', 10, 2 );

/* Get First Image in a Post/Page
================================================== */
function getFirstPostImage($size = 'large') {
	global $post;

	$photos = get_children( array('post_parent' => $post->ID, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'DESC') );

	if ($photos) {
		$photo = array_shift($photos);
		$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', wp_get_attachment_image($photo->ID, $size), $matches);
		$first_img = $matches [1] [0];
		return $first_img;
	}

	return false;
}

/* Add Page Excerpt Support
================================================== */
add_action( 'init', 'my_add_excerpts_to_pages' );
function my_add_excerpts_to_pages() {
     add_post_type_support( 'page', 'excerpt' );
}

/* Re-enable mime type upload support for icons
================================================== */
class WP_MimeType_Rewrite{
	var $mimes = array(
		'ico' => 'image/vnd.microsoft.icon',
	);

	function __construct($args = null) {
		if ( is_admin() ) {
			add_filter('upload_mimes', array( &$this, 'add_custom_upload_mimes') );
		}		
	}

	function add_custom_upload_mimes($existing_mimes){
		return array_merge( $existing_mimes, $this->mimes);
	}
}
new WP_MimeType_Rewrite();
