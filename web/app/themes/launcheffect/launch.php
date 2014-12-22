<?php
/**
 * Launch Template
 *
 * Loads the launch.php include for the Launch page
 *
 * @package WordPress
 * @subpackage Launch_Effect
 *
 */


get_header();

if ( have_posts() ) : while ( have_posts() ) : the_post();

	// GET THE LAUNCH PAGE
	get_template_part('launch/launch');

endwhile; else:

endif;

get_footer(); ?>