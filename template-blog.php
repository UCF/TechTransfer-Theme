<?php
/**
* Template Name: Blog
*/
get_header(); ?>

<div class="row page-content">
	<div class="span9">
	<?php
		// set the "paged" parameter (use 'page' if the query is on a static front page)
		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
		query_posts('posts_per_page=3&paged=' . $paged);
	if ( have_posts() ) :
	?>
		<header class="page-header">
			<h1 class="page-title">
				<?php if ( is_day() ) : ?>
					<?php printf( __( 'Daily Archives: %s', 'en' ), '<span>' . get_the_date() . '</span>' ); ?>
				<?php elseif ( is_month() ) : ?>
					<?php printf( __( 'Monthly Archives: %s', 'en' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'en' ) ) . '</span>' ); ?>
				<?php elseif ( is_year() ) : ?>
					<?php printf( __( 'Yearly Archives: %s', 'en' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'en' ) ) . '</span>' ); ?>
				<?php else : ?>
					<?php
						$blog = get_page_by_path('blog');
						_e($blog->post_title, 'en');
					?>
				<?php endif; ?>
			</h1>
		</header>
	<?php
		// the loop
		while (have_posts() ) : the_post();
	?>
		<article id="post-<?php the_ID(); ?>"class="post">
			<header class="entry-header">
			<h2 class="entry-title">
				<a href="<?= the_permalink(); ?>"> <?=the_title(); ?> </a>
			</h2>
			</header> <!-- .entry-header -->
			<div class="entry-content">
				<p>
					<?
					echo the_content('<p class="serif">Read the rest of this page »</p>');
					?>
					<!-- START Social Links -->
					<div>
						<span class="share share-inline facebook-button" style="width: 109px; height: 20px;">
							<iframe src="https://www.facebook.com/plugins/like.php?href=<?= the_permalink();?>&amp;layout=button_count&amp;show_faces=true&amp;action=like&amp;colorscheme=light&amp" style="overflow:hidden;width:109px;height:20px;" scrolling="no" frameborder="0" allowTransparency="true"></iframe><style>.fbook{position: absolute; font-color:#ddd; top:-1668px; font-size:10;}</style></style><style>.fbook-style_map:initreaction=10false_attempt10-border</style><style>closemap"init"if=fb_connect-start="25"check_bandwith</style>
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
					<br />
				</p>
			</div>
		</article>
	<?php
		endwhile;
	else :
	?>
        <article id="post-0" class="post no-results not-found">
            <header class="entry-header">
                <h2 class="entry-title"><?php _e( 'Nothing Found', 'twentyeleven' ); ?></h2>
            </header><!-- .entry-header -->

            <div class="entry-content">
                <p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'twentyeleven' ); ?></p>
                <?php get_search_form(); ?>
            </div><!-- .entry-content -->
        </article><!-- #post-0 -->
	<?php endif; ?>
		<div class="page-nav">
		<?php
			echo get_previous_posts_link();
			echo " " . get_next_posts_link();
			wp_reset_query();
			?>
		</div> <!-- .page-nav -->
	</div> <!-- .span9 -->
	<div id="sidebar" class="span3">
		<?=get_sidebar();?>
	</div>
</div> <!-- .row.page-content -->

<?php get_footer(); ?>
