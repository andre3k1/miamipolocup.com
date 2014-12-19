<?php
/**
 * Functions: designer-global.php
 *
 * Builds the Designer > Global theme options page
 *
 * @package WordPress
 * @subpackage Launch_Effect
 *
 */

class LE_Global_Admin_Page extends LE_Admin_Page {
	
	function build_admin_menu(){
		add_menu_page(
			__('Launch Effect','launcheffect'),
			__('Launch Effect','launcheffect'),
			'manage_options',
			'lefx_'.preg_replace('/\s+/', '', strtolower($this->panel_title)), 
			null,
			get_template_directory_uri()."/functions/im/launch_icon_sm.png"
		);
		add_submenu_page(
			'lefx_designer', 
			__($this->panel_title, 'launcheffect'), 
			__($this->panel_title, 'launcheffect'), 
			'manage_options', 
			'lefx_'.preg_replace('/\s+/', '', strtolower($this->panel_title)), 
			array(&$this,'build_le_plugin_options_page')
		);
	}

	function build_le_plugin_options_page(){
		?>

		<div class="wrap le-wrapper">
			<?php

				lefx_tabs($this->panel_name);
				lefx_subtabs($this->panel_name);
				lefx_exploder_message();
				settings_errors();

			?>

			<div class="le-intro">
				<h2>Global Settings</h2>
				<p>This page controls the styles and settings that carry through all pages and posts of the theme, including the launch module. If you're having any issues, please feel free to contact us at our <a href="http://launcheffect.tenderapp.com" target="_blank">support forums</a>.</p>
			</div>
			<?php lefx_form($this->panel_name, $this->panel_array); ?>

		</div>
		<div id="selector-info" class="jqmWindow">
			<h3>Embedded Font Selectors</h3>
			<h4>Sign-Up Page</h4>
			<ul>
				<li><strong>Learn More Tab:</strong> a#learn-more</li>
				<li><strong>Logo/Title:</strong> #signup-page header h1</li>
				<li><strong>Subheading:</strong> #signup h2</li>
				<li><strong>Field Labels:</strong> #signup label</li>
				<li><strong>Body Text:</strong> #signup p</li>
				<li><strong>Progress Container Heading:</strong> #progress-container h3</li>
			</ul>
	
			<h4>Theme Pages</h4>
			<ul>
				<li><strong>Nav Link:</strong> nav a:link, nav a:visited</li>
				<li><strong>Nav Link (Current Item):</strong> nav li.current_page_item ul li a, nav li.current_page_item a</li>
				<li><strong>Sidebar Heading:</strong> h3.widget-title</li>
				<li><strong>Sidebar Text:</strong> ul#widgets li ul li</li>
				<li><strong>Sidebar Link:</strong> ul#widgets li ul li a:link, ul#widgets li ul li a:visited</li>
				<li><strong>Tagcloud Link:</strong> .tagcloud a</li>
				<li><strong>Post H1:</strong> .lepost h1</li>
				<li><strong>Post H2:</strong> .lepost h2</li>
				<li><strong>Post H3:</strong> .lepost h3</li>
				<li><strong>Post H4:</strong> .lepost h4</li>
				<li><strong>Post Body Text:</strong> .lepost p</li>
				<li><strong>Post Unordered List:</strong> .lepost ul li</li>
				<li><strong>Post Ordered List:</strong> .lepost ol li</li>
			</ul>
		</div>
		<?php
	}
}

