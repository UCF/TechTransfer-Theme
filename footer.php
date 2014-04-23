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

						<?php $options = get_option(THEME_OPTIONS_NAME);?>
						<? if($options['facebook_url']): ?>
							<a id="tt-facebook" href="<?=$options['facebook_url']; ?>"></a>
						<? endif; ?>
						<?php if($options['twitter_url']):?>
							<a id="tt-twitter" href="<?=$options['twitter_url']?>"></a>
						<?php endif;?>
					</div>
					<div class="footer-widget-2 span4">
						<?php if(!function_exists('dynamic_sidebar') or !dynamic_sidebar('Footer - Column Two')):?>
							<?php $options = get_option(THEME_OPTIONS_NAME);?>
							<div id="tt-footer-maintained" class="maintained">
								<?php if($options['organization_name']): ?>
									<?= $options['organization_name']; ?>
								<?php endif;?>

								<?php if ($options['organization_name'] and $options['street_address'] and $options['city_address'] and $options['state_address'] and $options['zip_address']): ?>
									| <?=$options['street_address'];?> | <?=$options['city_address'];?>, <?=$options['state_address'];?> <?=$options['zip_address'];?>
								<?php elseif($options['street_address'] and $options['city_address'] and $options['state_address'] and $options['zip_address']): ?>
									<?=$options['street_address'];?> | <?=$options['city_address'];?>, <?=$options['state_address'];?> <?=$options['zip_address'];?>
								<?php endif;?>

								<?php if($options['phone_number'] and $options['fax_number']): ?>
									<br />Phone: <?=$options['phone_number'];?> | Fax: <?=$options['fax_number'];?>
								<?php elseif($options['phone_number'] and !$options['fax_number']): ?>
									<br />Phone: <?=$options['phone_number'];?>
								<?php elseif(!$options['phone_number'] and $options['fax_number']): ?>
									<br />Fax: <?=$options['fax_number'];?>
								<?php endif; ?>
							</div>
						<?php endif;?>
					</div>
				</div>
			</div>
		</div><!-- #blueprint-container -->
	</body>
	<?="\n".footer_()."\n"?>
</html>
