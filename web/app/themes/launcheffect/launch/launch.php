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
			<?php if(lefx_version() == 'premium') if(ler('lefx_pages_enable') != false) : ?>

			<!-- LEARN MORE BUTTON (Premium) -->
			<div id="learn-more-tab">
				<a href="<?php le('lefx_pages_learnmoretab_link'); ?>" id="learn-more"><?php le('lefx_pages_learnmoretab_text'); ?> &rsaquo;</a>	
			</div><?php endif; ?>	
			
			<div id="signup" class="<?php 
				$classNames = array(
					ler('container_width'),
					ler('container_position'),
					(get_option('lefx_cust_field1') ? 'hascf': 'nocf'),
				);
				echo implode(' ', array_filter($classNames));
				$lefx_editorcontent_placement = ler('lefx_editorcontent_placement'); 
			?>">
				<div id="signup-content-wrapper">
					<?php if('At Top' == $lefx_editorcontent_placement) echo $placed_content; ?>	

					<!-- LOGO -->
					<header class="no-margin">
						<?php $logo_src = leimg('bkt_logo', 'bkt_logodisable', 'launchmodule_options'); ?><h1 class="<?php 
							echo (!empty($logo_src) ? 'has' : 'no').'logo '; 
							echo ((ler('heading_disable') == false) ? 'has' : 'no').'textheading'; 
						?>"><?php 
							if(!empty($logo_src)) echo "<img src=\"$logo_src\" alt=\"\" />"; 
							printf("<span>%s</span>", ler('heading_content')); 
						?></h1>
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
						<div id="presignup-content" class="signup-left">
							<?php if($subheading_content = ler('subheading_content')) :?><h2><?php echo $subheading_content; ?></h2><?php endif; ?>

							<?php if('After Subheading' == $lefx_editorcontent_placement) echo $placed_content; ?>

							<?php if($description_content = ler('description_content')) echo wpautop($description_content); ?>

							<?php if('After Body Text' == $lefx_editorcontent_placement) echo $placed_content; ?>

						</div>
						
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
