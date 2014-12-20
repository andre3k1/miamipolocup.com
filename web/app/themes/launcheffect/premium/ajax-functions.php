<?php
/**
 * Functions: premium/ajax-functions.php
 *
 * Static methods for AJAX and dynamic CSS generation
 *
 * @package WordPress
 * @subpackage Launch Effect
 *
 */

add_action('wp_ajax_dynamic_css_premium', 'dynamic_css_premium' );
add_action('wp_ajax_nopriv_dynamic_css_premium', 'dynamic_css_premium' );

function dynamic_css_premium() {
	dynamic_css_headers();
	ob_start("compress");

	/* Variables
	================================================== */
	$textShadow      = '0px 2px 1px #333';
	$letterPress     = '0px 1px 1px #' . lighter('container_background_color');
	$dropShadow      = '-webkit-box-shadow: 0px 0px 10px #111; -moz-box-shadow: 0px 0px 10px #111; box-shadow: 0px 0px 10px #111;';
	$glow            = '-webkit-box-shadow: 0px 0px 10px #FFF;	-moz-box-shadow: 0px 0px 10px #FFF; box-shadow: 0px 0px 10px #FFF;';
	$noShadow        = '-webkit-box-shadow: 0px 0px 0px #FFF; -moz-box-shadow: 0px 0px 0px #FFF; box-shadow: 0px 0px 0px #FFF;';
	$disableGradient = ler('buy_now_gradient_disable');
	$nav_resp_bg     = ler('lefx_pages_nav_responsivebg');
	$dark_resp_bg    = darker('lefx_pages_nav_responsivebg');

	?>

/* Learn More Tab
================================================== */

	#learn-more-tab {
		margin: 10px auto 0 auto;
		width: 590px;
	}

	a#learn-more {
		font-family: Raleway, Verdana, Geneva, Tahoma, sans-serif;
		font-size: 1.6em;
		font-weight: 700;
		color: #C53FA7;
		background: transparent;
	}

	a#learn-more:hover {
		background: transparent;
	}

/* Sign Up with Custom Fields
================================================== */

	.radio-group label,
	.checkbox-group label {
		font-size:<?php le('description_size'); ?>em !important;
		font-family:<?php legogl('description_font_goog', 'description_font'); ?> !important;
		font-weight:<?php le('description_weight'); ?> !important;
	}

	#signup-page .radio-group label,
	#signup-page .checkbox-group label {
		color:<?php le('description_color'); ?> !important;
	}

/* Sign Up with Custom Fields: Medium Size
================================================== */

	#signup.medium.hascf ul#form-layout li {
		border-top:1px solid <?php echo ($sec_color = ler('lefx_secondarycolor')) ? $sec_color : 'EEEEEE'; ?>;
	}

/* Sign Up: Progress Indicators
================================================== */

	#progress-container h3 {
		font-family:<?php legogl('subheading_font_goog', 'subheading_font'); ?>;
		font-size:<?php le('lefx_progtitlesize'); ?>em;
		font-weight:<?php lewt('lefx_progtitlestyle'); ?>;
		font-style:<?php lestyle('lefx_progtitlestyle'); ?>;
		color:<?php echo $title_color = ler('lefx_progtitlecolor'); ?>;
	}

	.simple .tearoff .background {
		background:<?php le('lefx_progcountbg'); ?> !important;
		color:<?php le('lefx_progcountnum'); ?> !important;
	}

	.tearoff .unit {
		color:<?php echo $title_color; ?>;
	}

	#bar-complete {
		background:<?php le('lefx_progbarcolor'); ?>;
	}

	<?php
		$barInset = sprintf(
			"inset 0px 1px 0px 0px #%s, inset 0px -5px 8px 0px #%s",
			lighter('lefx_progbarcolor'),
			darker2('lefx_progbarcolor')
		);
	?>#bar.stylish #bar-complete {
		-webkit-box-shadow: <?php echo $barInset; ?>;
		-moz-box-shadow: <?php echo $barInset; ?>;
		box-shadow: <?php echo $barInset; ?>;
	}

	#bar-complete span {
		color:<?php echo blacknwhite('lefx_progbarcolor'); ?>;
	}

