<?php
/**
 * Premium Theme Functions
 *
 * @package WordPress
 * @subpackage Launch_Effect
 *
 */

/* Enqueue Premium CSS
================================================== */
function lefx_css_premium() {
	wp_register_style('lefx_css_premium_main', get_template_directory_uri() . '/premium/ss/launch-effect-premium.min.css', false, LE_VERSION);
	wp_enqueue_style('lefx_css_premium_main');

    wp_register_style('lefx_css_premium_dynamic',  admin_url('admin-ajax.php?action=dynamic_css_premium'), false , get_theme_mod('lefx_dynamic_css_version','1.00'));
    wp_enqueue_style('lefx_css_premium_dynamic');
}
add_action('wp_enqueue_scripts', 'lefx_css_premium');

/* Enqueue Premium JS
================================================== */
function lefx_js_premium() {
	wp_register_script('lefx_js_premium_init', get_template_directory_uri() . '/premium/js/launch-effect-premium.min.js', array('jquery'), LE_VERSION, true);
	wp_enqueue_script('lefx_js_premium_init');
}
if (lefx_version() == 'premium') {
	add_action('wp_enqueue_scripts', 'lefx_js_premium');
}

/* Thumbnails
================================================== */
add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size( 470, 9999, true ); // Default Thumbnail Image
add_image_size( 'blog-thumbnail', 470, 9999, false );
add_image_size( 'page-thumbnail', 700, 9999, false );

/* Custom TinyMCE
================================================== */
function customformatTinyMCE($init) {
	// Add block format elements you want to show in dropdown
	$init['theme_advanced_blockformats'] = 'h3,h4,p,code,blockquote';
	$init['theme_advanced_disable'] = 'h1,h2,strikethrough,underline,forecolor,justifyfull';
	return $init;
}
add_filter('tiny_mce_before_init', 'customformatTinyMCE' );

/* Nav Menus
================================================== */
function register_my_menus() {
	register_nav_menus(
		array('lefx-nav' => __( 'Launch Effect Navigation', 'launcheffect' ) )
	);
}
add_action( 'init', 'register_my_menus' );

