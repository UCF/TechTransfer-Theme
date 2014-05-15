<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<?="\n".header_()."\n"?>
		<?php if(GA_ACCOUNT or CB_UID):?>

		<script type="text/javascript">
			var _sf_startpt = (new Date()).getTime();
			<?php if(GA_ACCOUNT):?>

			var GA_ACCOUNT  = '<?=GA_ACCOUNT?>';
			var _gaq        = _gaq || [];
			_gaq.push(['_setAccount', GA_ACCOUNT]);
			_gaq.push(['_setDomainName', 'none']);
			_gaq.push(['_setAllowLinker', true]);
			_gaq.push(['_trackPageview']);
			<?php endif;?>
			<?php if(CB_UID):?>

			var CB_UID      = '<?=CB_UID?>';
			var CB_DOMAIN   = '<?=CB_DOMAIN?>';
			<?php endif?>

		</script>
		<?php endif;?>

		<!--[if IE]>
		<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

		<?  $post_type = get_post_type($post->ID);
			if(($stylesheet_id = get_post_meta($post->ID, $post_type.'_stylesheet', True)) !== False
				&& ($stylesheet_url = wp_get_attachment_url($stylesheet_id)) !== False) { ?>
				<link rel='stylesheet' href="<?=$stylesheet_url?>" type='text/css' media='all' />
		<? } ?>

		<script type="text/javascript">
			var PostTypeSearchDataManager = {
				'searches' : [],
				'register' : function(search) {
					this.searches.push(search);
				}
			}
			var PostTypeSearchData = function(column_count, column_width, data) {
				this.column_count = column_count;
				this.column_width = column_width;
				this.data         = data;
			}
		</script>

		<script type="text/javascript" src="<?=THEME_JS_URL?>/techtransfer.js"></script>

	</head>
	<body class="<?=body_classes()?>">
		<div class="container">
			<div class="row">
				<div id="header">
						<h1 class="span6"><a href="<?=bloginfo('url')?>"><?=bloginfo('name')?></a></h1>
						<div id="tt-header-links-right" class="span6 tt-header-links">
							<?php $options = get_option(THEME_OPTIONS_NAME);?>
							<? if($options['facebook_url']): ?>
								<a id="tt-facebook" href="<?=$options['facebook_url']; ?>"></a>
							<? endif; ?>
							<?php if($options['twitter_url']):?>
								<a id="tt-twitter" href="<?=$options['twitter_url']?>"></a>
							<?php endif;?>
						</div>
				</div>
			</div>
			<div class="row">
				<div class="span6 tt-header-links" id="tt-header-links-left">
							<?php
								$forResearchers = get_page_by_path('for-researchers');
								$forIndustry = get_page_by_path('for-industry');
								$techLocator = get_page_by_path('technology-locator');
							?>
							<a href="<?=get_page_link($forResearchers->ID); ?>">RESEARCHERS</a>
							<a href="<?=get_page_link($forIndustry->ID); ?>">INDUSTRY</a>
							<a href="<?=get_page_link($techLocator->ID); ?>">TECHNOLOGY</a>
				</div>
				<div class="span6" id="header-search">
							<?php get_search_form(); ?>
				</div>
			</div>
