<?php
/**
 * Functions: class-le-admin-page.php
 *
 * A simple class to build the theme options pages
 * the class can be extended to change out settings and copy.
 *
 * @package WordPress
 * @subpackage Launch_Effect
 * @author Wes Turner
 * @version 1.0.0
 * @since 01.09.2014 
 *
 */

if(!class_exists('LE_Admin_Page')) {
	/**
	 * @usage
	 *		The construct function of this class accepts a single argument
	 *		in the form of an associative array.
	 *
	 *		$args = array(
	 *			'title' => 'Page Title', // option page title
	 *			'name' => 'menu_slug', // menu slug of page
	 *			'options' => array(), // full array of options
	 *		);
	 *		new LE_Admin_Page($args);
	 * @endusage
	 */
	class LE_Admin_Page {
		var $panel_title, $panel_name, $panel_array, $suppress_submenu = true;
	
		function __construct($args){
			$this->panel_title = $args['title'];
			$this->panel_name = $args['name'];
			$this->panel_array = $args['options'];

			if ( is_admin() ) {
				add_action( 'admin_init', array(&$this, 'register_fields'));
				add_action( 'admin_menu', array(&$this, 'build_admin_menu'));
				add_action( 'le_default_options_hook', array(&$this, 'le_default_options'), 10, 2);
				add_action( 'register_fields_hook', array(&$this, 'register_settings'), 10, 2);
			}

			if (isset($_GET['activated']) && is_admin() && current_user_can('edit_posts')){
				add_action('admin_init', array(&$this, 'register_defaults'));
			}
		}
		
		function build_le_page(){
			?>

			<div class="wrap le-wrapper">
				<?php

					lefx_tabs($this->panel_name);
					lefx_subtabs($this->panel_name);
					lefx_exploder_message();
					settings_errors();

				?>

				<div class="le-intro">
					<h2><?php _e($this->panel_title, 'launcheffect'); ?></h2>
				</div>
				<?php lefx_form($this->panel_name, $this->panel_array); ?>

			</div>
			<?php
		}

		function build_admin_menu() {
			$callback = 'build_le_'.$this->panel_name.'_page';
			$slug = preg_replace('/\s+/', '', strtolower($this->panel_title));
			if ( !method_exists( $class_name = get_class($this), $callback )) {
				add_settings_error(
					$class_name, 
					'invalid-callback', 
					__("The callback method, <code>$callback</code>, does not exist within the <code>$class_name</code> class.", 'launcheffect'), 
					'error'
				);
				$callback = 'build_le_page';
			}
			$this->handle = add_submenu_page( 
				'lefx_designer',
				__($this->panel_title, 'launcheffect'), 
				__($this->panel_title, 'launcheffect'), 
				'manage_options', 
				'lefx_'.$slug, 
				array(&$this, $callback)
			);
		}

		function le_default_options($optionspanel_array, $optionspanel_name) {
			if(!get_option($optionspanel_name)) {
				add_option($optionspanel_name);
				foreach ($optionspanel_array as $key => $value) {
					foreach ($value as $subsection) {
						foreach ($subsection as $op) {
							if(!get_option($op['option_name'])) {
								if(isset($op['std'])) {
									update_option($op['option_name'], $op['std']);
								}
							}
						}
					}
				}
			}
		}

		function register_settings() {
			register_setting($this->panel_name, $this->panel_name, array(&$this, 'validate_setting'));
			foreach ($this->panel_array as $key => $value) {
				foreach ($value as $subsection) {
					foreach ($subsection as $op) {
						register_setting($this->panel_name, $op['option_name']);
						if ($op['type'] == 'image' && isset($op['option_disable'])) {
							register_setting($this->panel_name, $op['option_disable']);
						}
					}
				}
			}
		}

		function register_fields() {
			do_action('register_fields_hook', $this->panel_array, $this->panel_name);
		}

		function register_defaults() {
			do_action('le_default_options_hook', $this->panel_array, $this->panel_name);
		}

		// Validation Function
		/*
		 * (deprecated) This probably does nothing now
		 */
		function validate_setting($array) {
			$keys = array_keys($_FILES);
			$i = 0;

			foreach ( $_FILES as $image ) {

				if ($image['size']) {
					$override = array('test_form' => false);
					$file = wp_handle_upload( $image, $override );
					$array[$keys[$i]] = $file['url'];
					if ( !isset($file['url'])) {
						add_settings_error(
							$keys[$i], // setting title
							'upload-issue', // error ID
							$file['error'], // error message
							'error' // type of message
						);
					}
				}
				else {
					$options = get_option($this->panel_name);
					$array[$keys[$i]] = $options[$keys[$i]];
				}
				$i++;
			}
			return $array;
		}
	}
}


// static global functions
function lefx_exploder_message() {
	?>

	<div id="le-iexploder">
		<h3>You're using a really old version of Internet Explorer.</h3>
		<p>This theme options panel has been optimized for <strong>Internet Explorer 8 and 9</strong> and most widely used versions of <strong>Safari, Firefox and Chrome</strong>. If you are using an earlier version of Internet Explorer, you may experience performance issues within this area of the site.</p>
		<p>Additionally, using an outdated browser makes your computer <strong>unsafe</strong>. For the best WordPress experience, please update your browser.</p>
		<p><a href="http://www.microsoft.com/windows/internet-explorer/">Update Internet Explorer</a></p>
	</div>
	<?php
}

function lefx_tabs($currtab) { 
	?>

	<div class="le-icons icon32"><br /></div>
	<h2 class="nav-tab-wrapper">
		<a class="nav-tab <?php if($currtab == 'plugin_options' || $currtab == 'launchmodule_options' || $currtab == 'pages_options') { echo ' nav-tab-active'; } ?>" href="<?php echo admin_url('admin.php?page=lefx_designer'); ?>">Designer</a>
		<a class="nav-tab <?php if($currtab == 'integrations_options') { echo ' nav-tab-active'; } ?>" href="<?php echo admin_url('admin.php?page=lefx_integrations'); ?>">Integrations</a>
		<a class="nav-tab <?php if($currtab == 'stats' || $currtab == 'export') { echo ' nav-tab-active'; } ?>" href="<?php echo admin_url('admin.php?page=lefx_stats'); ?>">Stats</a>
	</h2>
	<?php 
}

function lefx_subtabs($currtab) { 
	?>

	<ul class='subsubsub' style="float:none;">
		<li><a<?php if($currtab=='plugin_options') echo ' class="current"'; ?> href="<?php echo admin_url('admin.php?page=lefx_designer'); ?>">Global Settings</a> |</li>
		<li><a<?php if($currtab=='launchmodule_options') echo ' class="current"'; ?> href="<?php echo admin_url('admin.php?page=lefx_launchmodule'); ?>">Sign-Up Page</a> |</li>
		<li><a<?php if($currtab=='product_options') echo ' class="current"'; ?> href="<?php echo admin_url('admin.php?page=lefx_product'); ?>">Product</a> |</li>
		<li><a<?php if($currtab=='pages_options') echo ' class="current"'; ?> href="<?php echo admin_url('admin.php?page=lefx_theme'); ?>">Theme</a></li>
	</ul>
	<?php 
}
