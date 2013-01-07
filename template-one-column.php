<?php
/**
 * Template Name: One Column
 **/
?>
<?php get_header(); the_post();?>
	<div class="row page-content" id="<?=$post->post_name?>">
		<div class="span12">
			<article>
				<? if(!is_front_page())	{ ?>
						<h2 class="content-title"><?php the_title();?></h2>
				<? } ?>
				<?php the_content();?>
			</article>
		</div>
	</div>
<?php get_template_part('includes/above-the-footer'); ?>
<?php get_footer();?>