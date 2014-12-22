<?php
/**
 * Launch Module Slidedown Template (Premium)
 *
 * @package WordPress
 * @subpackage Launch_Effect
 *
 */
?>
			<div id="signup" class="<?php echo (get_option('lefx_cust_field1')) ? 'hascf': 'nocf'; ?> clearfix">

				<!-- H2 SUBHEADING / P DESCRIPTION (PRESIGNUP) -->
				<div id="signup-body">
					<div id="presignup-content" class="signup-left">
						<?php if($subheading_content = ler('subheading_content')) :?><h2><?php echo $subheading_content; ?></h2><?php endif; ?>

						<?php if($description_content = ler('description_content')) echo wpautop($description_content); ?>

					</div>

					<!-- H2 SUBHEADING / P DESCRIPTION (SUCCESS) -->
					<div id="success-content">
						<?php if($subheading_content2 = ler('subheading_content2')) :?><h2><?php echo $subheading_content2; ?></h2><?php endif; ?>

						<?php if($description_content2 = ler('description_content2')) echo wpautop($description_content2); ?>

					</div>

					<!-- FORM -->
					<?php get_template_part('launch/launch','form'); ?>

				</div><!-- end #signup-body -->
			</div> <!-- end #signup -->