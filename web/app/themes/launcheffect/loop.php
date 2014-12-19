<?php
/**
 * Loop (Premium)
 *
 * Displays the posts
 *
 * @package WordPress
 * @subpackage Launch_Effect
 *
 */
?>
<?php if ( ! have_posts() ) : ?>

	<h1><?php _e( 'Not Found', 'launcheffect' ); ?></h1>
	<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'launcheffect' ); ?></p>
	<?php get_search_form(); ?>

<?php endif; ?>
<?php while ( have_posts() ) : the_post(); ?>
	<?php if ( in_category( _x('gallery', 'gallery category slug', 'launcheffect') ) ) : ?>

		<h2><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
		<?php lefx_posted_on(); ?>
		<?php if ( post_password_required() ) : the_content(); else : ?>
		<?php
			$images = get_children(array( 
				'post_parent' => $post->ID, 
				'post_type' => 'attachment', 
				'post_mime_type' => 'image', 
				'orderby' => 'menu_order', 
				'order' => 'ASC', 
				'numberposts' => 999,
			));
			$total_images = count( $images );
			$image = array_shift( $images );
			$image_img_tag = wp_get_attachment_image( $image->ID, 'thumbnail' );
		?>

		<a href="<?php the_permalink(); ?>"><?php echo $image_img_tag; ?></a>
		<p><?php printf( __( 'This gallery contains <a %1$s>%2$s photos</a>.', 'launcheffect' ),
			'href="' . get_permalink() . '" title="' . sprintf( esc_attr__( 'Permalink to %s' ), 
			the_title_attribute( 'echo=0' ) ) . '" rel="bookmark"',
			$total_images
		); ?></p>
		<?php the_excerpt(); ?>
		<?php endif; ?>

		<a href="<?php echo get_term_link( _x('gallery', 'gallery category slug', 'launcheffect'), 'category' ); ?>" title="<?php esc_attr_e( 'View posts in the Gallery category' ); ?>"><?php _e( 'More Galleries', 'launcheffect' ); ?></a> | 
		<?php comments_popup_link( __( 'Leave a comment', 'launcheffect' ), __( '1 Comment', 'launcheffect' ), __( '% Comments', 'launcheffect' ) ); ?>
		<?php edit_post_link( __( 'Edit', 'launcheffect' ), '|', '' ); ?>

	<?php elseif ( in_category( _x('asides', 'asides category slug', 'launcheffect') ) ) : ?>

		<?php if ( is_archive() || is_search() ) : the_excerpt(); ?>
		<?php else : the_content( __( 'Continue reading &rarr;', 'launcheffect' ) ); ?>
		<?php endif; ?>
		<?php lefx_posted_on(); ?> | 
		<?php comments_popup_link( __( 'Leave a comment', 'launcheffect' ), __( '1 Comment', 'launcheffect' ), __( '% Comments', 'launcheffect' ) ); ?>
		<?php edit_post_link( __( 'Edit', 'launcheffect' ), '| ', '' ); ?>

	<?php else : ?>

		<div class="lepost clearfix">
			<h2 class="posttitle"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
			<?php lefx_posted_on(); ?>

		<?php if ( is_archive() || is_search() /*|| is_home()*/ ) : the_excerpt(); else : ?>
			<?php if(has_post_thumbnail()) the_post_thumbnail('blog-thumbnail'); ?>
			<?php the_content( __( 'Continue reading &rarr;', 'launcheffect' ) ); ?>
			<?php wp_link_pages( array( 'before' => '' . __( 'Pages:', 'launcheffect' ), 'after' => '' ) ); ?>
		<?php endif; ?>
				
			<div class="postmeta">
				<p>Posted by <?php the_author_posts_link(); ?> in 
					<?php if ( count( get_the_category() ) ) : ?>
						<?php printf( __( '%2$s', 'launcheffect' ), 'entry-utility-prep entry-utility-prep-cat-links', get_the_category_list( ', ' ) ); ?>
						&nbsp;/&nbsp;
					<?php endif; ?>
					
					<?php comments_popup_link( __( 'Comment', 'launcheffect' ), __( '1 Comment', 'launcheffect' ), __( '% Comments', 'launcheffect' ) ); ?>
					<?php edit_post_link( __( 'Edit', 'launcheffect' ), '&nbsp;/&nbsp; ', '' ); ?>
				</p>
				<?php $tags_list = get_the_tag_list( '', ', ' ); if ( $tags_list ): ?>

				<p><?php printf( __( 'Tagged %2$s', 'launcheffect' ), 'entry-utility-prep entry-utility-prep-tag-links', $tags_list ); ?></p>
				<?php endif; ?>				

			</div>
		</div>
		<?php if (is_single()&&get_option('disable_social_media') != 'true') get_template_part('launch/launch','social'); ?>
		<?php comments_template( '', true ); ?>

	<?php endif; // if statement broken into three parts based on categories. ?>

<?php endwhile; // End the loop. Whew. ?>

<?php if (  $wp_query->max_num_pages > 1 ) : ?>

	<ul id="postnav" class="clearfix">
		<li class="left"><?php next_posts_link( __( '&larr; Older posts', 'launcheffect' ) ); ?></li>
		<li class="right"><?php previous_posts_link( __( 'Newer posts &rarr;', 'launcheffect' ) ); ?></li>
	</ul>
<?php elseif ( is_single() ) : ?>

	<ul id="postnav" class="clearfix">
		<li class="left"><?php previous_post_link(); ?></li>
		<li class="right"><?php next_post_link(); ?></li>
	</ul>
<?php endif; ?>