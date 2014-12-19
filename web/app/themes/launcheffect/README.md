Development Instructions
=======
1. Run `npm install` to download depedencies (`node_modules/`)
2. Use `grunt` to build theme

Launch Effect
=======
A viral marketing theme for WordPress empowering designers, marketers, and enthusiasts to build websites with relative ease.

You can view the current version information [here](https://github.com/barrel/Launch-Effect/blob/master/readme.txt)

## Deployment

#### Branches

- **Master**: contains the latest release.
- **Develop**: is where you test bug fixes.

#### ToDos
- add changes to [readme.txt](https://github.com/barrel/Launch-Effect/blob/master/readme.txt)
- change version number in [functions.php](https://github.com/barrel/Launch-Effect/blob/master/functions.php)

    ```
    define("LE_VERSION", "X.xx");
    ```

#### To create both the free and premium versions for upload:

```./deploy.sh X.xx```

Run the above in terminal, where ```X.xx``` is the version number *change this value each time*.



<br />

> "Make every detail perfect and limit the number of details to perfect."
>  - Jack Dorsey


<br />



## Compiled Files
The following is a list of compiled files and the files they include. This project uses [Grunt](http://gruntjs.com) to automate build tasks. See below for instructions on how to use it.

### Build Instructions
- Install [Node.js](http://nodejs.org)
- Install grunt-cli: `npm install -g grunt-cli`
- Install dev dependencies: `npm install`
- Run `grunt` to compile, or `grunt server` to start a live gruntment environment.

#### Global
These files apply to both versions, lite &amp; premium.

##### Stylesheets

- ```ss/launch-effect.min.css```
  	- [ss/main.css](https://github.com/barrel/Launch-Effect/blob/grunt/ss/main.css)
- ```ss/launch-effect-responsive.min.css```
  	- [ss/responsive.css](https://github.com/barrel/Launch-Effect/blob/grunt/ss/responsive.css)

##### JavaScript

- ```js/launch-effect.min.js```: this is now loaded in the ***footer***
  	- [js/jqModal.js](https://github.com/barrel/Launch-Effect/blob/grunt/js/jqModal.js)
  	- [js/spin.js](https://github.com/barrel/Launch-Effect/blob/grunt/js/spin.js)
  	- [js/jquery.imagesloaded.js](https://github.com/barrel/Launch-Effect/blob/grunt/js/jquery.imagesloaded.js)
  	- [js/init.js](https://github.com/barrel/Launch-Effect/blob/grunt/js/init.js)


#### Admin
These files are loading for the admin settings panel.

##### Stylesheets

- ```functions/ss/launch-effect-admin.min.css```
  	- [functions/ss/stats.css](https://github.com/barrel/Launch-Effect/blob/grunt/functions/ss/stats.css)
  	- [functions/ss/main.css](https://github.com/barrel/Launch-Effect/blob/grunt/functions/ss/main.css)
  	- [functions/js/jpicker/css/jPicker-1.1.6.css](https://github.com/barrel/Launch-Effect/blob/grunt/functions/js/jpicker/css/jPicker-1.1.6.css) (deprecated)
  	- [functions/js/jqueryui/css/overcast/jquery-ui-1.8.16.custom.css](https://github.com/barrel/Launch-Effect/blob/grunt/functions/js/jqueryui/css/overcast/jquery-ui-1.8.16.custom.css)

##### JavaScript

- ```functions/js/launch-effect-admin.min.js```
  	- [js/jqModal.js](https://github.com/barrel/Launch-Effect/blob/grunt/js/jqModal.js)
  	- [functions/js/jpicker/jpicker-1.1.6.js](https://github.com/barrel/Launch-Effect/blob/grunt/functions/js/jpicker/jpicker-1.1.6.js) (deprecated)
  	- [functions/js/jqueryui/js/jquery-ui-1.8.16.custom.min.js](https://github.com/barrel/Launch-Effect/blob/grunt/functions/js/jqueryui/js/jquery-ui-1.8.16.custom.min.js) (deprecated)
  	- [functions/js/jquery.scrollTo-min.js](https://github.com/barrel/Launch-Effect/blob/grunt/functions/js/jquery.scrollTo-min.js)
 	- [functions/js/init.js](https://github.com/barrel/Launch-Effect/blob/grunt/functions/js/init.js)


#### Premium
These files are loading for the premium version.

##### Stylesheets

- ```premium/ss/launch-effect-premium.min.css```
  	- [premium/ss/main.css](https://github.com/barrel/Launch-Effect/blob/grunt/premium/ss/main.css)
  	- [premium/js/fancybox/jquery.fancybox-1.3.4.css](https://github.com/barrel/Launch-Effect/blob/grunt/premium/js/fancybox/jquery.fancybox-1.3.4.css)


##### JavaScript

- ```premium/js/launch-effect-premium.min.js```: this is now loaded in the ***footer***
  	- [premium/js/jquery.countdown.js](https://github.com/barrel/Launch-Effect/blob/grunt/premium/js/jquery.countdown.js)
  	- [premium/js/fancybox/jquery.fancybox-1.3.4.js](https://github.com/barrel/Launch-Effect/blob/grunt/premium/js/fancybox/jquery.fancybox-1.3.4.js)
  	- [premium/js/init.js](https://github.com/barrel/Launch-Effect/blob/grunt/premium/js/init.js)

#### Other
The slideshow background js is now compiled with [js/init.js](https://github.com/barrel/Launch-Effect/blob/grunt/js/init.js) into ```js/launch-effect.min.js```. The variables for the speed and duration are passed as javascript variables before ```wp_footer();``` is called. 


=== Launch Effect Theme ===
Contributors: (this should be a list of wordpress.org userid's)
Donate link: http://barrelny.com/
Tags: one-column, two-columns, left-sidebar, fixed-width, flexible-width, custom-background, custom-colors, custom-header, featured-images, theme-options, viral, marketing, referral, email, sign-up, email-sign-up, placeholder, mailchimp, aweber, typekit, google-web-fonts, monotype, campaign monitor
Requires at least: 3.0.1
Tested up to: 3.8.1
Stable tag: 2.41
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Launch Effect Premium is a viral marketing theme for WordPress empowering designers, marketers, and enthusiasts to build websites with relative ease.

== Description ==

Launch Effect Premium is a viral marketing theme for WordPress that empowers web designers, marketers, and WordPress enthusiasts to build beautiful, fully-featured websites without touching a single line of code.  A built-in referral link generator integrated with MailChimp, Aweber, and Campaign Monitor allows visitors to your website to sign up with their emails and use the unique link generated by the theme to spread the word about your site.  It's up to you to think of brilliant ways to incentivize your visitors to share their link!  Its robust theme options panel gives you the ability to customize almost every aspect of the design and comes fully-loaded with Google web font, Typekit and Monotype web font integration.  Enjoy!

== Installation ==

After normal theme installation, follow the below steps to get LaunchEffect up and running.

1. Set Homepage: Go to Settings > Reading.
By default, WordPress shows your most recent Posts (the blog) on the homepage of your site (like the one you’re reading right now). But many WordPress users want to be able to choose a different Page as their homepage.

If you’d like to keep your most recent Posts as your homepage, you don’t have to adjust anything in this step.

If not, where it says, “Front page displays,” choose “A static page,” and select accordingly for your “Front Page”. Be sure to select “Blog” for “Posts Page”. If you’d like the Launch Effect sign-up page to be your homepage, choose “Sign-Up” for “Front Page”. Go to the Pages item in the WordPress sidebar to create new pages, which you can also select to be your “Front Page”.

2. Create Nav Menu: Go to Appearance > Menus.

This is where your navigation menu is set up and controlled. In the large panel on the right, next to “Menu Name,” write a name for your menu (it can be anything) and press save. The page will refresh and you will see a new panel called “Theme Locations at the top left. Use the Launch Effect Navigation drop down menu to select the name of the menu you just created. Then press save. Now you can use the options at left to choose what pages and posts you’d like to appear in your nav menu.

3. Select Widgets: Go to Appearance > Widgets.

Launch Effect is compatible with the standard WordPress widgets, as you can see from the ones that appear by default on the left-hand side of your website. Here you can select which widgets to keep and which to remove, as well as customize content specific to each widget.

4. Start Designing: Go to Launch Effect > Designer.

Now for the fun part! The Designer is now divided into three sections: Global Styles, Sign-Up Page, and Theme. That submenu is located directly under the giant Designer/Integrations/Stats tabs. The best way to get started here is to just start playing around and gaining an understanding of what selections affect which parts of the design. Good luck!

== Screenshots ==

1. LaunchEffect primary logo asset.

== Changelog ==

= 2.41 =
* [Fix] Resolve issue where certain settings behave like premium features
* [Improvement] Separate Slideshow options from Page Background settings

= 2.4 =
* [New] Added option to enable admin email notifications on signup
* [New] Added quantity field for Product options
* [New] Added WYSIWYG text editor for Body text and Auto-Response Email 
* [New] Added social sharing buttons to single blog posts (premium)
* [New] Added previous and next links in blog posts (premium)
* [New] Added upgrade routine for storing images in database
* [New] Added tinymce as option type for textarea where html is welcome
* [New] Moved stats extended details (custom fields) to single stat view
* [Improvement] Add styles for tinymce body tags in before/after signup text
* [Improvement] Updated color picker
* [Improvement] Convert all media uploads to WP media library uploader
* [Improvement] Added Image uploaded preview
* [Improvement] Add active state for (admin) submenu items
* [Improvement] Add LE Settings link to admin toolbar
* [Improvement] Simplified Stats page
* [Improvement] Cleaned up Stats CSV export 
* [Improvement] Cleaned up template files code
* [Improvement] Optimized dynamic css generation
* [Improvement] Reduced database calls with option variables
* [Improvement] Add recursive check to referral code output
* [Improvement] Remove excessive whitespace
* [Improvement] Add checks to ensure js scripts only run on left pages
* [Improvement] Convert include to get_template_part for template consistency
* [Improvement] Move dynamic css and ajax functions to proper wp ajax hooks
* [Improvement] Compress dynamic css
* [Fix] Update aweber and compaign monitor APIs to prevent collisions with newer JSON library
* [Fix] Remove fatal WP error after install
* [Fix] Display Photo Gallery captions
* [Fix] Modify comment reply scripts to add front-end validation and prevent empty submissions
* [Fix] Modify number of columns in Gallery
* [Fix] Modify responsive menu to hide after moving from smaller viewports to a larger one if previously expanded
* [Fix] Prevent false from being passed as a field in campaign monitor

= 2.3 =
* [New] added option for simple captcha field
* [Fix] Google Web Fonts not loading

= 2.29 =
* [Fix] typekit and monotype functionality
* [Fix] added instagram to social media
* [Fix] firefox conversion tracking
* [Fix] color pickers on admin
* [Fix] form submitting but button keeps spinning
* [Fix] when no progress indicator error
* [Fix] Aweber add subscriber when form submit

= 2.28 =
* [New Feature!] PayPal Buy Now integration with shortcodes
* [Improvement] Remove Facebook "send" button
* [Improvement] Javascript jquery code cleanup
* [Improvement] Map the jquery object internally
* [Fix] add mime-type for ico files to enable upload
* [Fix] bad date() call in theme options
* [Fix] hover and style for collapse button

= 2.27 =
* [Improvement] Make mobile footer position static
* [Improvement] Initialize modals on designer options page
* [Improvement] Convert static php function to proper wp ajax function
* [Improvement] Heavily revise options panel code, fixing display of typekit selectors
* [Improvement] Add wp_localize data to expose javascript variables
* [Fix] Fix display of previous user tip notice hover
* [Fix] Change form action to relative theme url 
* [Fix] Facebook FXBML like API update

= 2.26 =
* [Fix] Background sizing issues in IE8/IE9

= 2.25 =
* [New Feature!] Add shortcode option for auto-responder
* [Improvement] Modify certain option descriptions
* [Fix] Fix AWeber API error
* [Fix] Update jquery.countdown script

= 2.24 =
* [New Feature!] Add background slideshow (Premium); 
* [New Feature!] Add auto-response option data and logic
* [New Feature!] Add yelp as a social icon
* [Improvement] Update default copyright text
* [Improvement] Add dynamic css for unordered lists
* [Fix] Fix zIndex of LE lite module
* [Fix] Modify footer of responsive css for small devices (fixes cut-off social icons)
* [Fix] Lock jQuery to version 1.8.3 for maximum compatibility with third-party plugins.

= 2.23 =
* [New Feature!] Add global option to override theme thumbnail sizing
* [New Feature!] Add per_page option to stats page
* [New Feature!] Add method to remove stats data
* [Changes] Remove PressTrends
* [Fix] Stats per page variable if not set
* [Fix] Fix manual gallery ordering
* [Fix] Fix scrollTo animation in backend side menu (chrome bug)
* [Fix] Fix z-index of floating nav in admin options
* [Fix] Modify media query to 768px device widths
* [Fix] Only load admin styles and scripts on Launch Effect backend pages.
* [Fix] General copy edits and 404s in backend
* [Fix] Tentative fix for custom fields breaking
* [Improvement] jPicker usability enhancements
* [Improvement] Add popup method for tumblr button
* [Improvement] Stats page pagination modified to resemble WP tabular data pagination
* [Improvement] Modify save button behavior for tablet 
* [Improvement] Default to open all gallery links to direct file resource
* [Improvement] Modify logic to handle numerous gallery usage cases
* [Improvement] Add/update default thumbnail sizes on theme initialization
* [Improvement] Add settings error/update notice
* [Improvement] Add error checking for uploaded background image
* [Improvement] Add a border radius to iexploder message to match other settings notices
* [Improvement] Add fallback css for indicator shadowing if dynamic generation fails
* [Improvement] Add return to any link handlers to prevent page jumping
* [Improvement] General style updates
* [Improvement] Added mini icon for launch effect setting pages

= 2.22 =
* [Fix] WordPress 3.5 new WPDB requirements breaking signup form and stats.

= 2.21 =
* [New Feature!] Ability to include and custom position Page editor content within the Sign-Up page
* [New Feature!] Added Custom CSS field
* [New Feature!] Added Facebook App ID and Facebook Admins fields for open graph tags for those who wish to use Facebook Insights
* [New Feature!] Added Tumblr icon link
* [Improvement] Refactored CSS, made fixes and improvements and added some deluxe elements
* [Improvement] Dynamic CSS is now cacheable for hopeful speed improvements!  Added code for caching/cache-busting dynamic stylesheets via setting new version number as query string every time admin options panels are accessed
* [Improvement] Enqueue only the necessary JS for Premium vs. Lite versions
* [Improvement] Enqueuing all CSS and JS (except for responsive CSS) in functions.php
* [Improvement] Automatically strip carriage returns and line breaks from Meta Descriptions
* [Improvement] Removed dependency on Supersized JS plugin in favor of a CSS3 solution
* [Improvement] Removed dependeny on ScrollTo JS plugin
* [Improvement] Renaming and total reorganization of theme files and functions
* [Improvement] Moved the Learn More tab options from Theme to Sign-Up Page admin panel
* [Improvement] Updated descriptions for MailChimp setup, Meta Descripton, Page Background Color, Container Background Color
* [Improvement] Removed outdated instructional modals
* [Improvement] Moved privacy policy container to footer because of z-index issues
* [Fix] Send unique code data directly to MailChimp upon sign up (bringing its functionality in line with the other integrations)
* [Fix] Added conditional so Facebook Open Graph meta info controlled by Launch Effect options would only be used on the Sign-Up page (now Pages/Posts can pull content from their own specific data into the Open Graph tags)
* [Fix] Took Sign-Up page spinner off window.load and tied it to imagesLoaded within the container (was prone to hanging before if people had huge background images)
* [Fix] Fading in Sign-Up tab on theme pages
* [Fix] Improved logic upon which mobile stylesheets are called
* [Fix] Fixed an issue with Sign-Up slidedown/menu responsive logic
* [Fix] Loading Facebook code asynchronously
* [Fix] Added Facebook channel file for faster IE loading
* [Fix] Added Facebook language attributes to HTML tag
* [Fix] Added conditional HTML tag classes for IE versions
* [Fix] Fixed issue with footer credit text breaking to two lines on mobile devices
* [Fix] Removed text-transform:lowercase on Sign-Up tab link
* [Fix] Fixed undefined variable $op['std'] in admin causing PHP notice
* [Fix] Fixed undefined $can_chimp_sync variable in admin causing PHP notice
* [Fix] Fixed undefined $can_aweber_sync variable in admin causing PHP notice
* [Fix] Fixed zero-indexed logic in functions/theme-functions.php causing PHP notice
* [Fix] Fixed PressTrends WP_DEBUG $plugin_name undefined variable notice as well as get_theme_data deprecated function notice
* [Fix] Removed forcing Header: 200OK in header.php because we are using query strings now for the referral code
