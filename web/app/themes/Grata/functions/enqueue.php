<?php


function us_fonts() {
	global $smof_data;
	$protocol = is_ssl() ? 'https' : 'http';

    if (empty($smof_data['font_subset'])) {
        $subset = '';
    } else {
        $subset = '&subset='.$smof_data['font_subset'];
    }

	if ($smof_data['body_text_font'] != '' AND $smof_data['body_text_font'] != 'none')
	{

		wp_enqueue_style( 'us-body-text-font', "$protocol://fonts.googleapis.com/css?family=".str_replace(' ', '+', $smof_data['body_text_font']).":400,300,600,700".$subset );
	}
	else
	{
		wp_enqueue_style( 'us-body-text-font', "$protocol://fonts.googleapis.com/css?family=PT+Sans:400,300,600,700".$subset );
	}


	if ($smof_data['body_text_font'] != $smof_data['navigation_font'] AND $smof_data['navigation_font'] != '' AND $smof_data['navigation_font'] != 'none')
	{
		wp_enqueue_style( 'us-navigation-font', "$protocol://fonts.googleapis.com/css?family=".str_replace(' ', '+', $smof_data['navigation_font']).":400,300,600,700".$subset );
	}

	if ($smof_data['heading_font'] != '' AND $smof_data['heading_font'] != 'none')
	{

		wp_enqueue_style( 'us-heading-font', "$protocol://fonts.googleapis.com/css?family=".str_replace(' ', '+', $smof_data['heading_font']).":400,300,600,700".$subset );
	}
	else
	{
		wp_enqueue_style( 'us-heading-font', "$protocol://fonts.googleapis.com/css?family=Titillium+Web:400,300,600,700".$subset );
	}


}
add_action( 'wp_enqueue_scripts', 'us_fonts' );

function us_styles()
{
	wp_register_style('motioncss', get_template_directory_uri() . '/css/motioncss.css', array(), '1', 'all');
	wp_register_style('motioncss-responsive', get_template_directory_uri() . '/css/motioncss-responsive.css', array(), '1', 'all');
	wp_register_style('font-awesome', get_template_directory_uri() . '/css/font-awesome.css', array(), '1', 'all');
	wp_register_style('magnific-popup', get_template_directory_uri() . '/css/magnific-popup.css', array(), '1', 'all');
	wp_register_style('slick', get_template_directory_uri() . '/slick/slick.css', array(), '1', 'all');
	wp_register_style('style', get_template_directory_uri() . '/css/style.css', array(), '1', 'all');
	wp_register_style('responsive', get_template_directory_uri() . '/css/responsive.css', array(), '1', 'all');

	wp_enqueue_style('motioncss');
	wp_enqueue_style('motioncss-responsive');
	wp_enqueue_style('font-awesome');
    wp_enqueue_style('magnific-popup');
    wp_enqueue_style('slick');
    wp_enqueue_style('style');
	wp_enqueue_style('responsive');

    wp_enqueue_style( 'wp-mediaelement' );
    wp_enqueue_script( 'wp-mediaelement' );

}
add_action('wp_enqueue_scripts', 'us_styles', 12);

function us_custom_styles()
{
    $wp_upload_dir  = wp_upload_dir();
    $styles_dir = $wp_upload_dir['basedir'].'/us_custom_css';
    $styles_dir = str_replace('\\', '/', $styles_dir);
    $styles_file = $styles_dir.'/us_grata_custom_styles.css';

    if (file_exists($styles_file))
    {
        wp_register_style('us_custom_css', $wp_upload_dir['baseurl'] . '/us_custom_css/us_grata_custom_styles.css', array(), '1', 'all');
        wp_enqueue_style('us_custom_css');
    }
    else
    {
        global $load_styles_directly;
        $load_styles_directly = true;
    }

    if(get_template_directory_uri() !=  get_stylesheet_directory_uri())
    {
        wp_register_style( 'grata-style' ,  get_stylesheet_directory_uri() . '/style.css', array(), '1', 'all' );
        wp_enqueue_style( 'grata-style');
    }
}
add_action('wp_enqueue_scripts', 'us_custom_styles', 17);

function us_jscripts()
{
	wp_register_script('modernizr', get_template_directory_uri().'/js/modernizr.js');
	wp_register_script('jquery_easing', get_template_directory_uri().'/js/jquery.easing.min.js', array('jquery'), '', TRUE);
	wp_register_script('isotope', get_template_directory_uri().'/js/jquery.isotope.js', array('jquery'), '', TRUE);
	wp_register_script('google-maps', 'http://maps.google.com/maps/api/js?sensor=false', array(), '', FALSE);
	wp_register_script('gmap', get_template_directory_uri().'/js/jquery.gmap.min.js', array('jquery'), '', TRUE);
	wp_register_script('magnific-popup', get_template_directory_uri().'/js/jquery.magnific-popup.js', array('jquery'), '', TRUE);
	wp_register_script('slick', get_template_directory_uri().'/slick/slick.min.js', array('jquery'), '', TRUE);
	wp_register_script('parallax', get_template_directory_uri().'/js/jquery.parallax.js', array('jquery'), '', TRUE);
    wp_register_script('us_hor_parallax', get_template_directory_uri().'/js/jquery.horparallax.js', array('jquery'), '', TRUE);
	wp_register_script('plugins', get_template_directory_uri().'/js/plugins.js', array('jquery'), '', TRUE);
	wp_register_script('responsive', get_template_directory_uri().'/js/responsive.js', array('jquery'), '', TRUE);
	wp_register_script('us_widgets', get_template_directory_uri().'/js/us.widgets.js', array('jquery'), '', TRUE);
	wp_register_script('waypoints', get_template_directory_uri().'/js/waypoints.min.js', array('jquery'), '', TRUE);
	wp_register_script('imagesloaded', get_template_directory_uri().'/js/imagesloaded.js', array('jquery'), '', TRUE);
	wp_register_script('mediaelement', get_template_directory_uri().'/js/mediaelement-and-player.js', array('jquery'), '', TRUE);

	wp_enqueue_script('modernizr');
	wp_enqueue_script('jquery_easing');
	wp_enqueue_script('isotope');
	wp_enqueue_script('google-maps');
	wp_enqueue_script('gmap');

	wp_enqueue_script('magnific-popup');
	wp_enqueue_script('slick');
	wp_enqueue_script('parallax');
	wp_enqueue_script('us_hor_parallax');
	wp_enqueue_script('waypoints');
	wp_enqueue_script('imagesloaded');
	wp_enqueue_script('mediaelement');
	wp_enqueue_script('us_widgets');
	wp_enqueue_script('responsive');
	wp_enqueue_script('plugins');

	wp_enqueue_script('comment-reply');

}
add_action('wp_enqueue_scripts', 'us_jscripts');