<?php disallow_direct_load('single.php');?>
<?php get_header(); the_post();?>
	
	<div class="row page-content" id="<?=$post->post_name?>">
		<div class="span12">
			<article>
				<?php if (get_post_type() == "news") : ?>
					<?php $newsPosts = get_posts(array( 'numberposts' => -1, 'post_type' => 'news' )); ?>
					<?php foreach ($newsPosts as $post) : ?>
							<h1><?php the_title();?></h1>
							<?php $linkTo = get_post_meta(get_the_ID(), '_links_to', true); ?>
							<?php if (empty($linkTo)) :  ?>
								<?php the_content();?>
							<?php else : ?>
								<a href="<?=$linkTo; ?>">Linked News Story</a>
							<?php endif; ?>
					<?php endforeach; ?>
				<?php else : ?>
					<? if(!is_front_page())	{ ?>
							<h1><?php the_title();?></h1>
					<? } ?>
					<?php the_content();?>
				<?php endif; ?>
			</article>
		</div>
	</div>

<?php get_footer();?>