<?php
/**
 * Functions: activation-posts.php
 *
 * Automatically creates sign-up page, blog page and instructional posts upon theme activation.
 *
 * @package WordPress
 * @subpackage Launch_Effect
 *
 */
	
// CREATE SIGN UP PAGE
$LE_VERSION = LE_VERSION;
$launchpage_check = get_page_by_title('Sign Up');
$launchpage_create = array(
	'post_type' => 'page',
	'post_title' => 'Sign Up',
	'post_content' => '',
	'post_status' => 'publish',
	'post_author' => 1,
);
if(!isset($launchpage_check->ID)){
	$launchpage_id = wp_insert_post($launchpage_create);
	update_post_meta($launchpage_id, '_wp_page_template', 'launch.php');
}

if(lefx_version() == 'premium'){
	
	// CREATE BLOG PAGE (Premium Only)
	
	$blogpage_check = get_page_by_title('Blog');
	$blogpage_create = array(
		'post_type' => 'page',
		'post_title' => 'Blog',
		'post_content' => '',
		'post_status' => 'publish',
		'post_author' => 1,
	);
	if(!isset($blogpage_check->ID)){
		$blogpage_id = wp_insert_post($blogpage_create);
	}
	
	
	// CREATE LAUNCH EFFECT PREMIUM INSTRUCTIONS POST  (Premium Only)
	
	$documentationpage_check = get_page_by_title('Setup Instructions for v'.LE_VERSION, 'object', 'post');
	$documentationpage_content = <<<EOT

Welcome to Launch Effect Premium v$LE_VERSION!  Launch Effect Premium lets you create and customize an entire website at the click of a few buttons.  Version $LE_VERSION includes some important stability fixes and speed improvements, tweaks to the theme's responsive styling, and large improvements to the way the theme handles the generation of meta data for Facebook sharing, as well as the theme's ability to play nice with popular SEO plugins.  Be sure to check out the Launch Effect > Designer > Global Settings panel for more information.  Take a look around to see what's new and launch something today!

Setting up is easy, but there's definitely a few steps that have to be done in order for things to work properly.  Please follow the steps below and you'll be up and running in no time.

Please feel free to <a href="http://tenderapp.launcheffect.com">contact us at our support forums</a> if you have questions about setup or are experiencing any issues with the theme.

<h3>Setup Instructions</h3>

<h4>Step 1 &mdash; Set Homepage</h4>
Go to <strong>Settings > Reading</strong>.  
By default, WordPress shows your most recent Posts (the blog) on the homepage of your site (like the one you're reading right now). But many WordPress users want to be able to choose a different Page as their homepage.  

If you'd like to keep your most recent Posts as your homepage, you don't have to adjust anything in this step.  

If not, where it says, "Front page displays," choose "A static page," and select accordingly for your "Front Page".  Be sure to select "Blog" for "Posts Page".  If you'd like the Launch Effect sign-up page to be your homepage, choose "Sign-Up" for "Front Page".  Go to the Pages item in the WordPress sidebar to create new pages, which you can also select to be your "Front Page".

<h4>Step 2 &mdash; Create Nav Menu</h4>
Go to <strong>Appearance > Menus</strong>. 
This is where your navigation menu is set up and controlled.  In the large panel on the right, next to "Menu Name," write a name for your menu (it can be anything) and press save.  The page will refresh and you will see a new panel called "Theme Locations at the top left.  Use the Launch Effect Navigation drop down menu to select the name of the menu you just created. Then press save.  Now you can use the options at left to choose what pages and posts you'd like to appear in your nav menu.

<h4>Step 3 &mdash; Select Widgets</h4>
Go to <strong>Appearance > Widgets</strong>.
Launch Effect is compatible with the standard WordPress widgets, as you can see from the ones that appear by default on the left-hand side of your website.  Here you can select which widgets to keep and which to remove, as well as customize content specific to each widget.

<h4>Step 4 &mdash; Start Designing!</h4>
Go to <strong>Launch Effect > Designer</strong>.
Now for the fun part!  The Designer is now divided into three sections: Global Styles, Sign-Up Page, and Theme.  That submenu is located directly under the giant Designer/Integrations/Stats tabs.  The best way to get started here is to just start playing around and gaining an understanding of what selections affect which parts of the design.  Good luck!

EOT;

	$documentationpage_create = array(
		'post_type' => 'post',
		'post_title' => 'Setup Instructions for v'.LE_VERSION,
		'post_content' => $documentationpage_content,
		'post_status' => 'publish',
		'post_author' => 1,
	);
	if(!isset($documentationpage_check->ID)){
		$documentationpage_id = wp_insert_post($documentationpage_create);
	}

} else {
	
	
	// CREATE LAUNCH EFFECT LITE INSTRUCTIONS POST
	
	$documentationpage_check = get_page_by_title('Setup Instructions for v'.LE_VERSION.' Lite', 'object', 'post');
	$documentationpage_content = <<<EOT

Welcome to Launch Effect v$LE_VERSION Lite!  Launch Effect Lite lets you create and customize a viral landing page at the click of a few buttons.  Version $LE_VERSION includes some important stability fixes and speed improvements, tweaks to the theme's responsive styling, and large improvements to the way the theme handles the generation of meta data for Facebook sharing, as well as the theme's ability to play nice with popular SEO plugins.  Be sure to check out the Launch Effect > Designer > Global Settings panel for more information.  Take a look around to see what's new and launch something today!

If you're after a full-featured theme that still has the ease of customization and viral linking powers that you've come to love about Launch Effect Lite be sure to check out <a href="http://launcheffectapp.com/premium">Launch Effect Premium</a>!

Please feel free to <a href="http://tenderapp.launcheffect.com">contact us at our support forums</a> if you have questions about setup or are experiencing any issues with the theme.

<h3>Setup in Two Easy Steps</h3>
<h4>Step 1 &mdash; Set Your Launch Page as your Homepage</h4>
Go to <strong>Settings &gt; Reading</strong>.
Where it says, "Front page displays," choose "A static page," and select "Sign-Up" from the dropdown menu.  When you refresh this page, it will disappear and your launch page will appear instead.
<h4>Step 2 &mdash; Start Designing!</h4>
Go to <strong>Launch Effect &gt; Designer</strong>.
Now for the fun part! The Designer is now divided into three sections: Global Styles, Sign-Up Page, and Theme (premium only). That submenu is located directly under the giant Designer/Integrations/Stats tabs. The best way to get started here is to just start playing around and gaining an understanding of what selections affect which parts of the design. Good luck!

EOT;

	$documentationpage_create = array(
		'post_type' => 'post',
		'post_title' => 'Setup Instructions for v'.LE_VERSION.' Lite',
		'post_content' => $documentationpage_content,
		'post_status' => 'publish',
		'post_author' => 1,
	);
	if(!isset($documentationpage_check->ID)){
		$documentationpage_id = wp_insert_post($documentationpage_create);
	}

}

if(!get_option('lefx_colors_upgraded')) {
	global $wpdb;
	
	$colors_sql = "SELECT * FROM {$wpdb->options} WHERE option_name LIKE '%color%'";
	$colors = $wpdb->get_results($colors_sql);

	foreach($colors as $color) {
		if ( '#' != substr($color->option_value, 0, 1) ) {
			update_option($color->option_name, '#'.strtoupper($color->option_value));
		}
	}
	add_option('lefx_colors_upgraded', true);
}
