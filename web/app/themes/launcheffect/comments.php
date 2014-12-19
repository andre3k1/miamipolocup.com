<?php
/**
 * Comments Template (Premium)
 *
 * @package WordPress
 * @subpackage Launch_Effect
 *
 */
?>

	<?php if ( post_password_required() ) : ?>

		<p><?php _e( 'This post is password protected. Enter the password to view any comments.', 'launcheffect' ); ?></p>
		<?php return; ?>
	<?php endif; ?>

	<div id="respond">

		<h3><?php comment_form_title( 'Comments', 'Reply to %s' ); ?></h3>

	<?php if ('open' == $post->comment_status) : ?>
	
		<p class="comment-messages"><?php cancel_comment_reply_link(); ?></p>
		<?php if ( get_option('comment_registration') && !$user_ID ) : ?>

			<p class="comment-messages">You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">logged in</a> to post a comment.</p>
		<?php else : ?>

		<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
			<p><textarea class="required" name="comment" id="comment" cols="100%" rows="10" tabindex="1" placeholder="Click to leave a comment..."></textarea></p>
		
			<div id="commentsform-hidden">
				<?php if ( $user_ID ) : ?>
			
					<p class="comment-messages">
						Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>.
						<a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log out of this account">Log out &raquo;</a>
					</p>
				<?php else : ?>
			
					<p class="left">
						<label for="comment-author"><small>Name <?php if ($req) echo "(required)"; ?></small></label>
						<input class="required" type="text" name="author" id="comment-author" value="<?php echo $comment_author; ?>" size="22" tabindex="2" />
					</p>
					<p class="right">
						<label for="comment-email"><small>Email (will not be published) <?php if ($req) echo "(required)"; ?></small></label>
						<input class="required" type="text" name="email" id="comment-email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="3" />
					</p>
					<p class="clear">
						<label for="url"><small>Website</small></label>
						<input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="4" />
					</p>
				<?php endif; ?>
			
				<p>
					<input name="submit" type="submit" id="submit" tabindex="5" value="Submit Comment" />
					<?php comment_id_fields(); ?>
				</p>
				<?php do_action('comment_form', $post->ID); ?>
		
			</div>
		</form>

		<?php endif; // If registration required and not logged in ?>
	<?php endif; // if you delete this the sky will fall on your head ?>

	<?php if ( ! comments_open() ) : ?>
		<p class="comment-messages">
			<?php _e( 'Comments are closed.', 'launcheffect' ); ?>
		</p>
	<?php endif; ?>

	</div>

	<?php if ( have_comments() ) : ?>

	<ol class="commentlist">
		<?php wp_list_comments( array( 'callback' => 'lefx_comments' ) ); ?>
	</ol>

	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
	<ul>
		<li id="previous-comments"><?php previous_comments_link( __( '&laquo; Older Comments', 'launcheffect' ) ); ?></li>
		<li id="next-comments"><?php next_comments_link( __( 'Newer Comments &raquo;', 'launcheffect' ) ); ?></li>
	</ul>

	<?php endif; // check for comment navigation ?>

	<?php endif; // end have_comments() ?>