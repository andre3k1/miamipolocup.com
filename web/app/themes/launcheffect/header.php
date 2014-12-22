<?php
/**
 * Header
 *
 * Displays all of the <head> section and everything up to and including <body>
 *
 * @package WordPress
 * @subpackage Launch_Effect
 */

/* LE Options */
$excerpt = get_the_excerpt();
$lefx_desc_fbadmins = ler('lefx_description_fbadmins');
$lefx_desc_fbappid = ler('lefx_description_fbappid');
$bkt_thumb = leimg('bkt_thumb', 'bkt_thumbdisable', 'plugin_options');
$bkt_favicon = leimg('bkt_favicon', 'bkt_favdisable', 'plugin_options');
$bkt_metadesc = ler('bkt_metadesc');
$bkt_replace = array("\r\n", "\r", "\t", "\n");
$default_desc = ($bkt_metadesc) ? str_replace($bkt_replace," ",$bkt_metadesc) : get_bloginfo('description');
$spl_desc = $excerpt ? strip_tags($excerpt) : $default_desc;
$ogImageSrc = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array( 500, 500 ), false, '' );

?><!DOCTYPE HTML>
<!--[if lt IE 7 ]><html class="ie ie6" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html <?php language_attributes(); ?> xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml"> <!--<![endif]-->
<head profile="http://gmpg.org/xfn/11">

	<title>Coming Soon - Miami Beach Polo World Cup XII - Presented by The Polo Life, LLC.</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="viewport" content="width=device-width, user-scalable=no, maximum-scale=1.0, initial-scale=1.0">
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
	<?php
	ob_start();
	wp_head();
	$wp_head = ob_get_contents();
	ob_end_clean();
	$wp_head = explode("\n", $wp_head);
	echo implode("\n\t", $wp_head);
	?>

	<!-- Mobile Stylesheets -->
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/ss/launch-effect-responsive.min.css" media="only screen and (max-width: 590px)"/>

	<!-- WebFonts -->
	<?php
	$lefx_typekit       = ler('lefx_typekit');
	$lefx_monotype      = ler('lefx_monotype');
	$lefx_webfonts_dups = array(
		ler('heading_font_goog'),
		ler('subheading_font_goog'),
		ler('label_font_goog'),
		ler('description_font_goog'),
		ler('lefx_pages_nav_font_goog'),
		ler('lefx_pages_textlogo_font_goog'),
		ler('lefx_pages_h2_font_goog'),
		ler('lefx_pages_h3_font_goog'),
		ler('lefx_pages_h4_font_goog'),
		ler('lefx_pages_bodytext_font_goog'),
		ler('lefx_pages_tab_font_goog'),
		ler('lefx_pages_learnmoretab_font_goog'),
		ler('buy_now_goog')
	);
	$lefx_webfonts_unique = array_filter(array_unique($lefx_webfonts_dups));
	$lefx_webfonts = $lefx_webfonts_unique;
	$config = array();

	if ($lefx_webfonts) $config['google'] = array( 'families' => array_values($lefx_webfonts) );
	if ($lefx_typekit) $config['typekit'] = array( 'id' => $lefx_typekit );
	if ($lefx_monotype) $config['monotype'] = array( 'projectId' => $lefx_monotype );
	if ($lefx_webfonts||$lefx_typekit||$lefx_monotype): ?><script type="text/javascript">
	WebFontConfig = <?php echo json_encode($config); ?>;
	(function() {var wf = document.createElement('script');wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +'://ajax.googleapis.com/ajax/libs/webfont/1.4.7/webfont.js';wf.type = 'text/javascript';wf.async = 'true';var s = document.getElementsByTagName('script')[0];s.parentNode.insertBefore(wf, s);})();
	</script><?php endif; ?>

	<!--[if lt IE 9]>
	<style>
	#background {
		filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php
			echo $supersize = leimg('supersize', 'supersize_disable', 'plugin_options');
		?>', sizingMethod='scale');
		-ms-filter: "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php
			echo $supersize;
		?>', sizingMethod='scale')";
	}
	</style>
	<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<?php if($lefx_addcsshead = ler('lefx_addcsshead')) printf('<style type="text/css">%s</style>', "\n\t$lefx_addcsshead\n\t"); ?>
	<?php if($lefx_addjshead = ler('lefx_addjshead')) echo "\n\t$lefx_addjshead"; ?>

</head>
<body <?php body_class((lefx_version() != 'premium')?"lite":""); ?>>
	<div id="background"<?php
		$slides_enabled = get_option('lefx_enable_slideshow');
		echo (get_option('lefx_bg_image2')&&$slides_enabled) ? ' class="slideshow"' : '';
	?>>
		<?php if ( $slides_enabled && ($output = $supersize) ) {
			$output = "<div style='background-image: url($output);'></div>";
			for ( $i=2;$i<6;$i++)
				if ($img = get_option('lefx_bg_image'.$i))
					$output .= "\n\t\t<div style='background-image: url($img);'></div>";
			echo $output;
		} ?>

	</div>
