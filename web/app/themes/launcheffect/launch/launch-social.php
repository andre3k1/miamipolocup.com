
								<?php if($label_social = ler('label_social')) : ?><h2 class="social-heading"><?php echo $label_social; ?></h2><?php endif; ?>
								
								<div class="social-container clearfix">
									<div class="social">
										<?php if(get_option('lefx_disable_twitter') != 'true') : ?><div class="social-block" data-id="tweetblock"></div><?php endif; ?>
										<?php if(get_option('lefx_disable_facebook') != 'true') : ?><div class="social-block" data-id="fblikeblock"></div><?php endif; ?>
										<?php if(get_option('lefx_disable_plusone') != 'true') : ?><div class="social-block" data-id="plusoneblock"></div><?php endif; ?>
										<?php if(get_option('lefx_disable_tumblr') != 'true') : ?><div class="social-block" data-id="tumblrblock"></div><?php endif; ?>
										<?php if(get_option('lefx_disable_linkedin') != 'true') : ?><div class="social-block" data-id="linkinblock"></div><?php endif; ?>
									</div>
								</div>
