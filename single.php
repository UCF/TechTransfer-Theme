<?php disallow_direct_load('single.php');?>
<?php get_header(); the_post();?>

	<div class="row page-content" id="<?=$post->post_name?>">
		<div class="span12">
			<article>
				<?php if (get_post_type() == "news") : ?>
					<?php $ffPosts = get_posts(array( 'numberposts' => -1, 'post_type' => 'news' )); ?>
					<?php foreach ($ffPosts as $post) : ?>
							<h1><?php the_title();?></h1>
							<?php $linkTo = get_post_meta(get_the_ID(), '_links_to', true); ?>
							<?php if (empty($linkTo)) :  ?>
								<?php the_content();?>
							<?php else : ?>
								<a href="<?=$linkTo; ?>">Linked Faculty Feature</a>
							<?php endif; ?>
					<?php endforeach; ?>
				<?php else : ?>
					<?php if(!is_front_page())	{ ?>
							<h1><?php the_title();?></h1>
					<?php } ?>
					<?php the_content();?>
				<?php endif; ?>
			</article>
		</div>
	</div>

<?php get_footer();?>
