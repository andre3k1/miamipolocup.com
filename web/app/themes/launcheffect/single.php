<?php 
/**
 * Single Post Template
 *
 * @package WordPress
 * @subpackage Launch_Effect
 * 
 */
 
get_header(); 
?>

<?php if(lefx_version() == 'premium'): ?>
	
	<?php get_template_part('premium/theme','header'); ?>
	
	<?php get_sidebar(); ?>
	
	<div id="main">
		<?php get_template_part( 'loop', 'index' );?>
	</div>
	
	<?php get_template_part('launch/launch','footer'); ?>
	
</div> <!-- end #wrapper -->
	
<?php else: ?>

	<div id="wrapper">
		<header>
			<h1><a href="<?php echo home_url(); ?>">LAUNCH EFFECT</a></h1>
		</header>
		<div id="main">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<div class="lepost clearfix">
				<h2 class="posttitle"><a href="#"><?php the_title(); ?></a></h2>
				<?php the_content(); ?>
			</div>
			<?php endwhile; else: endif; ?>
		</div>
	</div> <!-- end #wrapper -->

<?php endif; ?>

<?php get_footer(); ?>