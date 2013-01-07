<div class="row">
	<div id="below-the-home-header" class="row-border-bottom-top">
		<div class="span4">
			<?php $inventorPosts = new WP_Query(array( 'post_type' => 'inventor' , 'posts_per_page' => 1 )); ?>
			<?php while($inventorPosts->have_posts()) : $inventorPosts->the_post(); ?>
				<a href="<?=get_permalink( $post->ID ); ?>">
				<?=the_post_thumbnail( array( 300, 300 )); ?>
				<h2>Inventor: <b><?=the_title(); ?></b></h2>
				<?php if($shortDescription = get_post_meta($post->ID, 'inventor_short_description', true)) : ?>
				<p><?=$shortDescription; ?></p>
				<?php else : ?>
				<p><?=get_the_content(); ?></p>
				<?php endif; ?>
				</a>
			<?php endwhile; ?>
		</div>
		<div class="span4">
			<?php $technologyPosts = new WP_Query(array( 'post_type' => 'technology' , 'posts_per_page' => 1 )); ?>
			<?php while($technologyPosts->have_posts()) : $technologyPosts->the_post(); ?>
				<a href="<?=get_permalink( $post->ID ); ?>">
				<?=the_post_thumbnail( array( 300, 300 ) ); ?>
				<h2>Technology: <b><?=the_title(); ?></b></h2>
				<?php if($shortDescription = get_post_meta($post->ID, 'technology_short_description', true)) : ?>
				<p><?=$shortDescription; ?></p>
				<?php else : ?>
				<p><?=get_the_content(); ?></p>
				<?php endif; ?>
				</a>
			<?php endwhile; ?>
		</div>
		<div class="span4">
			<?php $aboutPage = new WP_Query(array( 'post_type' => 'news', 'posts_per_page' => 1 )); ?>
			<?php while($aboutPage->have_posts()) : $aboutPage->the_post(); ?>
				<a href="<?=get_permalink( $post->ID ); ?>">
				<?=the_post_thumbnail(array( 300, 300 )); ?>
				<h2>News: <b><?=the_title(); ?></b></h2>
				<?php if($shortDescription = get_post_meta($post->ID, 'news_short_description', true)) : ?>
				<p><?=$shortDescription; ?></p>
				<?php else : ?>
				<p><?=get_the_content(); ?></p>
				<?php endif; ?>
				</a>
			<?php endwhile; ?>
		</div>
	</div>
</div>