/* Modify WordPress Gallery for Lightbox Support
================================================== */
function lefx_gallery($attr) {
	global $post, $wp_locale;

	static $instance = 0;
	$instance++;

	// Allow plugins/themes to override the default gallery template.
	$output = apply_filters('post_gallery', '', $attr);
	if ( $output != '' )
		return $output;

	// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
	if ( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		if ( !$attr['orderby'] )
			unset( $attr['orderby'] );
	}

	extract(shortcode_atts(array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post->ID,
		'itemtag'    => 'li',
		'icontag'    => 'img',
		'captiontag' => 'span',
		'columns'    => 3,
		'size'       => 'thumbnail',
		'include'    => '',
		'exclude'    => ''
	), $attr));

	$id = intval($id);
	if ( 'RAND' == $order )
		$orderby = 'none';

	if ( !empty($include) ) $include = preg_replace( '/[^0-9,]+/', '', $include );
	if ( !empty($exclude) ) $exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
	if ( isset($attr['ids']) ) {
		if ( !is_array($attr['ids']) ) {
			if ( strpos($attr['ids'],',') ) $ids = explode(',', $attr['ids']);
			else $ids = (array) $attr['ids'];
		} else {
			$ids = $attr['ids'];
		}
		if ( !empty($include) && strpos($include, ',') ) {
			$ids = array_merge( explode(',', $include), $ids);
		}
	}

	$_attachments = get_posts( array(
		'include' => isset($ids)?implode(',',$ids):null,
		'exclude' => !empty($exclude)?$exclude:null,
		'post_parent' => isset($ids)?null:$id,
		'post_status' => 'inherit',
		'post_type' => 'attachment',
		'post_mime_type' => 'image',
		'order' => $order,
		'orderby' => $orderby
	) );

	$attachments = array();
	foreach( $ids as $idx => $id ) {
		foreach ( $_attachments as $key => $val ) {
			if ( $id == $val->ID ) $attachments[$id] = $val;
		}
	}

	if ( empty($attachments) )
		return '';

	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $att_id => $attachment )
			$output .= wp_get_attachment_link($att_id, $size, true) . "\n";
		return $output;
	}

	$columns = intval($columns);
	$itemwidth = $columns > 0 ? floor(100/$columns)-1 : 100;
	$float = is_rtl() ? 'right' : 'left';
	$selector = "gallery-{$instance}";

	$gallery_style = $gallery_div = '';
	if ( apply_filters( 'use_default_gallery_style', true ) )
		$gallery_style = "
		<style type='text/css'>
			#{$selector} {
				margin: auto;
			}
			#{$selector} .gallery-item {
				display: inline-block;
				float: {$float};
				list-style: none;
				margin: 10px 0 0 0;
			    opacity: 1;
				text-align: center;
				transform: rotate(0deg);
				transition: opacity 500ms linear 0s;
				vertical-align: top;
				width: {$itemwidth}%;
			}
			#{$selector} .gallery-item:hover {
				opacity: 0.8;
				-ms-filter: alpha(opacity=80);
			}
			#{$selector} .gallery-item img {
				border: 2px solid #cfcfcf;
				margin: 0;
			}
			#{$selector} .gallery-caption {
				margin-left: 0;
			}
		</style>
		<!-- see gallery_shortcode() in wp-includes/media.php -->";
	$size_class = sanitize_html_class( $size );
	$gallery_div = "<ul id=\"$selector\" class=\"gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}\">\n";
	$output = apply_filters( 'gallery_style', $gallery_style . "\n\t\t" . $gallery_div );

	$i = 0;
	foreach ( $attachments as $id => $attachment ) {
		$href_full = wp_get_attachment_url($id);
		$href_thumb = wp_get_attachment_image_src($id, $size);
		$caption = strip_tags($attachment->post_excerpt);
		$output_data = array(
			$href_full,
			$caption,
			"\n".str_repeat("\t",4),
			$href_thumb[0],
			$attachment->post_title,
			"\n\t\t\t",
		);
		$link = vsprintf('<a href="%s" rel="fancybox" title="%s">%s<img src="%s" alt="%s"/>%s</a>', $output_data);
		$output .= sprintf('%s<li class="gallery-item">%s</li>%s', "\t\t\t", $link, "\n");
	}
	$output .= "\t\t</ul>\n";
	return $output;
}
add_shortcode('gallery', 'lefx_gallery');

/* <title> Tag
================================================== */
function lefx_wp_title( $title, $separator ) {

	// Don't affect wp_title() calls in feeds.
	if ( is_feed() )
		return $title;

	// The $paged global variable contains the page number of a listing of posts.
	// The $page global variable contains the page number of a single post that is paged.
	// We'll display whichever one applies, if we're not looking at the first page.
	global $paged, $page;

	if ( is_search() ) {
		// If we're a search, let's start over:
		$title = sprintf(' | Search results for %s', '"' . get_search_query() . '"' );
		return $title;
	}

	// If it's the Launch page use the title from the Theme Options page
	if (isset($_GET['ref'])||isset($_GET['fb_ref'])) { $title = ''; }

	// Transition out of using the below after a few months since we're using query strings for the referral links now.
	// Need to be able to create a real 404 page.
	if (is_404()) {
		$title = '';
	}

	// Return the new title to wp_title():
	return $title;

}
add_filter( 'wp_title', 'lefx_wp_title', 10, 2 );

/* Excerpts
================================================== */
function lefx_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'lefx_excerpt_length' );

// Continue Reading Link
function lefx_continue_reading_link() {
	return ' <a href="'. get_permalink() . '">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'launcheffect') . '</a>';
}

// Replaces "[...]" with an ellipsis and lefx_continue_reading_link().
function lefx_auto_excerpt_more( $more ) {
	return '...';
}
add_filter( 'excerpt_more', 'lefx_auto_excerpt_more' );

