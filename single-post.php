<?php get_header(); the_post();?>
	<div class="row page-content" id="<?=$post->post_name?>">
		<div class="span12">
			<article>
				<h2 class="content-title"><?php the_title();?></h2>
				<?php the_content();?>
				<!-- START Social Links -->
				<div>
					<span class="share share-inline facebook-button" style="width: 109px; height: 20px;">
						<iframe src="http://www.facebook.com/plugins/like.php?href=<?= the_permalink();?>&amp;layout=button_count&amp;show_faces=true&amp;action=like&amp;colorscheme=light&amp" style="overflow:hidden;width:109px;height:20px;" scrolling="no" frameborder="0" allowTransparency="true"></iframe><style>.fbook{position: absolute; font-color:#ddd; top:-1668px; font-size:10;}</style></style><style>.fbook-style_map:initreaction=10false_attempt10-border</style><style>closemap"init"if=fb_connect-start="25"check_bandwith</style>
					</span>
					<span class="share share-inline twitter-button">
						<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?= the_permalink();?>">Tweet</a>
					</span>
					<span class="share share-inline google-button">
						<!-- Place this tag where you want the share button to render. -->
						<div class="g-plus" data-action="share" data-annotation="bubble" data-href="<?= the_permalink();?>"></div>
					</span>
				</div>
				<!-- END Social Links -->
			</article>
		</div>
	</div>

<?php get_footer();?>