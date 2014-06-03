<?php get_header(); the_post();?>
	<div class="row page-content" id="<?=$post->post_name?>">
		<div class="span12">
			<article>
				<h2 class="content-title"><?php the_title();?></h2>
				<?php the_content();?>
			</article>
		</div>
	</div>
	<!-- START Social Links -->
	<div>
		<!-- <a href="http://www.facebook.com/sharer.php?u=<?= the_permalink();?>&t=<?php the_title(); ?>" target="blank">Share on Facebook</a> -->
		<a name="fb_share" type="button_count" expr:share_url="<?= the_permalink();?>" href="http://www.facebook.com/sharer.php">Share</a>
		<span class="share share-inline twitter-button">
			<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?= the_permalink();?>">Tweet</a>
		</span>
		<span class="share share-inline google-button">
			<!-- Place this tag where you want the share button to render. -->
			<div class="g-plus" data-action="share" data-annotation="bubble" data-href="<?= the_permalink();?>"></div>
		</span>
	</div>
	<!-- END Social Links -->
	<div class="row">
		<div class="span12" id="archives-link">
			<p><i class="icon-inbox"></i> <a href="<?=get_permalink(get_page_by_title('Archives')->ID)?>">View Archives</a></p>
		</div>
	</div>
<?php get_template_part('includes/above-the-footer'); ?>
<?php get_footer();?>