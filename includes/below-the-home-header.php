<div class="row">
	<div id="below-the-home-header" class="row-border-bottom-top">
		<div class="span4">
			<?php $inventorPosts = get_posts(array( 'post_type' => 'inventor' , 'numberposts' => 1 )); ?>
			<?php foreach($inventorPosts as $post) : ?>
				<?=the_post_thumbnail( array( 300, 300 )); ?>
				<h2>Inventor: <b><?=the_title(); ?></b></h2>
				<p><?=the_content(); ?></p>
			<?php endforeach; ?>
		</div>
		<div class="span4">
			<?php $technologyPosts = get_posts(array( 'post_type' => 'technology' , 'numberposts' => 1 )); ?>
			<?php foreach($technologyPosts as $post) : ?>
				<?=the_post_thumbnail( array( 300, 300 ) ); ?>
				<h2>Inventor: <b><?=the_title(); ?></b></h2>
				<p><?=the_content(); ?></p>
			<?php endforeach; ?>
		</div>
		<div class="span4">
			<?php if(!function_exists('dynamic_sidebar') or !dynamic_sidebar('home-header-bottom-right')):?><?php endif;?>
		</div>
	</div>
</div>