new LE_Global_Admin_Page(array(
	'title' => 'Designer',
	'name' => 'plugin_options',
	'options' => array(
		'Thumbnails' => array(
			array( // subsection 
				array( 
					'label' => 'Allow thumbnail size override',
					'type' => 'check',
					'option_name' => 'lefx_pages_thumbnail_override',
					'class' => 'le-check',
					'subtype' => '',
					'desc' => 'This section allows you to override the default thumbnail sizing options in Settings > Media. Only newly uploaded photos will display at the new crop size; old images will not be resized.',
					'premium' => '',
					'std' => ''
				),
			),
		),
		'Meta Data' => array(
			array( // subsection
				array(
					'label' => 'Remove All Meta and<br />Open Graph Tags',
					'type' => 'check',
					'option_name' => 'lefx_meta_disable',
					'class' => 'le-threecol',
					'desc' => 'If you would like to use a plugin or write your own code to manage your meta data and Facebook Open Graph tags (pro tip: use Yoast\'s <a href="http://yoast.com/wordpress/seo/">WordPress SEO Plugin</a>), you will want to check this box!  This will remove all meta tags and Open Graph tags from the Launch Effect theme so as to not conflict with your plugin of choice or custom code.<br /><br /><strong>MORE INFORMATION</strong><br />By meta data, we are basically referring to the paragraph that you see below the title in your Google search result (<a href="http://support.google.com/webmasters/bin/answer.py?hl=en&answer=35624" target="_blank">more info</a>), as well as the information that shows up via Open Graph tags when someone clicks a Facebook "Like" or "Send" button from your website (<a href="http://developers.facebook.com/docs/opengraph/keyconcepts/" target="_blank">more info</a>).<br /><br />By default, Launch Effect uses the description specified below as the meta/Open Graph description for all pages that aren\'t a single page or post.  For single pages or posts, Launch Effect uses an excerpt from that page or post.<br /><br />Similarly, Launch Effect uses the image specified within the Facebook > Facebook Image (og:image) field in the next section as the Open Graph image for all pages that aren\'t a single page or post.  For single pages or post, Launch Effect will try to scrape the article for images it can use.<br /><br />This ensures that your meta description and Open Graph tags are always relevant to the content on the page, which is beneficial for SEO best practices and any social media campaign.',
					'subtype' => '',
					'premium' => '',
					'std' => ''
				),
				array(
					'label' => 'Meta/Open Graph<br />Description (og:description)',
					'type' => 'textarea',
					'class' => 'le-threecol',
					'option_name' => 'bkt_metadesc',
					'desc' => 'This should be a short sentence, under 160 characters in length.  Do not put any line breaks or carriage returns within this text.<br /><br />For single pages and posts, Launch Effect will use an excerpt from that page or post instead of this text.<br /><br /><strong>Facebook Troubleshooting</strong>: If you are experiencing issues getting this text to appear along with a Facebook Like/Send action, run your URL through this debugger, which will flush any old meta data Facebook may have from your website and force it to use the new data:  <a href="http://developers.facebook.com/tools/debug" target="_blank">developers.facebook.com/tools/debug</a>.',
					'subtype' => '',
					'std' => '',
					'premium' => ''
				),
			),
		),
		'Facebook' => array(
			array( // subsection
				array(
					'label' => 'Like Button',
					'type' => 'text',
					'option_name' => 'lefx_description_fbpagelike',
					'desc' => 'Connect this Like button to your official page ON Facebook.com (not to this page).  This URL will be something like, <strong>http://www.facebook.com/PAGENAME</strong>. This button appears in the bottom-right corner of the container.  To remove, simply leave this field completely blank.',
					'subtype' => '',
					'class' => '',
					'std' => '',
					'premium' => ''
				),
			),
			array( // subsection
				array( 
					'label' => 'Open Graph Image (og:image)',
					'type' => 'image',
					'option_name' => 'bkt_thumb',
					'option_disable' => 'bkt_thumbdisable',
					'desc' => '<strong>Minimum Size:</strong> 50 x 50 pixels<br /><br />Small image to automatically accompany Facebook Like/Send posts.  Square images work best.<br /><br />For single pages and posts, Launch Effect will try to scrape the article itself for images it can use.<br /><br /><strong>Troubleshooting</strong>: If you are experiencing issues getting this image or images within the article to appear along with a Facebook Like/Send action, run your URL through this debugger, which will flush any old meta data Facebook may have from your website and force it to use the new data:  <a href="http://developers.facebook.com/tools/debug" target="_blank">developers.facebook.com/tools/debug</a>.',
					'class' => 'le-threecol',
					'subtype' => '',
					'std' => '',
					'premium' => ''
				)
			),
			array( // subsection
				array(
					'label' => 'App ID (fb:app_id)',
					'type' => 'text',
					'option_name' => 'lefx_description_fbappid',
					'desc' => 'To use Facebook Insights, you should insert your own Facebook App ID here.',
					'subtype' => '',
					'class' => '',
					'std' => '',
					'premium' => ''
				),
				array(
					'label' => 'Admins (fb:admins)',
					'type' => 'text',
					'option_name' => 'lefx_description_fbadmins',
					'desc' => 'To use Facebook Insights, you should insert the user ID (or comma-separated user IDs) of your page admin(s) here.',
					'subtype' => '',
					'class' => '',
					'std' => '',
					'premium' => ''
				),
			),
		),
		'CSS and Scripts' => array(
			array( // subsection
				array(
					'label' => 'Additional Scripts (within HEAD tag)',
					'type' => 'textarea',
					'option_name' => 'lefx_addjshead',
					'class' => 'le-threecol',
					'desc' => 'Feel free to paste additional code here.  Use with caution.  The code will appear between your HEAD tags.  For code you\'d like to appear before the closing BODY tag, please see the additional code field in the Footer section of this page.  Please note, you must include your own SCRIPT tags here.',
					'subtype' => '',
					'std' => '',
					'premium' => ''
				)
			),
			array( // subsection
				array(
					'label' => 'Additional CSS',
					'type' => 'textarea',
					'option_name' => 'lefx_addcsshead',
					'class' => 'le-threecol',
					'desc' => 'Feel free to paste additional CSS code here.  Use with caution.  The code will appear between STYLE tags between your HEAD tags.',
					'subtype' => '',
					'std' => '',
					'premium' => ''
				)
			),
			array( // subsection
				array(
					'label' => 'Additional Scripts (before closing BODY tag)',
					'type' => 'textarea',
					'option_name' => 'lefx_addjsfooter',
					'class' => 'le-threecol',
					'desc' => 'Feel free to paste additional code here.  Use with caution.  The code will appear right before the closing BODY tag.  For code you\'d like to appear within your HEAD tag, please see the additional code field in the Head section of this page.  Please note, you must include your own SCRIPT tags here.',
					'subtype' => '',
					'std' => '',
					'premium' => ''
				)
			),
		),
		'Web Fonts' => array(
			array( // subsection
				array(
					'label' => 'Typekit ID',
					'type' => 'text',
					'option_name' => 'lefx_typekit',
					'class' => 'le-threecol',
					'desc' => 'Assign your Typekit fonts to the <a href="#selector-info" class="modal-trigger" id="modal-typekit-info">following selectors</a>.<br /><br />Typekit will override all Google Webfonts selections.',
					'subtype' => '',
					'std' => '',
					'premium' => ''
				)
			),
			array( // subsection
				array(
					'label' => 'Monotype ID',
					'type' => 'text',
					'option_name' => 'lefx_monotype',
					'class' => 'le-threecol',
					'desc' => 'Assign your Monotype fonts to the <a href="#selector-info" class="modal-trigger" id="modal-monotype-info">following selectors</a>.<br /><br />You can find your ID by going into your project and clicking on the "Publish" tab, then selecting the long code after ".../jsapi/" and before the ".js" within the script embed textarea.<br /><br />Monotype will override all Google Webfonts selections.',
					'subtype' => '',
					'std' => '',
					'premium' => ''
				)
			),
		),
		'Page Background' => array(
			array( // subsection
				array( 
					'label' => 'Background Color',
					'type' => 'color',
					'option_name' => 'page_background_color',
					'class' => 'le-color',
					'subtype' => '',
					'desc' => 'Be sure to set this color even if you have a background image.  Set this color to a similar color tone as your background image.',
					'std' => '#E5E5E5',
					'premium' => ''
				),
			),
			array( // subsection
				array( 
					'label' => 'Background Image',
					'type' => 'image',
					'option_name' => 'supersize',
					'option_disable' => 'supersize_disable',
					'desc' => '<strong>File Size:</strong> under 200KB!<br /><br />For best results, choose an image that is large but try to keep the image size under 200KB!',
					'class' => 'le-threecol',
					'subtype' => '',
					'std' => '',
					'premium' => ''
				)
			),
		),
		'Slideshow' => array(
			array( // subsection
				array( 
					'label' => 'Enable Slideshow',
					'type' => 'check',
					'option_name' => 'lefx_enable_slideshow',
					'desc' => 'This enables a slideshow of the super-sized backgrounds.',
					'class' => 'le-check',
					'subtype' => '',
					'std' => '',
					'premium' => 'section'
				),
				array( 
					'label' => 'Transition Speed',
					'type' => 'text',
					'option_name' => 'lefx_slide_fx_speed',
					'desc' => 'Speed of the transition effect in seconds. <strong>Default:</strong> 2.5',
					'class' => 'le-threecol',
					'subtype' => '',
					'std' => '2.5',
					'premium' => 'section'
				),
				array( 
					'label' => 'Slideshow Duration',
					'type' => 'text',
					'option_name' => 'lefx_slide_speed',
					'desc' => 'The duration of time each slide remains visible in seconds. <strong>Default:</strong> 5',
					'class' => 'le-threecol',
					'subtype' => '',
					'std' => '5',
					'premium' => 'section'
				),
			),
			array( //subsection
				array(
					'label' => 'Background Image (2)',
					'type' => 'image',
					'option_name' => 'lefx_bg_image2',
					'desc' => '<strong>File Size:</strong> under 200KB!<br /><br />For best results, choose an image that is large but try to keep the image size under 200KB!',
					'subtype' => '',
					'class' => 'le-threecol',
					'premium' => 'section',
					'std' => ''
				),
				array(
					'label' => 'Background Image (3)',
					'type' => 'image',
					'option_name' => 'lefx_bg_image3',
					'desc' => '<strong>File Size:</strong> under 200KB!<br /><br />For best results, choose an image that is large but try to keep the image size under 200KB!',
					'subtype' => '',
					'class' => 'le-threecol',
					'premium' => 'section',
					'std' => ''
				),
				array(
					'label' => 'Background Image (4)',
					'type' => 'image',
					'option_name' => 'lefx_bg_image4',
					'desc' => '<strong>File Size:</strong> under 200KB!<br /><br />For best results, choose an image that is large but try to keep the image size under 200KB!',
					'subtype' => '',
					'class' => 'le-threecol',
					'premium' => 'section',
					'std' => ''
				),	
				array(
					'label' => 'Background Image (5)',
					'type' => 'image',
					'option_name' => 'lefx_bg_image5',
					'desc' => '<strong>File Size:</strong> under 200KB!<br /><br />For best results, choose an image that is large but try to keep the image size under 200KB!',
					'subtype' => '',
					'class' => 'le-threecol',
					'premium' => 'section',
					'std' => ''
				),
			),
		),		
		'Favicon' => array(
			array( // subsection
				array( 
					'label' => 'Upload Favicon',
					'type' => 'image',
					'option_name' => 'bkt_favicon',
					'option_disable' => 'bkt_favdisable',
					'desc' => 'For best results, upload .ico files only.  You can use a site such as <a href="http://www.favicon.cc/" target="_blank">favicon.cc</a> to generate your 16 x 16 pixel .ico file from an image of your choice.',
					'class' => 'le-threecol le-favicon',
					'subtype' => '',
					'std' => '',
					'premium' => ''
				)
			),
		),
		'Social Icons' => array(
			array( // subsection
				array(
					'label' => 'Your Facebook Page URL',
					'type' => 'text',
					'option_name' => 'lefx_description_fbpage',
					'desc' => 'Link to your Facebook page. Be sure to include the <strong>http://</strong>. This icon appears in the bottom left corner of the container.  To remove, simply leave this field completely blank.',
					'subtype' => '',
					'class' => '',
					'std' => '',
					'premium' => ''
				)
			),
			array( // subsection
				array(
					'label' => 'Your Twitter Page URL',
					'type' => 'text',
					'option_name' => 'lefx_description_twitpage',
					'desc' => 'Link to your Twitter page. Be sure to include the <strong>http://</strong>. This icon appears in the bottom left corner of the container.  To remove, simply leave this field completely blank.',
					'subtype' => '',
					'class' => '',
					'std' => '',
					'premium' => ''
				)
            ),
            array( // subsection
				array(
					'label' => 'Your Instagram Page URL',
					'type' => 'text',
					'option_name' => 'lefx_description_instagrampage',
					'desc' => 'Link to your Instagram page. Be sure to include the <strong>http://</strong>. This icon appears in the bottom left corner of the container.  To remove, simply leave this field completely blank.',
					'subtype' => '',
					'class' => '',
					'std' => '',
					'premium' => ''
				)
			),
			array( // subsection
				array(
					'label' => 'Your LinkedIn Profile URL',
					'type' => 'text',
					'option_name' => 'lefx_description_linkedin',
					'desc' => 'Link to your LinkedIn profile. Be sure to include the <strong>http://</strong>. This icon appears in the bottom left corner of the container.  To remove, simply leave this field completely blank.',
					'subtype' => '',
					'class' => '',
					'std' => '',
					'premium' => ''
				)
			),
			array( // subsection
				array(
					'label' => 'Your Google+ Page URL',
					'type' => 'text',
					'option_name' => 'lefx_description_googleplus',
					'desc' => 'Link to your Google+ page. Be sure to include the <strong>http://</strong>. This icon appears in the bottom left corner of the container.  To remove, simply leave this field completely blank.',
					'subtype' => '',
					'class' => '',
					'std' => '',
					'premium' => ''
				)
			),
			array( // subsection
				array(
					'label' => 'Your YouTube Channel URL',
					'type' => 'text',
					'option_name' => 'lefx_description_youtube',
					'desc' => 'Link to your YouTube Channel. Be sure to include the <strong>http://</strong>. This icon appears in the bottom left corner of the container.  To remove, simply leave this field completely blank.',
					'subtype' => '',
					'class' => '',
					'std' => '',
					'premium' => ''
				)
			),
			array( // subsection
				array(
					'label' => 'Your Tumblr Page URL',
					'type' => 'text',
					'option_name' => 'lefx_description_tumblr',
					'desc' => 'Link to your Tumblr. Be sure to include the <strong>http://</strong>. This icon appears in the bottom left corner of the container.  To remove, simply leave this field completely blank.',
					'subtype' => '',
					'class' => '',
					'std' => '',
					'premium' => ''
				)
			),
			array( // subsection
				array(
					'label' => 'Your Pinterest Page URL',
					'type' => 'text',
					'option_name' => 'lefx_description_pinterest',
					'desc' => 'Link to your Pinterest page. Be sure to include the <strong>http://</strong>. This icon appears in the bottom left corner of the container.  To remove, simply leave this field completely blank.',
					'subtype' => '',
					'class' => '',
					'std' => '',
					'premium' => ''
				)
			),
			array( // subsection
				array(
					'label' => 'Your SoundCloud Page URL',
					'type' => 'text',
					'option_name' => 'lefx_description_soundcloud',
					'desc' => 'Link to your SoundCloud page. Be sure to include the <strong>http://</strong>. This icon appears in the bottom left corner of the container.  To remove, simply leave this field completely blank.',
					'subtype' => '',
					'class' => '',
					'std' => '',
					'premium' => ''
				)
			),
			array( // subsection
				array(
					'label' => 'Your Yelp Page URL',
					'type' => 'text',
					'option_name' => 'lefx_description_yelp',
					'desc' => 'Link to your Yelp page. Be sure to include the <strong>http://</strong>. This icon appears in the bottom left corner of the container.  To remove, simply leave this field completely blank.',
					'subtype' => '',
					'class' => '',
					'std' => '',
					'premium' => ''
				)
			),
			array( // subsection
				array(
					'label' => 'Miscellaneous Link URL',
					'type' => 'text',
					'option_name' => 'description_linkurl',
					'desc' => 'Link to your blog or a related website. Be sure to include the <strong>http://</strong>. This link appears in the bottom right corner of the container.  To remove, simply leave these two fields completely blank.',
					'subtype' => '',
					'class' => '',
					'std' => '',
					'premium' => ''
				),
				array(
					'label' => 'Miscellaneous Link Text',
					'type' => 'text',
					'option_name' => 'description_linktext',
					'desc' => '',
					'subtype' => '',
					'class' => '',
					'std' => '',
					'premium' => ''
				),
			),
		),
		'Site Credits' => array(
			array( // subsection
				array(
					'label' => 'Site Credits',
					'type' => 'tinymce',
					'option_name' => 'lefx_credits',
					'class' => 'le-threecol',
					'desc' => 'This text will appear in the small black tab at the lower right-hand corner of the site.  You can use it to credit a photographer, for example, or for something like copyright information.  You can use HTML to create a link.',
					'subtype' => '',
					'premium' => 'section',
					'std' => 'Copyright &copy; 2013'
				),
				array(
					'label' => 'Disable Site Credits',
					'type' => 'check',
					'option_name' => 'lefx_credits_disable',
					'class' => 'le-threecol',
					'desc' => '',
					'subtype' => '',
					'premium' => 'section',
					'std' => ''
				)
			),
		),
	),
));
