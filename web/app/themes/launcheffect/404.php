<?php 
/**
 * 404 Template (Premium)
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
		<div class="lepost clearfix">
			<h1><?php le('lefx_pages_404_heading'); ?></h1>
			<?php echo wpautop(ler('lefx_pages_404_message')); ?>

		</div>
	</div>
	
	<?php get_template_part('launch/launch','footer'); ?>
	
</div> <!-- end #wrapper -->

<?php get_footer(); ?>