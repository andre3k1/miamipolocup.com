<?php 
/**
 * Search Results Template (Premium)
 *
 * @package WordPress
 * @subpackage Launch_Effect
 * 
 */

get_header();
get_template_part('premium/theme','header'); 
?>

	<?php get_sidebar(); ?>
	
	<div id="main">
		<?php if ( have_posts() ) : ?>

			<?php get_template_part( 'loop', 'search' ); ?>

		<?php else : ?>

			<div class="lepost clearfix">
				<h2><?php _e( 'Nothing Found', 'launcheffect' ); ?></h2>
				<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'launcheffect' ); ?></p>
			</div>
		<?php endif; ?>

	</div>
	<?php get_template_part('launch/launch','footer'); ?>
	
</div> <!-- end #wrapper -->

<?php get_footer(); ?>