/* Wrapper
================================================== */

	#wrapper {
		<?php if ( $ct_bgimg = leimg('lefx_pages_container_bgimg','lefx_pages_container_bgimg_disable', 'pages_options')) : ?>

		background-image:url('<?php echo $ct_bgimg; ?>');
		background-color:transparent;
		<?php elseif( $ct_bgcolor = ler('lefx_pages_container_bgcolor')): ?>background-color: <?php echo $ct_bgcolor; ?>;<?php endif; ?>

		<?php
			switch( get_option('lefx_pages_container_effects') ) {
				case 'dropshadow': echo $dropShadow;
				case 'glow': echo $glow;
				default: echo $noShadow;
			}
		?>

		<?php if (ler('lefx_pages_tab_disable') == true): ?>margin-top:40px;<?php endif; ?>

	}

	#wrapper header {
		text-align: <?php le('lefx_pages_logo_alignment'); ?>;
	}

	#wrapper header h1 {
		font-family:<?php legogl('lefx_pages_textlogo_font_goog', 'lefx_pages_textlogo_font'); ?>;
		font-weight:<?php lewt('lefx_pages_textlogo_style'); ?>;
		font-style:<?php lestyle('lefx_pages_textlogo_style'); ?>;
		color:<?php echo $pg_text_logo_color = ler('lefx_pages_textlogo_color'); ?>;
		text-shadow: <?php
			switch( get_option('lefx_pages_textlogo_effects') ) {
				case 'letterpress': echo $letterPress;
				case 'shadow': echo $textShadow;
				default: echo 'none';
			}
		?>;
		font-size:<?php echo $pg_txt_logo_size = ler('lefx_pages_textlogo_size'); ?>em;
	}

	#wrapper header h1 span {
		display: block;
		text-align:<?php le('lefx_pages_textlogo_alignment'); ?>;
	}

	#wrapper header h1 a {
		color:<?php echo $pg_text_logo_color; ?>;
	}

/* Nav
================================================== */

	nav a:link,
	nav a:visited,
	nav li.current_page_item ul li a,
	#postnav a {
		font-family:<?php legogl('lefx_pages_nav_font_goog', 'lefx_pages_nav_font'); ?>;
		font-size:<?php echo $nav_size = ler('lefx_pages_nav_size'); ?>em;
		font-weight:<?php lewt('lefx_pages_nav_style'); ?>;
		font-style:<?php lestyle('lefx_pages_nav_style'); ?>;
		color:<?php echo $pg_nav_color = ler('lefx_pages_nav_color'); ?>;
		text-transform:<?php echo $nav_case = ler('lefx_pages_nav_case'); ?>;
	}

	nav a:hover,
	nav a:active,
	#postnav a {
		color:<?php echo $pg_nav_color_hover = ler('lefx_pages_nav_colorhover'); ?>;
	}

/* Widgets
================================================== */

	ul#widgets li ul li,
	.textwidget,
	.tagcloud a,
	#wrapper ul#inner-footer li p a {
		font-size:<?php echo (ler('lefx_pages_bodytext_size') - 0.2); ?>em;
		font-weight:normal;
		font-family:<?php legogl('lefx_pages_bodytext_font_goog', 'lefx_pages_bodytext_font'); ?>;
	}

	ul#widgets li ul li a:link,
	ul#widgets li ul li a:visited,
	.tagcloud a:link,
	.tagcloud a:visited,
	.textwidget {
		color:<?php echo $pg_nav_color; ?>;
	}

	ul#widgets li ul li a:hover,
	ul#widgets li ul li a:active,
	.tagcloud a:hover,
	.tagcloud a:active {
		color:<?php echo $pg_nav_color_hover; ?>;
	}

	ul#widgets li ul li a,
	.textwidget {
		font-family:<?php legogl('lefx_pages_bodytext_font_goog', 'lefx_pages_bodytext_font'); ?> !important;
	}

	#wp-calendar tbody td {
		border-color: <?php echo $ct_bgcolor; ?>;
		background:<?php echo ($pg_tertiarycolor = ler('lefx_pages_tertiarycolor')) ? "#$pg_tertiarycolor" : 'transparent'; ?>;
	}

	.textwidget p {
		line-height: 1.4em;
		margin: 0 0 15px 0;
	}

	.textwidget li {
		font-size: 1em !important;
	}

