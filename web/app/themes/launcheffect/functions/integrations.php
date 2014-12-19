<?php 
/**
 * Functions: integrations.php
 *
 * Builds the Integrations theme options page
 *
 * @package WordPress
 * @subpackage Launch_Effect
 *
 */

class LE_Integrations_Admin_Page extends LE_Admin_Page {

	function __construct($args){
		parent::__construct($args);
		$this->suppress_submenu = false;
	}

	function build_le_integrations_options_page(){
		?>

		<div class="wrap le-wrapper">
			<?php

				lefx_tabs($this->panel_name);
				lefx_exploder_message();
				settings_errors();

			?>

			<div class="le-intro no-heading">
				<p>You can use the controls on this page to configure other apps you might want to use in conjunction with Launch Effect. If you're having any issues, please feel free to contact us at our <a href="http://launcheffect.tenderapp.com" target="_blank">support forums</a>.</p>
			</div>		
			<?php lefx_form($this->panel_name, $this->panel_array); ?>

		</div>
		<?php
	}
}

new LE_Integrations_Admin_Page(array(
	'title' => 'Integrations',
	'name' => 'integrations_options',
	'options' => array(
		'MailChimp' => array(
			array( // subsection
				array(
					'label' => 'API Key',
					'type' => 'chimpkey',
					'class' => 'le-twocol',
					'option_name' => 'lefx_mcapikey',
					'desc' => '',
					'subtype' => '',
					'premium' => '',
				),
			),
			array( // subsection
				array(
					'label' => 'Select a List',
					'type' => 'chimplist',
					'class' => 'le-twocol chimpsync',
					'option_name' => 'lefx_mclistid',
					'desc' => '',
					'subtype' => '',
					'premium' => '',
				),
			),
			array( // subsection
				array(
					'label' => 'Disable Double Opt-In',
					'type' => 'check',
					'class' => 'le-twocol',
					'option_name' => 'lefx_mcdouble',
					'desc' => "MailChimp and Launch Effect <strong>do not</strong> recommend disabling double opt-in!<br />Here's a <a href=\"http://blog.mailchimp.com/prankster-pollutes-obama%E2%80%99s-e-mail-list/\" target=\"_blank\">great example</a> of why and <a href=\"http://kb.mailchimp.com/article/how-does-confirmed-optin-or-double-optin-work/\" target=\"_blank\">details about how double opt-in works and why we recommend it over other methods</a>.<br /><br /><strong>Please Note:</strong> If you disable double opt-in, users will not receive signup confirmation/welcome emails from MailChimp and you will not receive notification that new users have signed up.<br />",
					'subtype' => '',
					'premium' => '',
				),
			)
		),
		'AWeber' => array(
			array( // subsection
				array(
					'label' => 'Authorize Link',
					'type' => 'aweberauthurl',
					'class' => 'le-twocol',
					'option_name' => '',
					'desc' => "Follow this link to generate your AWeber authorization code.",
					'subtype' => '',
					'premium' => '',
				),
			),
			array( // subsection
				array(
					'label' => 'Authorization Code',
					'type' => 'aweberauthcode',
					'class' => 'le-twocol',
					'option_name' => 'lefx_aweberauthcode',
					'desc' => 'Paste your AWeber Authorization Code here.',
					'subtype' => '',
					'premium' => '',
				),
			),
			array( // subsection
				array(
					'label' => 'Select a List',
					'type' => 'aweberlist',
					'class' => 'le-twocol awebersync',
					'option_name' => 'lefx_aweberlistid',
					'desc' => "Select the subscriber list you'd like Launch Effect sign-ups to be added to (it'll save automatically!).",
					'subtype' => '',
					'premium' => '',
				),
			),
			
		),
		'Campaign Monitor' => array(
			array(
				array( // subsection
					'label' => 'API Key',
					'type' => 'cmkey',
					'class' => 'le-twocol',
					'option_name' => 'lefx_cmapikey',
					'desc' => '',
					'subtype' => '',
					'premium' => '',
				)
			),
			array( // subsection
				array(
					'label' => 'Select a Client',
					'type' => 'cmclient',
					'class' => 'le-twocol cmclient',
					'option_name' => 'lefx_cmclientid',
					'desc' => '',
					'subtype' => '',
					'premium' => '',
				),
			),
			array( // subsection
				array(
					'label' => 'Select a List',
					'type' => 'cmlist',
					'class' => 'le-twocol cmsync',
					'option_name' => 'lefx_cmlistid',
					'desc' => '',
					'subtype' => '',
					'premium' => '',
				),
			),
		),
		'Google Analytics' => array(
			array( // subsection
				array(
					'label' => 'Embed Code',
					'type' => 'textarea',
					'class' => 'le-threecol',
					'option_name' => 'bkt_google',
					'desc' => 'Simply paste your analytics code here. <strong>Important:</strong> Do not include opening and closing script tags!',
					'subtype' => '',
					'premium' => '',
				),
			)
        ),
		'CAPTCHA' => array(
			array( // subsection
				array(
					'label' => 'Enable CAPTCHA for form',
					'type' => 'check',
					'class' => 'le-threecol',
					'option_name' => 'lefx_captcha',
					'desc' => '',
					'subtype' => '',
					'premium' => '',
                ),
                array(
					'label' => 'CAPTCHA Label Text',
					'type' => 'text',
					'class' => 'le-threecol',
					'option_name' => 'captcha_label',
					'desc' => 'ex. Are you human or spambot?',
					'subtype' => '',
					'premium' => '',
				),
			)
		),
	),
));
