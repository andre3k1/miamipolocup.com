<?php 
/**
 * Main Template File
 *
 * If WordPress is set to load blog posts on the homepage, it loads the blog posts.
 * Otherwise, it loads the launch.php include for the Launch page
 *
 * @package WordPress
 * @subpackage Launch_Effect
 * 
 */

get_header(); ?>

<?php /* IF REFERRAL LINK, GET LAUNCH PAGE */ ?>
<?php if (isset($_GET['ref'])||isset($_GET['fb_ref'])): ?>

	<?php get_template_part('launch/launch'); ?>

<?php elseif(is_home()): ?>

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

<?php else: ?>
	<?php 
	/*
	 * ***DEPRECATED***
	 * Since we transitioned referral codes to be query strings 
	 * we should remove the below after people have had time to transition.
	 */
	get_template_part('launch/launch'); 
	?>

<?php endif; ?>

<?php get_footer(); ?>