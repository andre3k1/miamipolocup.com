<?php
// Improve TinyMCE look
function us_enqueue_editor_style() {

	add_editor_style( 'functions/tinymce/mce_styles.css' );
}

add_action('admin_enqueue_scripts', 'us_enqueue_editor_style');

// Redirect to Theme Options after Theme activation
function us_theme_activation()
{
	global $pagenow;
	if (is_admin() && $pagenow == 'themes.php' && isset($_GET['activated']))
	{
		header( 'Location: '.admin_url().'themes.php?page=us_demo_import' ) ;
	}
}

add_action('admin_init','us_theme_activation');

// Improve MetaBox look
function us_enqueue_metabox_style() {
    wp_enqueue_style( 'us-rwmb', RWMB_CSS_URL . 'us_meta_box_style.css', array(), RWMB_VER );
}

add_action( 'admin_enqueue_scripts', 'us_enqueue_metabox_style', 12);

// TinyMCE buttons
function us_enqueue_admin_style() {
    wp_enqueue_style( 'us-admin-css', get_template_directory_uri() . '/functions/assets/css/us.admin.css' );
}

add_action( 'admin_enqueue_scripts', 'us_enqueue_admin_style', 12);