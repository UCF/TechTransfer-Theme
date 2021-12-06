<?php disallow_direct_load('single.php');?>
<?php get_header(); the_post();?>
	<div class="page-content person-profile">
		<div class="row">
			<div class="span2 details">
			<?php
				$title = get_post_meta($post->ID, 'person_jobtitle', True);
				$image_url = get_featured_image_url($post->ID);
				$email = get_post_meta($post->ID, 'person_email', True);
				$phones = Person::get_phones($post);
			?>
			<img src="<?=$image_url ? $image_url : get_bloginfo('stylesheet_directory').'/static/img/no-photo.jpg'?>" />
			<?php if(count($phones)) { ?>
			<ul class="phones unstyled">
				<?php foreach($phones as $phone) { ?>
				<li><?=$phone?></li>
				<?php } ?>
			</ul>
			<?php } ?>
			<?php if($email != '') { ?>
			<hr />
			<a class="email" href="mailto:<?=$email?>"><?=$email?></a>
			<?php } ?>
			</div>
			<div class="span10">
				<h2><?=$post->post_title?><?=($title == '') ?: ' - '.$title ?></h2>
				<?=$content = str_replace(']]>', ']]>', apply_filters('the_content', $post->post_content))?>
			</div>
		</div>
		<?php get_template_part('includes/below-the-fold'); ?>
	</div>
<?php get_footer();?>