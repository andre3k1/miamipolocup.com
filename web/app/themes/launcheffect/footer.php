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

	<!-- FOOTER -->
	<!--
	<ul id="footer">
		<li>Powered by <a href="http://www.launcheffectapp.com" class="logo" target="_blank">Launch Effect</a> for WordPress by <a href="http://www.barrelny.com" target="_blank">Barrel</a></li>
	</ul>
	-->

	<!-- Launch Effect Scripts -->
	<?php
	ob_start();
	wp_footer();
	$wp_footer = ob_get_contents();
	ob_end_clean();
	$wp_footer = explode("\n", $wp_footer);
	echo implode("\n\t", $wp_footer);
	?>

	<!-- Twitter Integration -->
	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

	<!-- Facebook Integration -->
	<div id="fb-root"></div>
	<script>window.fbAsyncInit = function() {FB.init({<?php if ($fb_app_id = ler('lefx_description_fbappid')) : ?>appId: "<?php echo $fb_app_id; ?>",<?php endif; ?>status: true,cookie: true,xfbml: true,channelUrl: '<?php echo get_template_directory_uri(); ?>/inc/facebookchannel.php'});};(function() {var e = document.createElement('script'); e.async = true;e.src = document.location.protocol +'//connect.facebook.net/en_US/all.js';document.getElementById('fb-root').appendChild(e);}());</script>

	<!-- Google Analytics -->
	<?php if($bkt_google = ler('bkt_google')) : ?>
	<script type="text/javascript"><?php echo $bkt_google; ?></script>
	<?php endif; ?>

</body>
</html>
