<?php get_header(); ?>
	<?php $options = get_option(THEME_OPTIONS_NAME); ?>
	<?php $page    = get_page_by_title('Home'); ?>
	<?php global $pageID; ?>
	<?php $pageID  = $page->ID; ?>
	<div class="page-content" id="home" data-template="home-description">
		<div class="row">
			<div class="span12">
				<?php $description = $options['site_description']; ?>
				<?php if ($description): ?>
					<div id="tt-header-description">
						<p><?=$description?></p>
					</div>
				<?php endif; ?>
			</div>
		</div>
		<?php get_template_part('includes/below-the-home-header'); ?>
	</div>
<?php get_template_part('includes/above-the-footer'); ?>
<?php get_footer();?>