/* Posts
================================================== */

	#main a:link,
	#main a:visited,
	#wrapper ul#inner-footer li p a {
		color:<?php echo $pg_link_color = ler('lefx_pages_links_color'); ?>;
		text-decoration:<?php echo (($links_underline = ler('lefx_pages_links_underline')) == true)?'underline':'none'; ?>;
	}

	#respond input[type=submit] {
		background-color:<?php echo $pg_link_color; ?>;
	}

	#main a:hover,
	#main a:active,
	.lepost h2 a:hover,
	#wrapper ul#inner-footer li p a:hover {
		color:<?php le('lefx_pages_links_colorhover'); ?>;
		text-decoration:<?php echo ($links_underline == true || ler('lefx_pages_links_underlinehover') == true)?'underline':'none'; ?>;
	}

	.lepost h1,
	.lepost h2 {
		font-family:<?php legogl('lefx_pages_h2_font_goog', 'lefx_pages_h2_font'); ?>;
		font-size:<?php echo ler('lefx_pages_h2_size'); ?>em;
		font-weight:<?php lewt('lefx_pages_h2_style'); ?>;
		font-style:<?php lestyle('lefx_pages_h2_style'); ?>;
		color:<?php echo $h2_color = ler('lefx_pages_h2_color'); ?>;
		text-shadow: <?php
			switch( get_option('lefx_pages_h2_effects') ) {
				case 'letterpress': echo $letterPress; break;
				case 'shadow': echo $textShadow; break;
				default: echo 'none';
			}
		?>;
		text-transform:<?php le('lefx_pages_h2_case'); ?>;
	}

	.lepost h2 a {
		color:<?php echo $h2_color; ?> !important;
	}

	.lepost h3 {
		font-family:<?php legogl('lefx_pages_h3_font_goog', 'lefx_pages_h3_font'); ?>;
		font-size:<?php echo ler('lefx_pages_h3_size'); ?>em;
		font-weight:<?php lewt('lefx_pages_h3_style'); ?>;
		font-style:<?php lestyle('lefx_pages_h3_style'); ?>;
		color:<?php le('lefx_pages_h3_color'); ?>;
		text-shadow: <?php
			switch( get_option('lefx_pages_h3_effects') ) {
				case 'letterpress': echo $letterPress; break;
				case 'shadow': echo $textShadow; break;
				default: echo 'none';
			}
		?>;
		text-transform:<?php le('lefx_pages_h3_case'); ?>;
	}

	.lepost h4,
	h3.widget-title {
		font-family:<?php legogl('lefx_pages_h4_font_goog', 'lefx_pages_h2_font'); ?>;
		font-size:<?php echo ler('lefx_pages_h4_size'); ?>em;
		font-weight:<?php lewt('lefx_pages_h4_style'); ?>;
		font-style:<?php lestyle('lefx_pages_h4_style'); ?>;
		color:<?php le('lefx_pages_h4_color'); ?>;
		text-shadow: <?php
			switch( get_option('lefx_pages_h4_effects') ) {
				case 'letterpress': echo $letterPress;
				case 'shadow': echo $textShadow;
				default: echo 'none';
			}
		?>;
		text-transform:<?php echo ler('lefx_pages_h4_case'); ?>;
	}

	.lepost p,
	.lepost ul li,
	.lepost ol li {
		font-size:<?php le('lefx_pages_bodytext_size'); ?>em;
		font-weight:<?php le('lefx_pages_bodytext_weight'); ?>;
		font-family:<?php legogl('lefx_pages_bodytext_font_goog', 'lefx_pages_bodytext_font'); ?>;
	}

	#main p,
	#main ul li,
	#main ol li,
	ul#widgets li ul li,
	cite,
	#SearchForm input.le-search:focus,
	#respond h3,
	#respond input,
	#respond textarea:focus {
		color:<?php le('lefx_pages_bodytext_color'); ?> !important;
	}

