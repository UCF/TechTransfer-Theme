<?php
 $blog = get_page_by_path( 'blog' );
 $archives = get_page_by_path( 'archives' );
?>
<div class="row">
	<div id="below-the-home-header" class="row-border-bottom-top">
		<div class="span4">
		<?php
		$newsPage = get_posts( array( 'post_type' => 'news', 'posts_per_page' => 1 ) );
		if ( ! empty( $newsPage ) ) :
			$newsPage = $newsPage[0];
		?>
			<a href="<?php echo get_permalink( $newsPage->ID ); ?>">
				<h2>Featured Researcher</h2>
				<?php echo get_the_post_thumbnail( $newsPage->ID, array( 300, 300 ) ); ?>
				<b><?php echo get_the_title( $newsPage->ID ); ?></b>
				<?php if ( $shortDescription = get_post_meta( $newsPage->ID, 'news_short_description', true ) ) : ?>
					<p><?php echo $shortDescription; ?></p>
				<?php else : ?>
					<p><?php echo apply_filters( 'the_content', $newsPage->post_content ); ?></p>
				<?php endif; ?>
			</a>
			<a href="<?php echo get_page_link( $archives->ID ); ?>">&raquo; Researcher Archives</a>
		<?php endif; ?>
		</div>

		<div class="span4">
		<?php
		$blogPage = get_posts( array( 'post_type' => 'post', 'posts_per_page' => 1 ) );
		if ( ! empty( $blogPage ) ) :
			$blogPage = $blogPage[0];
		?>
			<a href="<?php echo get_permalink( $blogPage->ID ); ?>">
				<h2>Featured Technology</h2>
				<?php echo get_the_post_thumbnail( $blogPage->ID, array( 300, 300 ) ); ?>
				<b><?php echo get_the_title( $blogPage->ID ); ?></b>
				<?php if ( $shortDescription = get_post_meta( $blogPage->ID, 'post_short_description', true ) ) : ?>
					<p><?php echo $shortDescription; ?></p>
				<?php else : ?>
					<p><?php echo apply_filters( 'the_content', $blogPage->post_content ); ?></p>
				<?php endif; ?>
			</a>
			<a href="<?php echo get_page_link( $archives->ID ); ?>">&raquo; Blog Archives</a>
		<?php endif; ?>
		</div>

		<div class="span4">
		<?php
		$techNewsPost = get_posts( array( 'post_type' => 'success_story', 'posts_per_page' => 1 ) );
		if ( ! empty( $techNewsPost ) ) :
			$techNewsPost = $techNewsPost[0];
		?>
			<a href="<?php echo get_permalink( $techNewsPost->ID ); ?>">
				<h2>Technology News</h2>
				<?php echo get_the_post_thumbnail( $techNewsPost->ID, array( 300, 300 )); ?>
				<b><?php echo get_the_title( $techNewsPost->ID ); ?></b>
				<?php if ( $shortDescription = get_post_meta( $techNewsPost->ID, 'success_story_short_description', true ) ) : ?>
					<p><?php echo $shortDescription; ?></p>
				<?php else : ?>
					<p><?php echo apply_filters( 'the_content', $techNewsPost->post_content ); ?></p>
				<?php endif; ?>
			</a>
			<a href="<?php echo get_page_link( $archives->ID ); ?>">&raquo; Tech News Archives</a>
		<?php endif; ?>
		</div>
	</div>
</div>
