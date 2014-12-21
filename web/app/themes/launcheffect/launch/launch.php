<?php
/**
 * Launch Template Include
 *
 * Contains the shell around the Launch form
 *
 * @package WordPress
 * @subpackage Launch_Effect
 *
 */

$placed_content = sprintf('<div id="signup-editor-content">%s</div>', wpautop(get_the_content()));
?>

	<div id="signup-page-wrapper">
		<div id="signup-page">
			<!-- SPONSOR US BUTTON -->
			<div id="learn-more-tab">
				<a href="mailto:info@actproductions.com" id="learn-more">sponsor us &rsaquo;</a>
			</div>

			<div id="signup" class="<?php
				echo 'medium center nocf';
				$lefx_editorcontent_placement = ler('lefx_editorcontent_placement');
			?>">
				<div id="signup-content-wrapper">
					<?php if('At Top' == $lefx_editorcontent_placement) echo $placed_content; ?>

					<!-- LOGO / HEADER -->
					<header class="no-margin">
						<h1 class="haslogo hastextheading">
				  			<img src="/app/themes/launcheffect/im/thepololife-logo.png" alt="The Polo Life, LLC." />
							<span >April 23-25th, 2015 &#9816; South Beach Miami</span>
						</h1>
					</header>

					<?php if('After Logo' == $lefx_editorcontent_placement) echo $placed_content; ?>

					<?php if($video_embed = ler('video_embed')) :?>

					<!-- YOUTUBE / VIMEO EMBED -->
					<?php echo $video_embed; ?>
					<?php endif; ?>
					<?php if('After Video' == $lefx_editorcontent_placement) echo $placed_content; ?>

					<!-- PROGRESS INDICATORS (Premium) -->
					<?php if(lefx_version() == 'premium') get_template_part('premium/progress'); ?>
					<?php if('After Progress Indicators' == $lefx_editorcontent_placement) echo $placed_content; ?>

					<div id="signup-body">
						<!-- H2 SUBHEADING / P DESCRIPTION (PRESIGNUP) -->
						<div id="presignup-content" class="signup-left"></div>

						<!-- H2 SUBHEADING / P DESCRIPTION (SUCCESS) -->
						<div id="success-content">
							<?php if($subheading_content2 = ler('subheading_content2')) :?><h2><?php echo $subheading_content2; ?></h2><?php endif; ?>

							<?php if('After Subheading' == $lefx_editorcontent_placement) echo $placed_content; ?>

							<?php if($description_content2 = ler('description_content2')) echo wpautop($description_content2); ?>

							<?php if('After Body Text' == $lefx_editorcontent_placement) echo $placed_content; ?>

						</div>

						<!-- FORM -->
						<?php get_template_part('launch/launch','form'); ?>
						<?php if('After Sign-Up Form' == $lefx_editorcontent_placement) echo $placed_content; ?>

					</div>

					<!-- LINK TO BLOG/OTHER WEBSITES -->
					<?php get_template_part('launch/launch','footer'); ?>

					<!-- LOOP CONTENT (AT BOTTOM) -->
					<?php if('At Bottom' == $lefx_editorcontent_placement) echo $placed_content; ?>

				</div> <!-- end #signup-content-wrapper -->
			</div> <!-- end #signup -->
		</div> <!-- end #signup-page -->
	</div> <!-- end #signup-page-wrapper -->
