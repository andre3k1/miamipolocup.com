<?php
/**
 * Page Template (Premium)
 *
 * @package WordPress
 * @subpackage Launch_Effect
 * 
 */

get_header();
get_template_part('premium/theme','header'); 
?>
	
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	
	<?php if(has_post_thumbnail()) : ?><div id="hero"><?php the_post_thumbnail('page-thumbnail'); ?></div><?php endif; ?>
	
	<?php get_sidebar(); ?>

	<div id="main">
		<div class="lepost clearfix">
			<h2><?php the_title(); ?></h2>
			<?php the_content(); ?>
			
		</div>
	</div>
	
	<?php endwhile; else: endif; ?>
	
	<?php get_template_part('launch/launch','footer'); ?>
	
</div> <!-- end #wrapper -->

<?php get_footer(); ?>