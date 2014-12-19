<?php
/**
 * Launch Module/Wrapper Footer
 *
 * Contains the social media icons and additional links
 * Also appears at the bottom of the wrapper on theme pages
 *
 * @package WordPress
 * @subpackage Launch_Effect
 *
 */
?>
	<!-- LINK TO BLOG/OTHER WEBSITES -->
	<ul id="inner-footer" class="clearfix">
		<?php if($description_linkurl = ler('description_linkurl')) : 
			?><li class="text-link"><p><a href="<?php echo esc_url($description_linkurl); ?>" target="_blank"><?php le('description_linktext'); ?></a></p></li><?php 
		endif; ?>
		<?php if($lefx_description_fbpage = ler('lefx_description_fbpage')) : 
			?><li class="inner-footer_icon facebook"><a href="<?php echo esc_url($lefx_description_fbpage); ?>" target="_blank">Facebook Page</a></li><?php 
		endif; ?>
		<?php if($lefx_description_twitpage = ler('lefx_description_twitpage')) : 
			?><li class="inner-footer_icon twitter"><a href="<?php echo esc_url($lefx_description_twitpage); ?>" target="_blank">Follow Me</a></li><?php 
		endif; ?>
		<?php if($lefx_description_instagrampage = ler('lefx_description_instagrampage')) : 
			?><li class="inner-footer_icon instagram"><a href="<?php echo esc_url($lefx_description_instagrampage); ?>" target="_blank">Follow Me</a></li><?php 
		endif; ?>
		<?php if($lefx_description_linkedin = ler('lefx_description_linkedin')) : 
			?><li class="inner-footer_icon linkedin"><a href="<?php echo esc_url($lefx_description_linkedin); ?>" target="_blank">LinkedIn Profile</a></li><?php 
		endif; ?>
		<?php if($lefx_description_googleplus = ler('lefx_description_googleplus')) : 
			?><li class="inner-footer_icon googleplus"><a href="<?php echo esc_url($lefx_description_googleplus); ?>" target="_blank">Google+ Profile</a></li><?php 
		endif; ?>
		<?php if($lefx_description_youtube = ler('lefx_description_youtube')) : 
			?><li class="inner-footer_icon youtube"><a href="<?php echo esc_url($lefx_description_youtube); ?>" target="_blank">YouTube Channel</a></li><?php 
		endif; ?>
		<?php if($lefx_description_tumblr = ler('lefx_description_tumblr')) : 
			?><li class="inner-footer_icon tumblr"><a href="<?php echo esc_url($lefx_description_tumblr); ?>" target="_blank">Tumblr</a></li><?php 
		endif; ?>
		<?php if($lefx_description_pinterest = ler('lefx_description_pinterest')) : 
			?><li class="inner-footer_icon pinterest"><a href="<?php echo esc_url($lefx_description_pinterest); ?>" target="_blank">Pinterest Page</a></li><?php 
		endif; ?>
		<?php if($lefx_description_soundcloud = ler('lefx_description_soundcloud')) : 
			?><li class="inner-footer_icon soundcloud"><a href="<?php echo esc_url($lefx_description_soundcloud); ?>" target="_blank">SoundCloud Page</a></li><?php 
		endif; ?>
		<?php if($lefx_description_yelp = ler('lefx_description_yelp')) : 
			?><li class="inner-footer_icon yelp"><a href="<?php echo esc_url($lefx_description_yelp); ?>" target="_blank">Yelp Page</a></li><?php 
		endif; ?>
		<?php if($lefx_description_fbpagelike = ler('lefx_description_fbpagelike')) : 
			?><li class="inner-footer_icon facebooklike"><div class="fb-like" data-href="<?php echo esc_url($lefx_description_fbpagelike); ?>" data-send="false" data-layout="button_count" data-width="100" data-show-faces="false" data-font="arial"></div></li><?php 
		endif; ?>
	</ul>
