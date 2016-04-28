<?php get_header(); ?>
	<?php $options = get_option(THEME_OPTIONS_NAME); ?>
	<?php $page    = get_page_by_title('Home'); ?>
	<?php global $pageID; ?>
	<?php $pageID  = $page->ID; ?>
	<div class="page-content" id="home" data-template="home-description">
		<div class="row">
			<div class="span12">
				<?php
				$description_heading = wptexturize( $options['site_description_heading'] );
				$description = nl2br( wptexturize( $options['site_description'] ) );
				$show_search = filter_var( $options['site_description_tech_search'], FILTER_VALIDATE_BOOLEAN );
				$tech_locator_url = $options['technology_search_url'];
				?>
				<div class="tt-header-description">
					<?php if ( $description_heading ): ?>
					<h2 class="tt-header-description-heading"><?php echo $description_heading; ?></h2>
					<?php endif; ?>

					<?php if ( $show_search ): ?>
					<form class="tt-header-search-form" action="<?php echo $tech_locator_url; ?>">
						<div class="tt-header-search-outer">
							<label for="tt-header-search" class="sr-only">Search available technologies</label>
							<input type="text" id="tt-header-search" class="tt-header-search-field" name="query" placeholder="Search available technologies">
							<button class="tt-header-search-btn btn-link">
								<span class="sr-only">Search</span>
							</button>
						</div>
					</form>
					<?php endif; ?>

					<p><?php echo $description; ?></p>
				</div>
			</div>
		</div>
		<?php get_template_part('includes/below-the-home-header'); ?>
	</div>
<?php get_template_part('includes/above-the-footer'); ?>
<?php get_footer();?>
