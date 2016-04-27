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

				if ( $description ):
				?>
					<div class="tt-header-description">
						<!-- Start row/span7 -->
						<?php if ( $description_heading && $show_search ): ?>
						<div class="row"><div class="span7">
						<?php endif; ?>

						<?php if ( $description_heading ): ?>
						<h2 class="tt-header-description-heading"><?php echo $description_heading; ?></h2>
						<?php endif; ?>

						<!-- Start span5 -->
						<?php if ( $description_heading && $show_search ): ?>
						</div><div class="span5">
						<?php endif; ?>

						<?php if ( $show_search ): ?>
						<form class="tt-header-search-form" action="<?php echo $tech_locator_url; ?>">
							<div class="input-append">
								<label for="tt-header-search" class="sr-only">Search available technologies</label>
								<input type="text" id="tt-header-search" class="tt-header-search-field" name="query" placeholder="Search available technologies">
								<button class="btn tt-header-search-btn">
									<span class="icon-search"></span> Search
								</button>
							</div>
						</form>
						<?php endif; ?>

						<!-- Close inner row/span -->
						<?php if ( $description_heading && $show_search ): ?>
						</div></div>
						<?php endif; ?>

						<p><?php echo $description; ?></p>
					</div>
				<?php endif; ?>
			</div>
		</div>
		<?php get_template_part('includes/below-the-home-header'); ?>
	</div>
<?php get_template_part('includes/above-the-footer'); ?>
<?php get_template_part('includes/featured-tech'); ?>
<?php get_footer();?>
