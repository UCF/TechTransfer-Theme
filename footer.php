			<?php get_template_part('includes/above-the-footer'); ?>
			<div id="footer">
				
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
				<div class="row" id="footer-widget-wrap">
					<div class="footer-widget-1 span8">
						<?php if(!function_exists('dynamic_sidebar') or !dynamic_sidebar('Footer - Column One')):?>
							<span id="tt-footer-links">
								<?php $about = get_page_by_path('about-ott'); ?>
								<a href="<?=get_page_link($about->ID); ?>"><?=strtoupper($about->post_title); ?></a>
								<?php $forResearchers = get_page_by_path('for-researchers'); ?>
								<a href="<?=get_page_link($forResearchers->ID); ?>"><?=strtoupper(get_post_meta($forResearchers->ID, 'short', true)); ?></a>
								<?php $forIndustry = get_page_by_path('for-industry'); ?>
								<a href="<?=get_page_link($forIndustry->ID); ?>"><?=strtoupper(get_post_meta($forIndustry->ID, 'short', true)); ?></a>
								<?php $contactUs = get_page_by_path('contact-us'); ?>
								<a href="<?=get_page_link($contactUs->ID); ?>"><?=strtoupper($contactUs->post_title); ?></a>
							</span>
						<?php endif; ?>
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
	<!--[if IE]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<?="\n".footer_()."\n"?>
</html>