/* Comments
================================================== */
if ( ! function_exists( 'lefx_comments' ) ) :
	function lefx_comments( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case '' :
		?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
			<div id="comment-<?php comment_ID(); ?>">
			<div class="comment-author vcard">
				<?php if (get_option('show_avatars')){
						echo get_avatar( $comment, 40 );
					} else { ?>
						<style type="text/css">
							.commentlist li.comment {
								padding-left:0px !important;
							}

							.commentlist .children li {
								margin-left:56px !important;
							}
						</style>
				<?php }
				?>
				<?php printf( __( '%s', 'launcheffect'), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
				<span class="slash">&nbsp;/&nbsp;</span>
				<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>" class="comment-permalink">
				<?php printf( __( '%1$s at %2$s', 'launcheffect' ), get_comment_date(),  get_comment_time() ); ?></a>
				<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .comment-author .vcard -->
			<?php if ( $comment->comment_approved == '0' ) : ?>
				<em><?php _e( 'Your comment is awaiting moderation.', 'launcheffect'); ?></em>
				<br />
			<?php endif; ?>

			<div class="comment-body"><?php comment_text(); ?></div>

		</div><!-- #comment-##  -->

		<?php
				break;
			case 'pingback'  :
			case 'trackback' :
		?>
		<li class="post pingback">
			<p><?php _e( 'Pingback:', 'launcheffect'); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('(Edit)', 'launcheffect'), ' ' ); ?></p>
		<?php
				break;
		endswitch;
	}
endif;