/* Colors
================================================== */

	/*----- Border -----*/

	.lepost .postmeta,
	.commentlist,
	.commentlist li.comment,
	.commentlist .children li,
	#comments .pingback,
	#respond input,
	#respond textarea {
		border-color:<?php echo $ct_border_color = ler('lefx_pages_container_bordercolor'); ?>;
	}

	#search_box {
		border-color:<?php echo lighter('lefx_pages_container_bordercolor'); ?>;
	}

	#search_box:hover,
	#search_box:focus {
		border-color:<?php echo $ct_border_color; ?>;
	}


	/*----- Accent -----*/

	h3.widget-title,
	nav li.current_page_item a {
		color:<?php echo $ct_accent_color = ler('lefx_pages_container_accentcolor'); ?>;
	}

	#respond input[type=submit]:hover {
		background-color:<?php echo $ct_accent_color; ?>;
	}

	#respond input:focus,
	#respond textarea:focus,
	.lepost blockquote {
		border-color:<?php echo $ct_accent_color; ?> !important;
	}


	/*----- Secondary -----*/

	.lepost .wp-caption p,
	.entry-date,
	#SearchForm input.le-search,
	.comment-author,
	#main a.comment-permalink,
	#main a.comment-reply-link,
	#main a.comment-reply-login,
	#comments .pingback p,
	#previous-comments,
	#next-comments,
	#respond label,
	#respond p.comment-messages,
	#respond textarea,
	#wp-calendar thead,
	#wp-calendar tbody,
	#wp-calendar tfoot #next a,
	#wp-calendar tfoot #prev a,
	ul#widgets ul#recentcomments li.recentcomments {
		color:<?php le('lefx_pages_container_secondarycolor'); ?> !important;
	}

/* Sign Up Slide Down
================================================== */

	#launchtab {
		border-bottom:6px solid <?php echo $tab_bg_color = ler('lefx_pages_tab_bg_color'); ?>;
	}

	#launchtab a {
		background:<?php echo $tab_bg_color; ?>;
		color:<?php le('lefx_pages_tab_color'); ?>;
		font-size:<?php echo $tab_size = ler('lefx_pages_tab_size'); ?>em;
		font-family:<?php legogl('lefx_pages_tab_font_goog', 'lefx_pages_tab_font'); ?>;
	}

	#launchlitemodule #signup {
		background:<?php echo $tab_bg_color; ?>;
		<?php echo $noShadow; ?>
	}

	#launchlitemodule h2,
	#launchlitemodule h3,
	#launchlitemodule h4 {
		color:<?php le('lefx_pages_tab_subheading_color'); ?>;
	}

	#launchlitemodule label {
		color:<?php le('lefx_pages_tab_label_color'); ?>;
	}

	#launchlitemodule a,
	#launchlitemodule p a,
	#launchlitemodule span.privacy-policy a {
		color:<?php le('lefx_pages_tab_link_color'); ?> !important;
	}

	#launchlitemodule p,
	#launchlitemodule li,
	#launchlitemodule span.privacy-policy,
	#launchlitemodule .radio-group label,
	#launchlitemodule .checkbox-group label {
		color:<?php le('lefx_pages_tab_bodytext_color'); ?>;
	}

