<?php get_header(); ?>
	<?php $options = get_option(THEME_OPTIONS_NAME); ?>
	<?php $page    = get_page_by_title('Home'); ?>
	<?php global $pageID; ?>
	<?php $pageID  = $page->ID; ?>
	<div class="page-content" id="home" data-template="home-description">
		<div class="row">
			<div class="span7">
				<?php $description = $options['site_description']; ?>
				<?php if ($description): ?>
					<div id="tt-header-description">
						<p><?=$description?></p>
					</div>
				<?php endif; ?>
			</div>
			<div id="for-researchers-button" class="span2">
				<?php $forResearchers = get_page_by_path('for-researchers'); ?>
				<a href="<?=get_page_link($forResearchers->ID); ?>"><img src="<?=THEME_IMG_URL?>/home-for-researchers.png"></a>
			</div>
			<div id="for-industry-button" class="span2">
				<?php $forIndustry = get_page_by_path('for-industry'); ?>
				<a href="<?=get_page_link($forIndustry->ID); ?>"><img src="<?=THEME_IMG_URL?>/home-for-industry.png"></a>
			</div>
			<div class="span1"></div>
		</div>
		<?php get_template_part('includes/below-the-home-header'); ?>
	</div>
<?php get_template_part('includes/above-the-footer'); ?>
<?php get_template_part('includes/featured-tech'); ?>
<?php get_footer();?>