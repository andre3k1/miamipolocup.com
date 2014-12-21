<?php
/**
 * Launch Form
 *
 * @package WordPress
 * @subpackage Launch_Effect
 *
 */
?>
					<!-- EMAIL SIGNUP FORM (PRE-SIGNUP) -->
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
								            <input type="email" id="email" name="email" placeholder="Your Email Address" />
								        </span>

										<!-- SUBMIT BUTTON -->
										<span id="submit-button-border">
											<span id="submit-button-spinner"></span>
											<input type="submit" name="submit" value="Sign Up" id="submit-button" />
										</span>
								    </div>

									<!-- ERROR MESSAGING -->
									<div id="error"></div>
								</li>


								<!-- PRIVACY POLICY LINK -->
								<li>
									<span class="privacy-policy">Sign Up, Stay in the Know</span>
								</li>

							</ul>
						</fieldset>
					</form>

					<!-- EMAIL SIGNUP FORM  (POST-SIGNUP) -->
					<form id="success" action="">
						<fieldset>

							<!-- RETURNING USER -->
							<div id="returninguser">
								<h2><?php le('returning_subheading'); ?></h2>

								<?php if(is_page_template( 'launch.php' ) && ($lefx_content_placement = ler('lefx_editorcontent_placement')) && 'After Subheading' == $lefx_content_placement) : ?>
								<!-- LOOP CONTENT (AFTER SUBHEADING) -->
								<div id="signup-editor-content" class="clearfix"><?php the_content(); ?></div>
								<?php endif; ?>

								<p>
									<?php le('returning_text'); ?> <span class="user"> </span>.<br />

									<span <?php if(get_option('disable_unique_link') == 'true') echo ' class="disable"'; ?>>
										<span class="clicks"> </span>&nbsp;<?php le('returning_clicks'); ?><br />
									</span>

									<span <?php if(get_option('disable_unique_link') == 'true') echo ' class="disable"'; ?>>
										<span class="conversions"></span>&nbsp;<?php le('returning_signups'); ?>

									</span>
									<br /><br />
								</p>

								<?php if(is_page_template( 'launch.php' ) && 'After Body Text' == $lefx_content_placement) : ?>
								<!-- LOOP CONTENT (AFTER SUBHEADING) -->
								<div id="signup-editor-content"><?php the_content(); ?></div>
								<?php endif; ?>

							</div>

							<!-- SOCIAL MEDIA BUTTONS -->
							<div class="signup-left">
								<?php get_template_part('launch/launch','social'); ?>
							</div>

							<!-- RETURNING USER REFERRAL URL -->
							<div id="returninguserurl">
								<div class="signup-right<?php if(get_option('disable_unique_link') == 'true') echo ' disable'; ?>">
									<?php if($label_success_content = ler('label_success_content')) : ?>

									<label><?php echo $label_success_content; ?></label>
									<?php endif; ?>

									<input type="text" id="returningcode" value="" onclick="LE_Handlers.SelectAll('returningcode');"/>
								</div>
							</div>

							<!-- NEW USER -->
							<div id="newuser">
								<div class="signup-right<?php if(get_option('disable_unique_link') == 'true') { echo ' disable'; } ?>">
									<?php if($label_success_content) : ?>

									<label for="email"><?php le('label_success_content'); ?></label>
									<?php endif; ?>

									<input type="text" id="successcode" value="" onclick="LE_Handlers.SelectAll('successcode');"/>
								</div>
								<div id="pass_thru_error"></div>
							</div>

						</fieldset>
					</form>