/* PayPal Buy Now Button
================================================== */

	.lefx_buy_now input[type="submit"] {
		display: block;
		text-align: center;
		margin: 10px auto;
		width: <?php le('buy_now_button_size'); ?>;
		height: <?php le('buy_now_button_height'); ?>;

		border: <?php echo $bn_border_width = ler('buy_now_border_width'); ?> solid <?php echo $bn_border_color = ler('buy_now_border_color'); ?>;
		-webkit-border-radius: <?php echo $bn_border_radius = ler('buy_now_border_radius'); ?>;
		-moz-border-radius:    <?php echo $bn_border_radius; ?>;
		border-radius:         <?php echo $bn_border_radius; ?>;

		font-size:<?php le('buy_now_font_size'); ?>em;
		font-family:<?php legogl('buy_now_goog', 'buy_now_font'); ?>;
		font-weight:<?php le('buy_now_font_weight'); ?>;

		background: <?php echo le('buy_now_bg_color'); ?>;
		<?php if ($disableGradient == false): ?>

		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,<?php
			echo $bn_bg_start = ler('buy_now_bg_start');
		?>), color-stop(100%,<?php
			echo $bn_bg_end = ler('buy_now_bg_end');
		?>));
		background: -webkit-linear-gradient(top, <?php echo $bn_bg_start; ?> 0%, <?php echo $bn_bg_end; ?> 100%);
		background:    -moz-linear-gradient(top, <?php echo $bn_bg_start; ?> 0%, <?php echo $bn_bg_end; ?> 100%);
		background:     -ms-linear-gradient(top, <?php echo $bn_bg_start; ?> 0%, <?php echo $bn_bg_end; ?> 100%);
		background:      -o-linear-gradient(top, <?php echo $bn_bg_start; ?> 0%, <?php echo $bn_bg_end; ?> 100%);
		background:   linear-gradient(to bottom, <?php echo $bn_bg_start; ?> 0%, <?php echo $bn_bg_end; ?> 100%);
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='<?php echo $bn_bg_start; ?>', endColorstr='<?php echo $bn_bg_end; ?>',GradientType=0 );
		<?php endif; ?>

		color:<?php le('buy_now_text_color'); ?>;
		-webkit-appearance: none;
	}
	.lefx_buy_now .le-product-sel {
		border: <?php echo $bn_border_width; ?> solid <?php echo $bn_border_color; ?>;
		-webkit-border-radius: <?php echo $bn_border_radius; ?>;
		-moz-border-radius:    <?php echo $bn_border_radius; ?>;
		border-radius:         <?php echo $bn_border_radius; ?>;
	}

/* Media Queries
================================================== */

	@media screen and (max-width: 768px) {

		body#inner-page {
			<?php if($ct_bgimg) : ?>

			background-image:url("<?php echo $ct_bgimg; ?>");
			background-color:transparent;
			<?php elseif($ct_bgcolor) : ?>

			background-color:<?php echo $ct_bgcolor; ?>;
			background-image:none;
		<?php endif; ?>

		}
		<?php if ($pg_txt_logo_size > 5) : ?>

		#wrapper header {
			font-size:0.7em;
		}
		<?php endif; ?>

		nav ul li,
		nav ul li ul li {
			border-bottom:1px solid <?php echo ($nav_resp_bg)?$dark_resp_bg:'cacaca'; ?>;
		}

		nav a {
			background:<?php echo ($nav_resp_bg)?$nav_resp_bg:'eeeeee'; ?>;
		}

		#nav-responsive-menu-link {
			background:<?php echo ($nav_resp_bg)?$nav_resp_bg:'eeeeee'; ?>;
			color:<?php echo $pg_nav_color; ?>;
			font-size:<?php echo $tab_size; ?>em;
			font-family:<?php legogl('lefx_pages_tab_font_goog', 'lefx_pages_tab_font'); ?>;
		}

		#nav-responsive-menu-link.open {
			background:<?php echo ($nav_resp_bg) ? $dark_resp_bg : 'cacaca'; ?>;
		}

		.open + #nav-responsive-menu-items > * {
			display: block;
		}

		#launchtab a {
			font-family:<?php legogl('lefx_pages_nav_font_goog', 'lefx_pages_nav_font'); ?>;
			font-size:<?php echo $nav_size; ?>em;
			font-weight:<?php lewt('lefx_pages_nav_style'); ?>;
			font-style:<?php lestyle('lefx_pages_nav_style'); ?>;
			text-transform:<?php echo $nav_case; ?>;
		}

	}

	@media screen and (min-device-width: 768px) and (max-device-width: 1024px) and (orientation: landscape) {

		#launchtab a {
			line-height:<?php echo $nav_size; ?>em;
		}

	}
	<?php
	ob_end_flush();
	exit;
}
