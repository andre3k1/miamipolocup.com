<?php
add_action( 'init', 'create_post_types' );
function create_post_types() {
	global $smof_data;

    // Portfolio categories
    register_taxonomy('us_portfolio_category', array('us_portfolio'), array('hierarchical' => true, 'label' => 'Portfolio Categories','singular_label' => 'Portfolio Category', 'rewrite' => true));

	register_post_type( 'us_main_page_section',
		array(
			'labels' => array(
				'name' => 'Page Sections',
				'singular_name' => 'Page Section',
				'add_new' => 'Add Page Section',
			),
			'public' => true,
			'show_ui' => true,
			'query_var' => true,
			'has_archive' => true,
			'rewrite' => true,
			'supports' => array('title', 'editor', 'revisions', 'page-attributes'),
			'show_in_nav_menus' => true,
			'can_export' => true,
			'hierarchical' => true,
			'exclude_from_search' => true,
		)
	);
	// Portfolio post type
	register_post_type( 'us_portfolio',
		array(
			'labels' => array(
				'name' => 'Portfolio',
				'singular_name' => 'Portfolio Item',
				'add_new' => 'Add Portfolio Item',
			),
			'public' => true,
			'has_archive' => true,
			'rewrite' => true,
			'supports' => array('title', 'editor', 'thumbnail', 'revisions'),
			'can_export' => true,
			'hierarchical' => false,
			'exclude_from_search' => true,
		)
	);
	// Clients post type
	register_post_type( 'us_client',
		array(
			'labels' => array(
				'name' => 'Clients Logos',
				'singular_name' => 'Client Logo',
				'add_new' => 'Add Client Logo',
			),
			'public' => true,
			'publicly_queryable' => false,
			'has_archive' => true,
			'supports' => array('title', 'thumbnail'),
			'can_export' => true,
		)
	);

}

add_action( 'admin_head', 'us_portfolio_icons' );

function us_portfolio_icons() {
	?>
	<style type="text/css" media="screen">
	#adminmenu #menu-posts-us_main_page_section .menu-icon-post div.wp-menu-image:before {
		content: "\f105";
		color: #1ABC9C;
		}
	#adminmenu #menu-posts-us_portfolio .menu-icon-post div.wp-menu-image:before {
		content: "\f232";
		color: #1ABC9C;
		}
	#adminmenu #menu-posts-us_client .menu-icon-post div.wp-menu-image:before {
		content: "\f313";
		color: #1ABC9C;
		}
	#adminmenu #menu-posts-us_main_page_section .wp-menu-open.menu-icon-post div.wp-menu-image:before,
	#adminmenu #menu-posts-us_portfolio .wp-menu-open.menu-icon-post div.wp-menu-image:before,
	#adminmenu #menu-posts-us_client .wp-menu-open.menu-icon-post div.wp-menu-image:before {
		color: inherit;
		}
	</style>
<?php }