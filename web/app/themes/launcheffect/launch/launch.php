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

			<!-- SPONSOR US LINK -->
			<div id="learn-more-tab">
				<a href="mailto:info@actproductions.com" id="learn-more">sponsor us &rsaquo;</a>
			</div>

			<div id="signup" class="<?php
				echo 'medium center nocf';
				$lefx_editorcontent_placement = ler('lefx_editorcontent_placement');
			?>">

				<div id="signup-content-wrapper">
					<?php if('At Top' == $lefx_editorcontent_placement) echo $placed_content; ?>

					<!-- HEADING -->
					<header class="no-margin">
						<h1 class="haslogo hastextheading">
				  			<img src="/app/themes/launcheffect/im/header.png" alt="The Polo Life, LLC." />
							<span>Miami Beach &#9816; April 23-25, 2015</span>
						</h1>
					</header>

					<div id="signup-body">
						<div id="presignup-content" class="signup-left">
							<span class="privacy-policy">Sign Up, Stay in the Know</span>
						</div>

						<!-- H2 SUBHEADING / P DESCRIPTION (SUCCESS) -->
						<div id="success-content">
							<h2>Great, Now You're in the Know!</h2>
						</div>

						<!-- EMAIL SIGNUP FORM -->
						<?php get_template_part('launch/launch','form'); ?>

					</div>

					<?php get_template_part('launch/launch','footer'); ?>

				</div>
			</div>
		</div>
	</div>
