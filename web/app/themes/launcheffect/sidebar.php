<?php
/**
 * Sidebar Template (Premium)
 *
 * Contains the navigation and widget area
 *
 * @package WordPress
 * @subpackage Launch_Effect
 * 
 */
?>
<div id="sidebar">
	<nav>
		<?php wp_nav_menu( array( 'theme_location' => 'lefx-nav', 'menu_class' => 'nav') ); ?>

	</nav>

	<ul id="widgets">
		<?php dynamic_sidebar( 'primary-widget-area' ); ?>

	</ul>
</div>

