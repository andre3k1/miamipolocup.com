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

					<header class="no-margin">
						<!-- DISPLAY HEADER IMAGE AND TEXT -->
						<h1 class="haslogo hastextheading">
				  			<img src="/app/themes/launcheffect/im/header.png" alt="Miami Beach Polo World Cup" />
							<span>Miami Beach &#9816; April 23-25, 2015</span>
						</h1>
					</header>

					<div id="signup-body">
						<!-- DISPLAY CALL-TO-ACTION TEXT BEFORE SIGNUP -->
						<div id="presignup-content" class="signup-left">
							<span class="privacy-policy">Sign Up, Stay in the Know</span>
						</div>
						<!-- DISPLAY CONFIRMATION TEXT AFTER SIGN UP -->
						<div id="success-content">
							<h2>Great, Now You're in the Know!</h2>
						</div>
						<?php get_template_part('launch/launch','form'); ?>
					</div>

					<!-- DISPLAY SOCIAL MEDIA ICONS -->
					<ul id="inner-footer" class="clearfix">
						<li class="inner-footer_icon facebook"><a href="https://www.facebook.com/thepololife" target="_blank">Facebook</a></li>
						<li class="inner-footer_icon twitter"><a href="https://twitter.com/thepololife" target="_blank">Twitter</a></li>
						<li class="inner-footer_icon instagram"><a href="http://instagram.com/thepololife" target="_blank">Instagram</a></li>
						<li class="inner-footer_icon youtube"><a href="https://www.youtube.com/user/MiamiBeachPolo" target="_blank">YouTube</a></li>
						<!-- <li class="inner-footer_icon facebooklike"><div class="fb-like" data-href="https://www.facebook.com/thepololife" data-send="false" data-layout="button_count" data-width="100" data-show-faces="false" data-font="arial"></div></li> -->
					</ul>

					<!-- DISPLAY SPONSOR LOGOS -->
					<img src="/app/themes/launcheffect/im/sponsors.png" alt="Sponsors - Miami Beach Polo World Cup" />

				</div>
			</div>
		</div>
	</div>
