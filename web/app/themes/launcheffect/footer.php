<?php
/**
 * Footer
 *
 * Contains the site credit and jQuery Supersized code.
 *
 * @package WordPress
 * @subpackage Launch_Effect
 *
 */
?>

	<!-- PRIVACY POLICY MODAL -->
	<div id="privacy-policy" class="jqmWindow">
		<a href="#" class="close">&times;</a>
		<h2><?php le('lefx_privacy_policy_heading'); ?></h2>
		<p><?php le('lefx_privacy_policy'); ?></p>
	</div>
	<!-- FOOTER BRANDING (Premium/Free) -->
	<?php if(lefx_version() == 'premium') : get_template_part('premium/brand'); else : ?>

	<ul id="footer">
		<li>Powered by <a href="http://www.launcheffectapp.com" class="logo" target="_blank">Launch Effect</a> for WordPress by <a href="http://www.barrelny.com" target="_blank">Barrel</a></li>
	</ul>
	<?php endif; ?>

	<!-- Slideshow Script -->
	<script type="text/javascript"><?php 
	$slide = false;
	$slide_speed = $slide_duration = 0;
	if (get_option('lefx_bg_image2')&&get_option('lefx_enable_slideshow')){
		$speed = get_option('lefx_slide_fx_speed');
		$duration = get_option('lefx_slide_speed');
		$slide = true;
		$slide_speed = (!empty($speed)&&is_numeric($speed)?$speed:2.5);
		$slide_duration = (!empty($duration)&&is_numeric($duration)?$duration:5);
	} ?>

	var slideshow = <?php echo $slide?'true':'false'; ?>; 
	var slideshow_speed = <?php echo $slide_speed; ?>; 
	var slideshow_duration = <?php echo $slide_duration; ?>;
	</script>

	<!-- Launch Effect Scripts -->
	<?php 
	ob_start(); 
	wp_footer(); 
	$wp_footer = ob_get_contents();
	ob_end_clean();
	$wp_footer = explode("\n", $wp_footer);
	echo implode("\n\t", $wp_footer);
	?>

	<?php if($lefx_addjsfooter = ler('lefx_addjsfooter')) : ?>

	<!-- Additional User-Defined JavaScript -->
	<?php echo $lefx_addjsfooter; endif; ?>

	<!-- LinkedIn Integration -->
	<script src="http://platform.linkedin.com/in.js" type="text/javascript"></script>

	<!-- Twitter Integration -->
	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
	<!-- Facebook Integration -->
	<div id="fb-root"></div>
	<script>window.fbAsyncInit = function() {FB.init({<?php if ($fb_app_id = ler('lefx_description_fbappid')) : ?>appId: "<?php echo $fb_app_id; ?>",<?php endif; ?>status: true,cookie: true,xfbml: true,channelUrl: '<?php echo get_template_directory_uri(); ?>/inc/facebookchannel.php'});};(function() {var e = document.createElement('script'); e.async = true;e.src = document.location.protocol +'//connect.facebook.net/en_US/all.js';document.getElementById('fb-root').appendChild(e);}());</script>

	<!-- Google PlusOne Button -->
	<script type="text/javascript" src="https://apis.google.com/js/plusone.js">{"parsetags": "explicit"}</script>

	<?php if($bkt_google = ler('bkt_google')) : ?>

	<!-- Google Analytics -->
	<script type="text/javascript"><?php echo $bkt_google; ?></script>
	<?php endif; ?>

</body>
</html>
