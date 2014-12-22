<?php
/**
 * Brandable Footer (Premium)
 *
 * @package WordPress
 * @subpackage Launch_Effect
 *
 */

?>
	<?php if(get_option('lefx_credits_disable') !== 'true') : ?>

	<ul id="footer">
		<?php if($lefx_credits = ler('lefx_credits')) : ?><li><?php echo $lefx_credits; ?></li><?php else : ?>

		<li>Powered by <a href="http://www.launcheffectapp.com" class="logo" target="_blank">Launch Effect</a> for WordPress by <a href="http://www.barrelny.com" target="_blank">Barrel</a></li><?php endif; ?>

	</ul>
<?php endif; ?>