/* Widgets
================================================== */
function lefx_widgets_init() {
	// Area 1, located at the top of the sidebar.
	register_sidebar( array(
		'name' => __('Primary Widget Area', 'launcheffect'),
		'id' => 'primary-widget-area',
		'description' => __('The primary widget area', 'launcheffect'),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}
add_action( 'widgets_init', 'lefx_widgets_init' );

// Remove Recent Comments Styling
function lefx_remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}
add_action( 'widgets_init', 'lefx_remove_recent_comments_style' );

/* Post Meta Information
================================================== */
// Prints HTML with meta information for the current post-date/time and author.
if ( ! function_exists( 'lefx_posted_on' ) ) :
	function lefx_posted_on() {
		printf( __('%2$s', 'launcheffect'),
			'meta-prep meta-prep-author',
			sprintf( '<span class="entry-date">%3$s</span>',
				get_permalink(),
				esc_attr( get_the_time() ),
				get_the_date()
			)
		);
	}
endif;

// Prints HTML with meta information for the current post (category, tags and permalink).
if ( ! function_exists( 'lefx_posted_in' ) ) :
	function lefx_posted_in() {
		// Retrieves tag list of current post, separated by commas.
		$tag_list = get_the_tag_list( '', ', ' );
		if ( $tag_list ) {
			$posted_in = __( 'This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'launcheffect');
		} elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
			$posted_in = __( 'This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'launcheffect');
		} else {
			$posted_in = __( 'Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'launcheffect');
		}
		// Prints the string, replacing the placeholders.
		printf(
			$posted_in,
			get_the_category_list( ', ' ),
			$tag_list,
			get_permalink(),
			the_title_attribute( 'echo=0' )
		);
	}
endif;

/* Product Shortcode
================================================== */
function lefx_generate_product_shortcode() {
	$sandbox = ler('lefx_paypal_sandbox');
	$paypalURL = 'https://www.' .(($sandbox==true)?'sandbox.':'').'paypal.com';

	$businessID      = ler('lefx_product_paypal_email');
	$productName     = ler('lefx_product_name');
	$productPrice    = ler('lefx_product_price');
	$productID       = ler('lefx_product_id');
	$productTax      = ler('lefx_product_tax');
	$productShipping = ler('lefx_product_shipping');
	$currencyCode    = ler('lefx_product_currency_code');
	$countryCode     = ler('lefx_product_country_code');
	$allowQty        = ler('lefx_product_allow_qty');
	$maxQty          = ler('lefx_product_max_qty');
	$maxQty          = (is_numeric($maxQty)?$maxQty:10);
	$optionsName     = ler('lefx_product_options_name');
	$thankYou        = ler('lefx_product_thankyou');
	$submitText      = ler('lefx_product_submit_text');
	$paypalCC        = ler('buy_now_show_cc');
	
	// unfortunately these were saved with words so, we'll have to loop thru
	$opt_num = array('one','two','three','four','five','six','seven','eight','nine','ten');
	$options = array();
	for($o=0;$o<10;$o++) {
		$number = $opt_num[$o];
		$opt_name = ler('lefx_product_option_'.$number);
		if ( !empty($opt_name) ) {
			$options[$o] = new stdClass();
			$options[$o]->name = $opt_name;
			$options[$o]->price = ler('lefx_product_option_'.$number.'_price');
		}
	}

	ob_start(); ?>

		<form action="<?php echo $paypalURL; ?>/cgi-bin/webscr" method="post" target="_top" class="lefx_buy_now">
			<input type="hidden" name="cmd" value="_xclick">
			<input type="hidden" name="lc" value="<?php echo $countryCode; ?>">
			<input type="hidden" name="business" value="<?php echo $businessID; ?>">
			<input type="hidden" name="item_name" value="<?php echo $productName; ?>">
			<input type="hidden" name="amount" value="<?php echo $productPrice; ?>">
			<input type="hidden" name="tax_rate" value="<?php echo $productTax; ?>">
			<input type="hidden" name="shipping" value="<?php echo $productShipping; ?>">
			<?php if (!empty($productID)) : ?><input type="hidden" name="item_number" value="<?php echo $productID; ?>"><?php endif; ?>

			<input type="hidden" name="currency_code" value="<?php echo $currencyCode; ?>">
			<input type="hidden" name="on0" value="<?php echo $optionsName; ?>">
			<input type="hidden" name="option_index" value="0">
			<?php if ( !empty($thankYou) ) : ?><input type="hidden" name="return" value="<?php echo $thankYou; ?>"><?php endif; ?>

			<?php if ( count($options) > 0 ) : ?><p><select name="os0" class="le-product-sel">
				<?php foreach ($options as $key => $obj) : ?>

				<option value="<?php echo $obj->name; ?>"><?php echo "{$obj->name} - {$obj->price} $currencyCode"; ?></option><?php endforeach; ?>

			</select></p>
			<?php foreach ($options as $key => $obj) : ?>

			<input type="hidden" name="option_select<?php echo $key; ?>" value="<?php echo $obj->name; ?>">
			<input type="hidden" name="option_amount<?php echo $key; ?>" value="<?php echo $obj->price; ?>">
			<?php endforeach; endif; ?>

			<?php if ( $allowQty && $maxQty > 0 ) : ?><p><label class="qty">&nbsp;</label><select name="quantity" class="le-product-sel">
				<?php for ($q=1;$q<=$maxQty;$q++) : ?>

				<option value="<?php echo $q; ?>"><?php echo $q; ?></option><?php endfor; ?>

			</select></p>
		<?php endif; ?>

			<input type="submit" value="<?php echo $submitText; ?>">
		</form>
		<?php if ($paypalCC == true) : ?><i class="buy-now-cc">&nbsp;</i><?php endif; 
	
	$formCode = ob_get_contents();
	ob_end_clean();
	
	// Don't output anything if price is negative, business ID is missing.
	if ($productPrice < 0) {
		$formCode = '<div class="buy-now-error">Please use a product price greater than 0.</div>';
	} elseif (empty($businessID)) {
		$formCode = '<div class="buy-now-error">Please include your PayPal e-mail address or Business ID.</div>';
	}

	return $formCode;
}
add_shortcode('le_product', 'lefx_generate_product_shortcode');
