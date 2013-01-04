<?php global $pageID; ?>
<?php if (strlen($pageID) == 0): ?>
<?php $pageID = get_the_ID(); ?>
<?php endif; ?>
<?php $resource_meta = get_post_meta( $pageID, 'page_resource', true); ?>

<?php $footerResources = new WP_Query( array( 'post_type' => 'footerresource', 'tax_query' => array( array( 'taxonomy' => 'resource_groups', 'field' => 'slug', 'terms' => $resource_meta ) ), 'order_by' => 'menu_order', 'order' => 'ASC') ); ?>

<?php $numPosts = $footerResources->found_posts; ?>
<?php $numPages = ceil($numPosts / 4); ?>
<?php $lastPost = false; ?>
<?php if($numPages != 0) : ?>
		<div class="row">
			<div id="below-the-content" class="row-border-bottom-top">
			</div>
		</div>
		<?php for($i = 0; $i < $numPages; $i++) : ?>
		<div class="row resource-row">
			<?php for($j = 0; $j < 4; $j++) : ?>
				<?php if($footerResources->have_posts() and !$lastPost) : $footerResources->the_post(); ?>
				<?php if(in_array('Home', wp_get_post_terms($post->ID, 'resource_groups', array('fields' => 'names')))) : ?>
				<div class="span3 box resource-box">
					<?php if ($href = get_post_meta(get_the_ID(), "_links_to", true) != null) : ?>
					<a href="<?=get_post_meta(get_the_ID(), "_links_to", true); ?>">
					<?php endif; ?>
						<div class="resource">
							<div class="resource-info featured-image"><?=the_post_thumbnail(); ?></div>
							<div class="resource-info featured-text">
								<h4><?=get_the_title(); ?></h3>
								<?php if($shortDescription = get_post_meta($post->ID, 'footerresource_short_description', true)) : ?>
								<p><?=$shortDescription; ?></p>
								<?php else : ?>
								<p><?=get_the_content(); ?></p>
								<?php endif; ?>
							</div>
							<div style="clear: both;"></div>
						</div>
					<?php if ($href != null) : ?>
					</a>
					<?php endif; ?>
				</div>
				<?php endif; ?>
				<?php endif; ?>
			<?php endfor; ?>
		</div>
		<?php endfor; ?>
<?php endif; ?>