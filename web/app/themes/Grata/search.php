<?php
define('IS_BLOG', TRUE);

get_header();
?>
<section class="l-section">
	<div class="l-section-h g-html i-cf">

		<div class="l-content">
			<h2><?php echo __('Search Results for', 'us').' "'.$s.'"'; ?></h2>
			
			<div class="g-hr type_invisible"></div>

            <div class="w-blog imgpos_atleft">
                <div class="w-blog-list">
                    <?php while (have_posts()) : the_post();
                        if (has_post_thumbnail()) {
                            $the_thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(), 'blog-list');
                            $the_thumbnail = $the_thumbnail[0];
                        } else {
                            $the_thumbnail =  get_template_directory_uri() .'/img/placeholder/500x500.gif';
                        }
                        ?>
                        <div <?php post_class('w-blog-entry') ?>>
                            <a class="w-blog-entry-link" href="<?php echo get_permalink(get_the_ID());?>">
                            <span class="w-blog-entry-preview">
                                <img src="<?php echo $the_thumbnail;?>" alt="<?php echo get_the_title();?>">
                            </span>
                                <h2 class="w-blog-entry-title">
                                    <span><?php echo get_the_title();?></span>
                                </h2>
                            </a>
                            <div class="w-blog-entry-body">
                                <div class="w-blog-meta">
                                    <div class="w-blog-meta-date">
                                        <span><?php echo get_the_date();?></span>
                                    </div>
                                </div>
                                <div class="w-blog-entry-short">
                                    <?php echo apply_filters('the_excerpt', get_the_excerpt());?>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
			<?php if (function_exists('us_pagination') AND $pagination = us_pagination()) { ?>
				<div class="g-pagination">
					<?php echo $pagination ?>
				</div>
			<?php } else  { ?>
				<div class="g-pagination">
					<?php posts_nav_link(' ', '<span class="g-pagination-item to_prev">&laquo; Prev</span>',  '<span class="g-pagination-item to_next">Next &raquo;</span>'); ?>
				</div>
			<?php } ?>

		</div>
		
		<div class="l-sidebar">
			<?php if (@$smof_data['blog_sidebar_pos'] != 'No Sidebar') {
				dynamic_sidebar('default_sidebar');
			} ?>
		</div>

	</div>
</section>
<?php
get_footer();