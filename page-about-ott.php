<?php get_header(); ?>
<?php $content = get_the_content(); ?>
<?php global $pageID; ?>
<?php $pageID = get_the_ID(); ?>
<div class="row tt-content">
	<div id="about-nav" class="span3">
		<ul class="nav nav-tabs nav-stacked">
			<?php $aboutTopics = new WP_Query( array( 'post_type' => 'about', 'order_by' => 'menu_order', 'order' => 'ASC' ) ); ?>
			<?php while($aboutTopics->have_posts()) : $aboutTopics->the_post(); ?>
				<li><a href="#<?=$post->post_name ?>"><?php the_title() ?> <i class="icon-chevron-right"></i></a></li>
			<?php endwhile; ?>
		</ul>
	</div>
	<div class="span9">
		<?=$content; ?>
		<?php $aboutTopics = new WP_Query( array( 'post_type' => 'about', 'order_by' => 'menu_order', 'order' => 'ASC' ) ); ?>
		<?php while($aboutTopics->have_posts()) : $aboutTopics->the_post(); ?>
			<br />
			<h3 id="<?=$post->post_name ?>" class="tt-about-title"><?php the_title() ?></h3>
			<hr />
			<?php the_content(); ?>
		<?php endwhile; ?>
	</div>
</div>
<?php get_template_part('includes/above-the-footer'); ?>
<?php get_footer(); ?>