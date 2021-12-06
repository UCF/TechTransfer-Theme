<?php global $pageID; ?>
<?php if (strlen($pageID) == 0): ?>
<?php $pageID = get_the_ID(); ?>
<?php endif; ?>
<?php $resource_meta = get_post_meta( $pageID, 'page_resource', true); ?>

<?php $footerResources = get_posts( array( 'post_type' => 'footerresource', 'tax_query' => array( array( 'taxonomy' => 'resource_groups', 'field' => 'slug', 'terms' => $resource_meta ) ), 'order_by' => 'menu_order', 'order' => 'ASC', 'posts_per_page' => -1) ); ?>

<?php $numPosts = count($footerResources); ?>

<?php $numPages = ceil($numPosts / 4); ?>
<?php $row_size = 4; ?>
<?php if($numPages != 0) : ?>
		<div class="row">
			<div id="below-the-content" class="row-border-bottom-top">
			</div>
		</div>
		<div class="row">
			<h3 id="resource-header" class="span12">Learn How Tech Transfer Can Help You:</h3>
		</div>
		<?php $counter = 0; ?>
		<?php foreach($footerResources as $resource) : ?>

			<?php
			if( ($counter % $row_size) == 0) {
				if($counter > 0) {
					?></div><?php
				}
				?><div class="row resource-row"><?php
			}
			?>

			<div class="span3 box resource-box">
				<?php if ($href = get_post_meta($resource->ID, "_links_to", true) != null) : ?>
				<a href="<?=get_post_meta($resource->ID, "_links_to", true); ?>">
				<?php endif; ?>
					<div class="resource">
						<div class="resource-info featured-image"><?=get_the_post_thumbnail($resource->ID); ?></div>
						<div class="resource-info featured-text">
							<h4><?=$resource->post_title; ?></h3>
							<?php if($shortDescription = get_post_meta($resource->ID, 'footerresource_short_description', true)) : ?>
							<p><?=$shortDescription; ?></p>
							<?php else : ?>
							<p><?=$resource->post_content; ?></p>
							<?php endif; ?>
						</div>
						<div style="clear: both;"></div>
					</div>
				<?php if ($href != null) : ?>
				</a>
				<?php endif; ?>
			</div>
			<?php $counter++; ?>
		<?php endforeach; ?>
		</div>
<?php endif; ?>
