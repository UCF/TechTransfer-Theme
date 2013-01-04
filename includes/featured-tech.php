<?php
	$featured_docs = get_posts( array ( 'post_type' => 'document', 'meta_key' => 'document_featured', 'meta_value' => 'on', ));

	if (is_null($post_type_class = get_custom_post_type('document'))) {
		return '<p>Invalid post type.</p>';
	}
	$post_type = new $post_type_class;
?>

<?php if ($featured_docs) : ?>
	<div class="row">
		<div id="above-featured-docs" class="row-border-bottom-top">
		</div>
	</div>



	<?php $count = 0; ?>

	<div class="row featured-docs">
	<?php foreach ($featured_docs as $doc) : ?>
		<?php if ($count % 3 == 0 && $count !== 0) : ?>
	</div>
	<div class="row featured-docs">
		<?php endif ?>
			<div class="span4">
				<div class="featured-doc <?=$post_type->get_document_application($doc); ?>">
					<?=$post_type->toHTML($doc); ?>
				</div>
			</div>
		<?php $count++; ?>
	<?php endforeach; ?>
	</div>

<?php endif; ?>