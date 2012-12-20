<?php $footerResources = new WP_Query( array( 'post_type' => 'footerresource', 'order_by' => 'menu_order', 'order' => 'ASC') ); ?>

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
				<div class="span3 box resource-box">
					<div class="resource">
						<div class="resource-info featured-image"><?=the_post_thumbnail(); ?></div>
						<div class="resource-info featured-text">
							<h4><?=get_the_title(); ?></h3>
							<p><?=get_the_content(); ?></p>
						</div>
						<div style="clear: both;"></div>
					</div>
					<?php else : ?>
				<div class="span3 resource-none">
						<?php $lastPost = true; ?>
					<?php endif; ?>
				</div>
			<?php endfor; ?>
		</div>
		<?php endfor; ?>
<?php endif; ?>