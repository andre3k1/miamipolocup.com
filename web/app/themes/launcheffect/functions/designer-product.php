<?php
/**
 * Functions: designer-product.php
 *
 * Builds the Designer > Product theme options page
 *
 * @package WordPress
 * @subpackage Launch_Effect
 *
 */

class LE_Product_Admin_Page extends LE_Admin_Page {

	function build_le_product_options_page(){
		?>

		<div class="wrap le-wrapper">
			<?php

				lefx_tabs($this->panel_name);
				lefx_subtabs($this->panel_name);
				lefx_exploder_message();
				settings_errors();

			?>

			<div class="le-intro">
				<h2><?php _e($this->panel_title, 'launcheffect'); ?></h2>
				<p>Premium users can use this page to control an optional product available for sale through PayPal's Buy Now feature. Use the shortcode <code>[le_product]</code> anywhere in your posts or pages to insert the customized Buy Now button. If you're having any issues, please feel free to contact us at our <a href="http://launcheffect.tenderapp.com" target="_blank">support forums</a>.</p>
			</div>
			<?php lefx_form($this->panel_name, $this->panel_array); ?>

		</div>
		<?php
	}
}

new LE_Product_Admin_Page(array(
	'title' => 'Product',
	'name' => 'product_options',
	'options' => array(
		'PayPal Settings' => array(
			array( // subsection
				array(
					'label' => 'PayPal E-Mail Address',
					'type' => 'text',
					'option_name' => 'lefx_product_paypal_email',
					'class' => '',
					'subtype' => '',
					'desc' => 'Don’t have a Paypal account? <a href="https://www.google.com/url?sa=t&rct=j&q=&esrc=s&source=web&cd=1&cad=rja&ved=0CEEQFjAA&url=https%3A%2F%2Fwww.paypal.com%2Fcgi-bin%2Fwebscr%3Fcmd%3D_registration-run&ei=--t-Ub7bAejA4AOttYGABg&usg=AFQjCNFnsVlOpnPpxnIqsleuiUAT2Eyv9Q&sig2=-lbBcFpH85fTDEiEKkyp5Q&bvm=bv.45645796,d.dmg" target="_blank">Register here.</a>',
					'premium' => 'section',
					'std' => ''
				),
			),
			array( // subsection
				array(
					'label' => 'Thank You Page URL',
					'type' => 'text',
					'option_name' => 'lefx_product_thankyou',
					'class' => '',
					'subtype' => '',
					'desc' => 'The URL of the Thank You page you would like to send visitors to after they buy your product. Please use the full URL including http://. You must also activate the Auto Return option within your PayPal account settings.',
					'premium' => 'section',
					'std' => ''
				),
			),
			array( // subsection
				array(
					'label' => 'PayPal Currency Code',
					'type' => 'select',
					'option_name' => 'lefx_product_currency_code',
					'class' => 'le-select_large',
					'selectarray' => array('USD', 'AUD', 'BRL', 'GBP', 'CAD', 'CZK', 'DKK', 'EUR', 'HKD', 'HUF', 'ILS', 'JPY', 'MXN', 'TWD', 'NZD', 'NOK', 'PHP', 'SLN', 'SGD', 'SEK', 'CHF', 'THB'),
					'desc' => 'Select a currency code for your product.',
					'subtype' => '',
					'premium' => 'section',
					'std' => 'USD'
				),
				array(
					'label' => 'Default Country Code',
					'type' => 'select',
					'option_name' => 'lefx_product_country_code',
					'class' => 'le-select_large',
					'selectarray' => array('AF', 'AX', 'AL', 'DZ', 'AS', 'AD', 'AO', 'AI', 'AQ', 'AG', 'AR', 'AM', 'AQ', 'AU', 'AT', 'AZ', 'BS', 'BH', 'BD', 'BB', 'BY', 'BE', 'BZ', 'BJ', 'BM', 'BT', 'BO', 'BA', 'BW', 'BV', 'BR', 'IO', 'BN', 'BG', 'BF', 'BI', 'KH', 'CM', 'CA', 'CV', 'KY', 'CF', 'TD', 'CL', 'CN', 'CX', 'CC', 'CO', 'KM', 'CG', 'CD', 'CK', 'CR', 'CI', 'HR', 'CU', 'CY', 'CZ', 'DK', 'DJ', 'DM', 'DO', 'EC', 'EG', 'SV', 'GQ', 'ER', 'EE', 'ET', 'FK', 'FO', 'FJ', 'FI', 'FR', 'GF', 'PF', 'TF', 'GA', 'GM', 'GE', 'DE', 'GH', 'GI', 'GR', 'GL', 'GD', 'GP', 'GU', 'GT', 'GG', 'GN', 'GW', 'GY', 'HT', 'HM', 'VA', 'HN', 'HK', 'HU', 'IS', 'IN', 'ID', 'IR', 'IQ', 'IE', 'IM', 'IL', 'IT', 'JM', 'JP', 'JE', 'JO', 'KZ', 'KE', 'KI', 'KP', 'KR', 'KW', 'KG', 'LA', 'LV', 'LB', 'LS', 'LR', 'LY', 'LI', 'LT', 'LU', 'MO', 'MK', 'MG', 'MW', 'MY', 'MV', 'ML', 'MT', 'MH', 'MQ', 'MR', 'MU', 'YT', 'MX', 'FM', 'MD', 'MC', 'MN', 'MS', 'MA', 'MZ', 'MM', 'NA', 'NR', 'NP', 'NL', 'AN', 'NC', 'NZ', 'NI', 'NE', 'NG', 'NU', 'NF', 'NP', 'NO', 'OM', 'PK', 'PW', 'PS', 'PA', 'PG', 'PY', 'PE', 'PH', 'PN', 'PL', 'PT', 'PR', 'QA', 'RE', 'RO', 'RU', 'RW', 'SH', 'KN', 'LC', 'PM', 'VC', 'WS', 'SM', 'ST', 'SA', 'SN', 'CS', 'SC', 'SL', 'SG', 'SK', 'SI', 'SB', 'SO', 'ZA', 'GS', 'ES', 'LK', 'SD', 'SR', 'SJ', 'SZ', 'SE', 'CH', 'SY', 'TW', 'TJ', 'TZ', 'TH', 'TL', 'TG', 'TK', 'TO', 'TT', 'TN', 'TR', 'TM', 'TC', 'TV', 'UG', 'UA', 'AE', 'GB', 'US', 'UM', 'UY', 'UZ', 'VU', 'VE', 'VN', 'VG', 'VI', 'WF', 'EH', 'YE', 'ZM', 'ZW'),
					'desc' => 'Select a default country code. This code affects language and formatting of the PayPal checkout pages. See reference <a href="https://cms.paypal.com/us/cgi-bin/?cmd=_render-content&content_ID=developer/e_howto_html_countrycodes" target="_blank">here</a>.',
					'subtype' => '',
					'premium' => 'section',
					'std' => 'US'
				),
			),
			array( // subsection
				array(
					'label' => 'Activate PayPal Sandbox',
					'type' => 'check',
					'option_name' => 'lefx_paypal_sandbox',
					'class' => 'le-check',
					'subtype' => '',
					'desc' => 'Activate PayPal sandbox mode for testing the checkout process. You must be signed into your developer/sandbox account at developer.paypal.com for this mode to work properly.',
					'premium' => 'section',
					'std' => false
				),
			),
		),
		'Product Information' => array(
			array( // subsection
				array(
					'label' => 'Allow Product Quantity',
					'type' => 'check',
					'option_name' => 'lefx_product_allow_qty',
					'class' => 'le-check',
					'subtype' => '',
					'desc' => 'This will display a dropdown of numbers for use as the purchasable quantity.',
					'premium' => 'section',
					'std' => false
				),
				array(
					'label' => 'Max Product Quantity',
					'type' => 'text',
					'option_name' => 'lefx_product_max_qty',
					'class' => '',
					'subtype' => '',
					'desc' => 'This is the maximum quantity that can be purchased at a time.',
					'premium' => 'section',
					'std' => '10'
				),
			),
			array( // subsection
				array(
					'label' => 'Product Name',
					'type' => 'text',
					'option_name' => 'lefx_product_name',
					'subtype' => '',
					'desc' => 'List the name of the product you would like to sell here.',
					'class' => '',
					'premium' => 'section',
					'std' => ''
				),
			),
			array( // subsection
				array(
					'label' => 'Product Price',
					'type' => 'text',
					'option_name' => 'lefx_product_price',
					'class' => '',
					'subtype' => '',
					'desc' => 'The price of your product must be greater than 0. Leave this field blank if you want to allow the customer to have the “pay what you want” option at checkout. Please do not include any currency symbols.',
					'premium' => 'section',
					'std' => ''
				),
			),
		  array( // subsection
				array(
					'label' => 'Product Options Set Name (Optional)',
					'type' => 'text',
					'option_name' => 'lefx_product_options_name',
					'class' => '',
					'subtype' => '',
					'desc' => 'If you have more than one (1) option for your product, enter a set name here (eg. Title, Size, Color, Style).',
					'premium' => 'section',
					'std' => ''
				),
				array(
					'label' => '',
					'type' => 'instructions',
					'option_name' => 'lefx_product_options_instructions',
					'class' => '',
					'subtype' => '',
					'desc' => 'List your product options here. Please note that the pricing listed with these options will override the Product Price field listed above. You can have a maximum of ten (10) product options.',
					'premium' => 'section',
					'std' => ''
				),
				array(
					'label' => 'Option #1 Name',
					'type' => 'prod-opt-name',
					'option_name' => 'lefx_product_option_one',
					'class' => 'le-prod-opt',
					'subtype' => '',
					'desc' => '.',
					'premium' => 'section',
					'std' => ''
				),
				array(
					'label' => 'Option #1 Price',
					'type' => 'prod-opt-price',
					'option_name' => 'lefx_product_option_one_price',
					'class' => 'le-prod-opt-price',
					'subtype' => '',
					'desc' => '.',
					'premium' => 'section',
					'std' => ''
				),
				array(
					'label' => 'Option #2 Name',
					'type' => 'prod-opt-name',
					'option_name' => 'lefx_product_option_two',
					'class' => 'le-prod-opt',
					'subtype' => '',
					'desc' => '.',
					'premium' => 'section',
					'std' => ''
				),
				array(
					'label' => 'Option #2 Price',
					'type' => 'prod-opt-price',
					'option_name' => 'lefx_product_option_two_price',
					'class' => 'le-prod-opt-price',
					'subtype' => '',
					'desc' => '.',
					'premium' => 'section',
					'std' => ''
				),
				array(
					'label' => 'Option #3 Name',
					'type' => 'prod-opt-name',
					'option_name' => 'lefx_product_option_three',
					'class' => 'le-prod-opt',
					'subtype' => '',
					'desc' => '.',
					'premium' => 'section',
					'std' => ''
				),
				array(
					'label' => 'Option #3 Price',
					'type' => 'prod-opt-price',
					'option_name' => 'lefx_product_option_three_price',
					'class' => 'le-prod-opt-price',
					'subtype' => '',
					'desc' => '.',
					'premium' => 'section',
					'std' => ''
				),
				array(
					'label' => 'Option #4 Name',
					'type' => 'prod-opt-name',
					'option_name' => 'lefx_product_option_four',
					'class' => 'le-prod-opt',
					'subtype' => '',
					'desc' => '.',
					'premium' => 'section',
					'std' => ''
				),
				array(
					'label' => 'Option #4 Price',
					'type' => 'prod-opt-price',
					'option_name' => 'lefx_product_option_four_price',
					'class' => 'le-prod-opt-price',
					'subtype' => '',
					'desc' => '.',
					'premium' => 'section',
					'std' => ''
				),
				array(
					'label' => 'Option #5 Name',
					'type' => 'prod-opt-name',
					'option_name' => 'lefx_product_option_five',
					'class' => 'le-prod-opt',
					'subtype' => '',
					'desc' => '.',
					'premium' => 'section',
					'std' => ''
				),
				array(
					'label' => 'Option #5 Price',
					'type' => 'prod-opt-price',
					'option_name' => 'lefx_product_option_five_price',
					'class' => 'le-prod-opt-price',
					'subtype' => '',
					'desc' => '.',
					'premium' => 'section',
					'std' => ''
				),
				array(
					'label' => 'Option #6 Name',
					'type' => 'prod-opt-name',
					'option_name' => 'lefx_product_option_six',
					'class' => 'le-prod-opt',
					'subtype' => '',
					'desc' => '.',
					'premium' => 'section',
					'std' => ''
				),
				array(
					'label' => 'Option #6 Price',
					'type' => 'prod-opt-price',
					'option_name' => 'lefx_product_option_six_price',
					'class' => 'le-prod-opt-price',
					'subtype' => '',
					'desc' => '.',
					'premium' => '',
					'std' => ''
				),
				array(
					'label' => 'Option #7 Name',
					'type' => 'prod-opt-name',
					'option_name' => 'lefx_product_option_seven',
					'class' => 'le-prod-opt',
					'subtype' => '',
					'desc' => '.',
					'premium' => 'section',
					'std' => ''
				),
				array(
					'label' => 'Option #7 Price',
					'type' => 'prod-opt-price',
					'option_name' => 'lefx_product_option_seven_price',
					'class' => 'le-prod-opt-price',
					'subtype' => '',
					'desc' => '.',
					'premium' => 'section',
					'std' => ''
				),
				array(
					'label' => 'Option #8 Name',
					'type' => 'prod-opt-name',
					'option_name' => 'lefx_product_option_eight',
					'class' => 'le-prod-opt',
					'subtype' => '',
					'desc' => '.',
					'premium' => 'section',
					'std' => ''
				),
				array(
					'label' => 'Option #8 Price',
					'type' => 'prod-opt-price',
					'option_name' => 'lefx_product_option_five_eight',
					'class' => 'le-prod-opt-price',
					'subtype' => '',
					'desc' => '.',
					'premium' => 'section',
					'std' => ''
				),
				array(
					'label' => 'Option #9 Name',
					'type' => 'prod-opt-name',
					'option_name' => 'lefx_product_option_nine',
					'class' => 'le-prod-opt',
					'subtype' => '',
					'desc' => '.',
					'premium' => 'section',
					'std' => ''
				),
				array(
					'label' => 'Option #9 Price',
					'type' => 'prod-opt-price',
					'option_name' => 'lefx_product_option_nine_price',
					'class' => 'le-prod-opt-price',
					'subtype' => '',
					'desc' => '.',
					'premium' => 'section',
					'std' => ''
				),
				array(
					'label' => 'Option #10 Name',
					'type' => 'prod-opt-name',
					'option_name' => 'lefx_product_option_ten',
					'class' => 'le-prod-opt',
					'subtype' => '',
					'desc' => '.',
					'premium' => 'section',
					'std' => ''
				),
				array(
					'label' => 'Option #10 Price',
					'type' => 'prod-opt-price',
					'option_name' => 'lefx_product_option_ten_price',
					'class' => 'le-prod-opt-price',
					'subtype' => '',
					'desc' => '.',
					'premium' => 'section',
					'std' => ''
				),
			),
			array( // subsection
				array(
					'label' => 'Product Tax Rate',
					'type' => 'text-small',
					'option_name' => 'lefx_product_tax',
					'class' => 'le-tax',
					'subtype' => '',
					'desc' => 'An optional tax rate for your product. Percentage format without the symbol. e.g. 3 = 3%, 100 = 100%',
					'premium' => 'section',
					'std' => ''
				),
			),
			array( // subsection
				array(
					'label' => 'Product Shipping Charge',
					'type' => 'text-small',
					'option_name' => 'lefx_product_shipping',
					'class' => '',
					'subtype' => '',
					'desc' => 'Enter your desired shipping charge. Put 0 for free shipping. Leave blank if you want PayPal to calculate the shipping cost.',
					'premium' => 'section',
					'std' => ''
				),
			),
			array( // subsection
				array(
					'label' => 'Product ID',
					'type' => 'text-small',
					'option_name' => 'lefx_product_id',
					'class' => '',
					'subtype' => '',
					'desc' => 'An optional SKU/ID for your product.',
					'premium' => 'section',
					'std' => ''
				),
			),
		),
		'Styles' => array(
			array( // subsection
				array(
					'label' => 'Submit Button Text',
					'type' => 'text',
					'option_name' => 'lefx_product_submit_text',
					'subtype' => '',
					'desc' => '',
					'class' => '',
					'premium' => 'section',
					'std' => 'Buy Now'
				),
				array(
					'label' => 'Text Size',
					'type' => 'select',
					'option_name' => 'buy_now_font_size',
					'selectarray' => array('1.1', '1.2', '1.3', '1.4', '1.6', '1.8', '2.0', '2.2', '2.4', '2.6', '2.8', '3.0', '3.2', '3.4', '3.6', '3.8', '4.0'),
					'class' => 'le-select_small',
					'subtype' => '',
					'desc' => '',
					'premium' => 'section',
					'std' => '2.0'
				),
				array(
					'label' => 'Text Color',
					'type' => 'color',
					'option_name' => 'buy_now_text_color',
					'class' => 'le-color',
					'subtype' => '',
					'desc' => '',
					'premium' => 'section',
					'std' => '#FFFFFF'
				),
				array(
					'label' => 'Font Weight',
					'type' => 'select',
					'option_name' => 'buy_now_font_weight',
					'selectarray' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
					'class' => 'le-select_large',
					'subtype' => '',
					'desc' => 'The font weight for your button\'s text. 400 is equal to normal, 700 is equal to bold. Not all fonts offer all weights',
					'premium' => 'section',
					'std' => '400'
				),
				array(
					'label' => 'Font: Google Web Fonts',
					'type' => 'select',
					'subtype' => 'webfont',
					'option_name' => 'buy_now_goog',
					'class' => 'le-select_large le-select_webfont',
					'selectarray' => array('','Abel','Allerta Stencil','Anton','Architects Daughter','Arvo','Bangers','Bevan','Bowlby One SC','Cabin Sketch:700','Cardo','Chewy','Corben:700','Dancing Script','Delius Swash Caps','Didact Gothic','Forum','Francois One','Geo','Gravitas One','Gruppo','Hammersmith One','IM Fell Double Pica SC','Josefin Sans','Kameron','League Script','Leckerli One','Loved by the King','Maiden Orange','Maven Pro','Muli','Nixie One','Old Standard TT','Oswald','Ovo','Pacifico','Permanent Marker','Playfair Display','Podkova','Pompiere','Raleway:100','Rokkitt','Six Caps','Sniglet:800','Syncopate','Terminal Dosis Light','Ultra','Unna','Varela Round','Yanone Kaffeesatz'),
					'desc' => 'Select from this list if you\'d prefer to use a Google Web Fonts instead of a basic font. Otherwise, leave this blank.',
					'premium' => 'section',
					'std' => 'Podkova'
				),
				array(
					'label' => 'Font: Basic Sets',
					'type' => 'select',
					'option_name' => 'buy_now_font',
					'class' => 'le-select_large',
					'selectarray' => array(
						'Arial, "Helvetica Neue", Helvetica, sans-serif', 'Baskerville, Times, "Times New Roman", serif', 'Cambria, Georgia, Times, "Times New Roman", serif', '"Century Gothic", "Apple Gothic", sans-serif', 'Consolas, "Lucida Console", Monaco, monospace', '"Copperplate Light", "Copperplate Gothic Light", serif', '"Courier New", Courier, monospace', '"Franklin Gothic Medium", "Arial Narrow Bold", Arial, sans-serif', 'Futura, "Century Gothic", AppleGothic, sans-serif', 'Garamond, "Hoefler Text", Palatino, "Palatino Linotype", serif', 'Geneva, Verdana, "Lucida Sans", "Lucida Grande", "Lucida Sans Unicode", sans-serif', 'Georgia, Times, "Times New Roman", serif', '"Gill Sans", "Trebuchet MS", Calibri, sans-serif', 'Helvetica, "Helvetica Neue", Arial, sans-serif', 'Impact, Haettenschweiler, "Arial Narrow Bold", sans-serif', '"Lucida Sans", "Lucida Grande", "Lucida Sans Unicode", sans-serif', 'Palatino, "Palatino Linotype", "Hoefler Text", Times, "Times New Roman", serif', 'Tahoma, Verdana, Geneva', 'Times, "Times New Roman", Georgia, serif', '"Trebuchet MS", Tahoma, Arial, sans-serif', 'Verdana, Tahoma, Geneva, sans-serif'
					),
					'desc' => 'Select a set of basic fonts that you\'d like to use from this list. Please note that any Google Web Fonts selected above will override these basic fonts.',
					'subtype' => '',
					'premium' => 'section',
					'std' => 'Georgia, Times, "Times New Roman", serif'
				),
			),
			array( // subsection
				array(
					'label' => 'Button Width',
					'type' => 'text',
					'option_name' => 'buy_now_button_size',
					'class' => 'le-threecol',
					'subtype' => '',
					'desc' => 'The width of the Buy Now button in pixels, EMs, or percentage. The max-width is set to 100% of parent container width.',
					'premium' => 'section',
					'std' => '150px'
				),
				array(
					'label' => 'Button Height',
					'type' => 'text',
					'option_name' => 'buy_now_button_height',
					'class' => 'le-threecol',
					'subtype' => '',
					'desc' => 'The height of the Buy Now button in pixels or EMs. The max-height is set to 200px.',
					'premium' => 'section',
					'std' => '35px'
				),
			),
			array( // subsection
				array(
					'label' => 'Background Color',
					'type' => 'color',
					'option_name' => 'buy_now_bg_color',
					'class' => 'le-color',
					'subtype' => '',
					'desc' => '',
					'premium' => 'section',
					'std' => '#A69E9E'
				),
			),
			array( // subsection
				array(
					'label' => 'Gradient Background Start',
					'type' => 'color',
					'option_name' => 'buy_now_bg_start',
					'class' => 'le-color',
					'subtype' => '',
					'desc' => '',
					'premium' => 'section',
					'std' => '#A69E9E'
				),
				array(
					'label' => 'Gradient Background End',
					'type' => 'color',
					'option_name' => 'buy_now_bg_end',
					'class' => 'le-color',
					'subtype' => '',
					'desc' => '',
					'premium' => 'section',
					'std' => '#8D8686'
				),
				array(
					'label' => 'Disable Gradient Background',
					'type' => 'check',
					'option_name' => 'buy_now_gradient_disable',
					'class' => 'le-check',
					'subtype' => '',
					'desc' => 'Disable the gradient option and use a solid BG.',
					'premium' => 'section',
					'std' => true
				),
			),
			array( // subsection
				array(
					'label' => 'Button Border Width',
					'type' => 'select',
					'option_name' => 'buy_now_border_width',
					'selectarray' => array('0px', '1px', '2px', '3px', '4px', '5px', '6px', '7px', '8px', '9px', '10px'),
					'class' => 'le-select_small',
					'subtype' => '',
					'desc' => '',
					'premium' => 'section',
					'std' => '1px'
				),
				array(
					'label' => 'Border Color',
					'type' => 'color',
					'option_name' => 'buy_now_border_color',
					'class' => 'le-color',
					'subtype' => '',
					'desc' => '',
					'premium' => 'section',
					'std' => '#8D8686'
				),
				array(
					'label' => 'Button Border Radius',
					'type' => 'text',
					'option_name' => 'buy_now_border_radius',
					'class' => 'le-fx',
					'subtype' => '',
					'desc' => '',
					'premium' => 'section',
					'std' => '5px'
				),
			),
			array( // subsection
				array(
					'label' => 'Show Credit Card Graphic',
					'type' => 'check',
					'option_name' => 'buy_now_show_cc',
					'class' => 'le-check',
					'subtype' => '',
					'desc' => 'Checking this off will display the traditional PayPal Credit Card graphic below your buy now button.',
					'premium' => 'section',
					'std' => false
				),
			),
		),
	),
));
