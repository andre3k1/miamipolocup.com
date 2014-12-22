<?php
/**
 * Category Template (Premium)
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
		<?php // TODO: Move to archive.php with is_category() template tag.
			$category_description = category_description();
			if ( ! empty( $category_description ) )
				echo '' . $category_description . '';
		get_template_part( 'loop', 'category' );
		?>
	</div>

	<?php get_template_part('launch/launch','footer'); ?>

</div> <!-- end #wrapper -->

<?php get_footer(); ?>