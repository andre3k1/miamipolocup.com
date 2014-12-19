<?php
/**
 * Launch Form
 *
 * @package WordPress
 * @subpackage Launch_Effect
 *
 */
?>
					<!-- FORM (PRE-SIGNUP) -->
					<form id="form" action="" class="signup-right">
						<?php wp_nonce_field('pre_signup','verify_pre_signup'); ?>

						<input type="hidden" id="action" name="action" value="le_submit" />
						<input type="hidden" id="referredBy" name="referredBy" value="<?php echo @$_GET['ref']; ?>" />
						<fieldset>
							<input type="hidden" name="code" id="code" value="<?php codeCheck(); ?>" />
							<ul id="form-layout">
								<li class="first">
									<?php if( $label_content = ler('label_content')) : ?>

									<label for="email">
										<?php echo $label_content; if(ler('lefx_req_indicator')) echo '<span> *</span>'; ?>
										<?php if(get_option('lefx_reuser_enable') == true) : ?>

										<a href="#" id="reusertip">
											<?php echo ($lefx_reuser_label = ler('lefx_reuser_label')) ? $lefx_reuser_label: __('Returning User?', 'launcheffect'); ?>

											<div id="reuserbubble">
												<?php echo ($lefx_reuser_bubble = ler('lefx_reuser_bubble')) ? $lefx_reuser_bubble : __('Simply enter your email address and submit the form to view your stats.', 'launcheffect'); ?>
												<div class="reuserbubble-arrow-border"></div>
												<div class="reuserbubble-arrow"></div>
											</div>
										</a>
										<?php endif; ?>	

									</label>
									<?php endif; ?>
									
									<!-- START IF NO CUSTOM FIELDS //////////////////////////////////////////////////////////////////// -->
									<?php if(!get_option('lefx_cust_field1')) : ?>
										
								    <div id="email-layout">
								        <span id="emailinput">
								            <input type="email" id="email" name="email" />
								        </span>
										<!-- SUBMIT BUTTON -->
										<span id="submit-button-border">
											<span id="submit-button-spinner"></span>
											<input type="submit" name="submit" value="<?php if(ler('label_submitbutton')) { le('label_submitbutton'); } else { echo 'GO'; } ?>" id="submit-button" />
										</span>		
								    </div>
									
									<!-- ERROR MESSAGING -->
									<div id="error"></div>
								</li>
								
 								<?php if(get_option('lefx_captcha')) : ?>

								<!-- START CAPTCHA -->
								<li class="captcha-holder">
									<label for="captcha" id="spambot"><?php le('captcha_label');?></label>
									<div class="input-holder-cap">
										<input id="num1" class="sum" type="text" name="num1" value="<?php echo rand(1,4) ?>" readonly="readonly" /> <span class="calc">+</span>
										<input id="num2" class="sum" type="text" name="num2" value="<?php echo rand(5,9) ?>" readonly="readonly" /> <span class="calc">=</span>
										<input id="captcha" class="captcha" type="text" name="captcha" maxlength="2" />
									</div>
								</li>
								<?php endif; ?>

								<?php else: ?>

									<input type="email" id="email" name="email" />
									
									<!-- ERROR MESSAGING -->
									<div id="error"></div>
								</li>
								<?php endif; ?>
								
								<!-- INCLUDE CUSTOM FIELDS (Premium) -->
								<?php if(lefx_version() == 'premium') get_template_part('premium/custom','fields'); ?>				
                                <?php if(get_option('lefx_cust_field1')) : ?>

                                <?php if(get_option('lefx_captcha')) : ?>

                                <!-- START IF CAPTCHA \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\ -->
                                <li class="captcha-holder">
                                    <label for="captcha" id="spambot"><?php le('captcha_label');?></label>
                                    <div class="input-holder-cap">
                                        <input id="num1" class="sum" type="text" name="num1" value="<?php echo rand(1,4) ?>" readonly="readonly" /> <span class="calc">+</span>
                                        <input id="num2" class="sum" type="text" name="num2" value="<?php echo rand(5,9) ?>" readonly="readonly" /> <span class="calc">=</span>
                                        <input id="captcha" class="captcha" type="text" name="captcha" maxlength="2" />
                                    </div>
                                </li>
								<?php endif; ?>

								<li class="hascf-submit-button">					
									<!-- SUBMIT BUTTON -->
									<span id="submit-button-border">
										<span id="submit-button-spinner"></span>
										<input type="submit" name="submit" value="<?php echo ($label_submitbutton = ler('label_submitbutton')) ? $label_submitbutton : 'GO'; ?>" id="submit-button" />
									</span>
								</li>
								<?php endif; ?>
								<?php if(get_option('lefx_enable_privacy_policy') == true) : ?>

								<!-- PRIVACY POLICY LINK -->
								<li>
									<span class="privacy-policy">
										<?php le('lefx_privacy_policy_label');?> <a href="#" id="modal-privacy" class="modal-trigger"><?php le('lefx_privacy_policy_heading'); ?></a>
									</span>	
								</li>
								<?php endif; ?>	

							</ul>
						</fieldset>
					</form>
					
					<!-- FORM (POST-SIGNUP) -->
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
							
							<?php if(get_option('disable_social_media') != 'true') : ?>

							<!-- SOCIAL MEDIA BUTTONS -->
							<div class="signup-left">
								<?php get_template_part('launch/launch','social'); ?>
							</div>	
							<?php endif; ?>
							
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
