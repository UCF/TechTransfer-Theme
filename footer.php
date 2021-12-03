			<div id="footer">


				<div class="row" id="footer-widget-wrap">
					<div class="footer-widget-1 span8">
						<?=wp_nav_menu(array(
							'theme_location' => 'footer-menu',
							'container' => 'false',
							'menu_class' => 'menu horizontal',
							'menu_id' => 'footer-menu',
							'fallback_cb' => false,
							'depth' => 1,
							'walker' => new Bootstrap_Walker_Nav_Menu()
							));
						?>
						<?php get_search_form(); ?>
					</div>
					<div class="footer-widget-2 span4">
						<?php if(!function_exists('dynamic_sidebar') or !dynamic_sidebar('Footer - Column Two')):?>
							<?php $options = get_option(THEME_OPTIONS_NAME);?>
							<div id="tt-footer-maintained" class="maintained">
								<?php if(isset($options['organization_name'])): ?>
									<?= $options['organization_name']; ?>
								<?php endif;?>

								<?php if (isset($options['organization_name']) and isset($options['street_address']) and isset($options['city_address']) and isset($options['state_address']) and isset($options['zip_address'])): ?>
									| <?=$options['street_address'];?> | <?=$options['city_address'];?>, <?=$options['state_address'];?> <?=$options['zip_address'];?>
								<?php elseif(isset($options['street_address']) and isset($options['city_address']) and isset($options['state_address']) and isset($options['zip_address'])): ?>
									<?=$options['street_address'];?> | <?=$options['city_address'];?>, <?=$options['state_address'];?> <?=$options['zip_address'];?>
								<?php endif;?>

								<?php if(isset($options['phone_number']) and isset($options['fax_number'])): ?>
									<br />Phone: <?=$options['phone_number'];?> | Fax: <?=$options['fax_number'];?>
								<?php elseif(isset($options['phone_number']) and !isset($options['fax_number'])): ?>
									<br />Phone: <?=$options['phone_number'];?>
								<?php elseif(!isset($options['phone_number']) and isset($options['fax_number'])): ?>
									<br />Fax: <?=$options['fax_number'];?>
								<?php endif; ?>
							</div>
						<?php endif;?>
					</div>
				</div>
			</div>
		</div><!-- #blueprint-container -->
	</body>

	<!-- START Social Links -->
	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
	<!-- Place this tag after the last share tag. -->
	<script type="text/javascript">
	  (function() {
	    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
	    po.src = 'https://apis.google.com/js/platform.js';
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
	  })();
	</script>
	<!-- END Social Links -->

	<?="\n".footer_()."\n"?>
</html>
