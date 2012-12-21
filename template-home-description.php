<?php get_header(); ?>
	<?php $options = get_option(THEME_OPTIONS_NAME);?>
	<?php $page    = get_page_by_title('Home');?>
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
			<div class="span2">
				<?php $forResearchers = get_page_by_path('for-researchers'); ?>
				<a href="<?=get_page_link($forResearchers->ID); ?>"><img src="<?=THEME_IMG_URL?>/home-for-researchers.png"></a>
			</div>
			<div class="span2">
				<?php $forIndustry = get_page_by_path('for-industry'); ?>
				<a href="<?=get_page_link($forIndustry->ID); ?>"><img src="<?=THEME_IMG_URL?>/home-for-industry.png"></a>
			</div>
			<div class="span1"></div>
		</div>
		<?php get_template_part('includes/below-the-home-header'); ?>
		<!-- <div class="row">
			<div class="bottom span12">
				<?php $content = str_replace(']]>', ']]&gt;', apply_filters('the_content', $page->post_content));?>
				<?php if($content):?>
				<?=$content?>
				<?php endif;?>
			</div>
		</div> -->
	</div>
<?php get_template_part('includes/above-the-footer'); ?>
<?php get_footer();?>