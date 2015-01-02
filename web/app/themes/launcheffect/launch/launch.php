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
			<div id="signup" class="<?php
				echo 'medium center nocf';
				$lefx_editorcontent_placement = ler('lefx_editorcontent_placement');
			?>">

				<div id="fb-like-container">
					<div class="fb-like" data-href="https://www.facebook.com/thepololife" data-layout="button_count"></div>
				</div>


				<div id="signup-content-wrapper">
					<!-- DISPLAY HEADER IMAGE AND TEXT -->
						<header class="no-margin">
							<h1 class="haslogo hastextheading">
					  			<img src="/app/themes/launcheffect/im/header.png" alt="Miami Beach Polo World Cup" />
								<div id="bigtext">
									<span>Miami Beach &#9816; April 23-25, 2015</span>
								</div>
							</h1>
						</header>

					<div id="signup-body">
						<!-- DISPLAY CONFIRMATION TEXT AFTER SIGN UP -->
						<div id="success-content">
							<h2>Congrats, You're in the Know!</h2>
						</div>

						<!-- DISPLAY EMAIL SIGNUP FORM -->
						<form id="form" action="" class="signup-right">
							<?php wp_nonce_field('pre_signup','verify_pre_signup'); ?>

							<input type="hidden" id="action" name="action" value="le_submit" />
							<input type="hidden" id="referredBy" name="referredBy" value="<?php echo @$_GET['ref']; ?>" />
							<fieldset>
								<input type="hidden" name="code" id="code" value="<?php codeCheck(); ?>" />
								<ul id="form-layout">
									<li class="first">

									    <div id="email-layout">
									        <span id="emailinput">
									            <input type="email" id="email" name="email" placeholder="Your Email" />
									        </span>

											<!-- DISPLAY THE SUBMIT BUTTON -->
											<span id="submit-button-border" id="button">
												<span id="submit-button-spinner"></span>
												<input type="submit" name="submit" value="Sign Up" id="submit-button" />
											</span>
									    </div>

										<!-- HANDLE ERROR MESSAGING -->
										<div id="error"></div>

										<!-- PRIVACY POLICY LINK -->
										<!-- <li>
											<span class="privacy-policy">Sign Up, <br/ ><span style="color: #FFD1DC;">Stay in the Know</span></span>
										</li> -->
									</li>
								</ul>
							</fieldset>
						</form>

						<!-- EMAIL SIGNUP FORM  (POST-SIGNUP) -->
						<form id="success" action="">
							<fieldset>

								<!-- RETURNING USER -->
								<div id="returninguser">
									<!-- "Congrats, You're in the Know!" -->
									<h2>Congrats, You're in the Know!</h2>
								</div>

								<!-- NEW USER -->
								<div id="newuser">
									<div id="pass_thru_error"></div>
								</div>

							</fieldset>
						</form>
					</div>

					<!-- DISPLAY SOCIAL MEDIA ICONS -->
					<!-- <ul id="inner-footer" class="clearfix">
						<li class="inner-footer_icon facebook"><a href="https://www.facebook.com/thepololife" target="_blank">Facebook</a></li>
						<li class="inner-footer_icon twitter"><a href="https://twitter.com/thepololife" target="_blank">Twitter</a></li>
						<li class="inner-footer_icon instagram"><a href="http://instagram.com/thepololife" target="_blank">Instagram</a></li>
						<li class="inner-footer_icon youtube"><a href="https://www.youtube.com/user/MiamiBeachPolo" target="_blank">YouTube</a></li>
					</ul> -->

					<!-- DISPLAY SPONSOR LOGOS -->
					<div id="sponsor-logos">
						<img src="/app/themes/launcheffect/im/sponsors.png" alt="Sponsors - Miami Beach Polo World Cup" />
					</div>

					<!-- SPONSOR US LINK -->
					<div id="learn-more-tab">
						<a href="mailto:info@actproductions.com" id="learn-more">sponsor us &rsaquo;</a>
					</div>

					<div id="bgndVideo" class="player"
						data-property="{
							videoURL:'https://www.youtube.com/watch?v=xDKuSRdTTp4',
							containment:'body',
							autoPlay:true,
							mute:true,
							startAt:0,
							opacity:0.3,
							ratio:'auto',
							loop:true,
							showYTLogo:false,
							showControls:false,
							addRaster:true,
							stopMovieOnBlur:false
						}">
					</div>
				</div>
			</div>
		</div>
	</div>
