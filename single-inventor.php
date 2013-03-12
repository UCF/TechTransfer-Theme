<?php get_header(); the_post();?>
	<div class="row page-content" id="<?=$post->post_name?>">
		<div class="span12">
			<article>
				<h2 class="content-title"><?php the_title();?></h2>
				<?php the_content();?>
			</article>
		</div>
	</div>
	<div class="row">
		<div class="span12" id="archives-link">
			<p><i class="icon-inbox"></i> <a href="<?=get_permalink(get_page_by_title('Archives')->ID)?>">View Archives</a></p>
		</div>
	</div>
<?php get_template_part('includes/above-the-footer'); ?>
<?php get_footer();?>