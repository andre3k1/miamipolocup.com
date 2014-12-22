<?php
/**
 * Author Template (Premium)
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
		<?php // TODO: Move to archive.php with is_author() template tag.
			if ( have_posts() )
				the_post();
			rewind_posts();
			get_template_part( 'loop', 'author' );
		?>
	</div>

	<?php get_template_part('launch/launch','footer'); ?>

</div> <!-- end #wrapper -->

<?php get_footer(); ?>