<?php
/**
 * Launch Form
 *
 * @package WordPress
 * @subpackage Launch_Effect
 *
 */
?>
<!-- DISPLAY MAILCHIMP INTEGRATION -->
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