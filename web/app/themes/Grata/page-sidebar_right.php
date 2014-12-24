<?php
/*
Template Name: Page: Sidebar Right
*/
define('SIDEBAR_POS', 'right');

remove_shortcode('subsection');
add_shortcode('subsection', array($us_shortcodes, 'subsection_dummy'));

get_header();
if (have_posts()) : while(have_posts()) : the_post(); ?>
<?php get_template_part( 'templates/pagehead' ); ?>
<section class="l-section">
	<div class="l-section-h g-html i-cf">

		<div class="l-content">

			<?php the_content(); ?>
			<?php

			if (function_exists('us_wp_link_pages')) {
				$link_pages_args = array(
					'before'           => '<div class="g-pagination">',
					'after'            => '</div>',
					'next_or_number'   => 'next_and_number',
					'nextpagelink'     => __('Next', 'us').'  &raquo;',
					'previouspagelink' => '&laquo; '.__('Previous', 'us'),
					'echo'             => 0
				);
				echo us_wp_link_pages($link_pages_args);
			} else {
				$link_pages_args = array(
					'before' => '<div class="g-pagination">',
					'after' => '</div>',
					'link_before' => '<span class="g-pagination-item">',
					'link_after' => '</span>',
					'echo' => 0
				);
				echo wp_link_pages($link_pages_args);
			}
			?>
		</div>
		
		<div class="l-sidebar">
			<?php generated_dynamic_sidebar(); ?>
		</div>

	</div>
</section>
<?php endwhile; endif;
get_footer();
