<?php
 $blog = get_page_by_path('blog');
 $archives = get_page_by_path('archives');
?>
<div class="row">
	<div id="below-the-home-header" class="row-border-bottom-top">
		<div class="span4">
			<a href="<?=get_page_link($blog->ID); ?>">
				<h2>Patent Trending Blog</h2>
				<?php $aboutPage = new WP_Query(array( 'post_type' => 'post', 'posts_per_page' => 1 )); ?>
				<?php while($aboutPage->have_posts()) : $aboutPage->the_post(); ?>
					<?=the_post_thumbnail( array( 300, 300 ) ); ?>
					<b><?=the_title(); ?></b>
				<?php if($shortDescription = get_post_meta($post->ID, 'post_short_description', true)) : ?>
						<p><?=$shortDescription; ?></p>
				<?php else : ?>
						<p><?=get_the_content(); ?></p>
				<?php endif;
				endwhile; ?>
				<a href="<?=get_page_link($blog->ID); ?>">&raquo; Blog Archives</a>
			</a>
		</div>
		<div class="span4">
			<?php $sucessStoryPosts = new WP_Query(array( 'post_type' => 'success_story' , 'posts_per_page' => 1 )); ?>
			<?php while($sucessStoryPosts->have_posts()) : $sucessStoryPosts->the_post(); ?>
				<a href="<?=get_permalink( $post->ID ); ?>">
				<h2>Tech Success Stories</h2>
				<?=the_post_thumbnail( array( 300, 300 )); ?>
				<b><?=the_title(); ?></b>
				<?php if($shortDescription = get_post_meta($post->ID, 'success_story_short_description', true)) : ?>
				<p><?=$shortDescription; ?></p>
				<?php else : ?>
				<p><?=get_the_content(); ?></p>
				<?php endif; ?>
				</a>
			<?php endwhile; ?>
			<a href="<?=get_page_link($archives->ID); ?>">&raquo; Success Story Archives</a>
		</div>
		<div class="span4">
			<?php $aboutPage = new WP_Query(array( 'post_type' => 'news', 'posts_per_page' => 1 )); ?>
			<?php while($aboutPage->have_posts()) : $aboutPage->the_post(); ?>
				<a href="<?=get_permalink( $post->ID ); ?>">
				<h2>Latest News</h2>
				<?=the_post_thumbnail(array( 300, 300 )); ?>
				<b><?=the_title(); ?></b>
				<?php if($shortDescription = get_post_meta($post->ID, 'news_short_description', true)) : ?>
				<p><?=$shortDescription; ?></p>
				<?php else : ?>
				<p><?=get_the_content(); ?></p>
				<?php endif; ?>
				</a>
			<?php endwhile; ?>
			<a href="<?=get_page_link($archives->ID); ?>">&raquo; News Archives</a>
		</div>
	</div>
</div>