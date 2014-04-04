<?php


/**
 * Create a javascript slideshow of each top level element in the
 * shortcode.  All attributes are optional, but may default to less than ideal
 * values.  Available attributes:
 * 
 * height     => css height of the outputted slideshow, ex. height="100px"
 * width      => css width of the outputted slideshow, ex. width="100%"
 * transition => length of transition in milliseconds, ex. transition="1000"
 * cycle      => length of each cycle in milliseconds, ex cycle="5000"
 * animation  => The animation type, one of: 'slide' or 'fade'
 *
 * Example:
 * [slideshow height="500px" transition="500" cycle="2000"]
 * <img src="http://some.image.com" .../>
 * <div class="robots">Robots are coming!</div>
 * <p>I'm a slide!</p>
 * [/slideshow]
 **/
function sc_slideshow($attr, $content=null){
	$content = cleanup(str_replace('<br />', '', $content));
	$content = DOMDocument::loadHTML($content);
	$html    = $content->childNodes->item(1);
	$body    = $html->childNodes->item(0);
	$content = $body->childNodes;

	# Find top level elements and add appropriate class
	$items = array();
	foreach($content as $item){
		if ($item->nodeName != '#text'){
			$classes   = explode(' ', $item->getAttribute('class'));
			$classes[] = 'slide';
			$item->setAttribute('class', implode(' ', $classes));
			$items[] = $item->ownerDocument->saveXML($item);
		}
	}

	$animation = ($attr['animation']) ? $attr['animation'] : 'slide';
	$height    = ($attr['height']) ? $attr['height'] : '100px';
	$width     = ($attr['width']) ? $attr['width'] : '100%';
	$tran_len  = ($attr['transition']) ? $attr['transition'] : 1000;
	$cycle_len = ($attr['cycle']) ? $attr['cycle'] : 5000;

	ob_start();
	?>
	<div 
		class="slideshow <?=$animation?>"
		data-tranlen="<?=$tran_len?>"
		data-cyclelen="<?=$cycle_len?>"
		style="height: <?=$height?>; width: <?=$width?>;"
	>
		<?php foreach($items as $item):?>
		<?=$item?>
		<?php endforeach;?>
	</div>
	<?php
	$html = ob_get_clean();

	return $html;
}
add_shortcode('slideshow', 'sc_slideshow');


function sc_search_form() {
	ob_start();
	?>
	<div class="search">
		<?get_search_form()?>
	</div>
	<?
	return ob_get_clean();
}
add_shortcode('search_form', 'sc_search_form');


/**
 * Include the defined publication, referenced by pub title:
 *
 *     [publication name="Where are the robots Magazine"]
 **/
function sc_publication($attr, $content=null){
	$pub      = @$attr['pub'];
	$pub_name = @$attr['name'];
	$pub_id   = @$attr['id'];
	
	if (!$pub and is_numeric($pub_id)){
		$pub = get_post($pub);
	}
	if (!$pub and $pub_name){
		$pub = get_page_by_title($pub_name, OBJECT, 'publication');
	}
	
	$pub->url   = get_post_meta($pub->ID, "publication_url", True);
	$pub->thumb = get_the_post_thumbnail($pub->ID, 'publication-thumb');
	
	ob_start(); ?>
	
	<div class="pub">
		<a class="track pub-track" title="<?=$pub->post_title?>" data-toggle="modal" href="#pub-modal-<?=$pub->ID?>">
			<?=$pub->thumb?>
			<span><?=$pub->post_title?></span>
		</a>
		<p class="pub-desc"><?=$pub->post_content?></p>
		<div class="modal hide fade" id="pub-modal-<?=$pub->ID?>" role="dialog" aria-labelledby="<?=$pub->post_title?>" aria-hidden="true">
			<iframe src="<?=$pub->url?>" width="100%" height="100%" scrolling="no"></iframe>
			<a href="#" class="btn" data-dismiss="modal">Close</a>
		</div>
	</div>
	
	<?php
	return ob_get_clean();
}
add_shortcode('publication', 'sc_publication');



function sc_person_picture_list($atts) {
	$atts['type']	= ($atts['type']) ? $atts['type'] : null;
	$row_size 		= ($atts['row_size']) ? (intval($atts['row_size'])) : 5;
	$categories		= ($atts['categories']) ? $atts['categories'] : null;
	$org_groups		= ($atts['org_groups']) ? $atts['org_groups'] : null;
	$limit			= ($atts['limit']) ? (intval($atts['limit'])) : -1;
	$join			= ($atts['join']) ? $atts['join'] : 'or';
	$people 		= sc_object_list(
						array(
							'type' => 'person', 
							'limit' => $limit,
							'join' => $join,
							'categories' => $categories, 
							'org_groups' => $org_groups
						), 
						array(
							'objects_only' => True,
						));
	
	ob_start();
	
	?><div class="person-picture-list"><?
	$count = 0;
	foreach($people as $person) {
		
		$image_url = get_featured_image_url($person->ID);
		
		$link = ($person->post_content != '') ? True : False;
		if( ($count % $row_size) == 0) {
			if($count > 0) {
				?></div><?
			}
			?><div class="row"><?
		}
		
		?>
		<div class="span2 person-picture-wrap">
			<? if($link) {?><a href="<?=get_permalink($person->ID)?>"><? } ?>
				<img src="<?=$image_url ? $image_url : get_bloginfo('stylesheet_directory').'/static/img/no-photo.jpg'?>" />
				<div class="name"><?=Person::get_name($person)?></div>
				<div class="title"><?=get_post_meta($person->ID, 'person_jobtitle', True)?></div>
				<? if($link) {?></a><?}?>
		</div>
		<?
		$count++;
	}
	?>	</div>
	</div>
	<?
	return ob_get_clean();
}
add_shortcode('person-picture-list', 'sc_person_picture_list');

/**
 * Post search
 *
 * @return string
 * @author Chris Conover
 **/
function sc_post_type_search($params=array(), $content='') {
	$defaults = array(
		'post_type_name'         => 'post',
		'taxonomy'               => 'category',
		'show_empty_sections'    => false,
		'non_alpha_section_name' => 'Other',
		'column_width'           => 'span4',
		'column_count'           => '3',
		'order_by'               => 'title',
		'order'                  => 'ASC',
		'show_sorting'           => True,
		'default_sorting'        => 'term',
		'show_sorting'           => True,
		'meta_key'               => '',
		'meta_value'             => '',
	);

	$params = ($params === '') ? $defaults : array_merge($defaults, $params);

	$params['show_empty_sections'] = (bool)$params['show_empty_sections'];
	$params['column_count']        = is_numeric($params['column_count']) ? (int)$params['column_count'] : $defaults['column_count'];
	$params['show_sorting']        = (bool)$params['show_sorting'];

	if(!in_array($params['default_sorting'], array('term', 'alpha'))) {
		$params['default_sorting'] = $defaults['default_sorting'];
	}

	// Resolve the post type class
	if(is_null($post_type_class = get_custom_post_type($params['post_type_name']))) {
		return '<p>Invalid post type.</p>';
	}
	$post_type = new $post_type_class;

	// Set default search text if the user didn't
	if(!isset($params['default_search_text'])) {
		$params['default_search_text'] = 'Find a '.$post_type->singular_name;
	}

	// Register if the search data with the JS PostTypeSearchDataManager
	// Format is array(post->ID=>terms) where terms include the post title
	// as well as all associated tag names
	$search_data = array();
	foreach(get_posts(array('numberposts' => -1, 'post_type' => $params['post_type_name'], 'meta_key' => $params['meta_key'], 'meta_value' => $params['meta_value'])) as $post) {
		$search_data[$post->ID] = array($post->post_title);
		foreach(wp_get_object_terms($post->ID, 'post_tag') as $term) {
			$search_data[$post->ID][] = $term->name;
		}
	}
	?>
	<script type="text/javascript">
		if(typeof PostTypeSearchDataManager != 'undefined') {
			PostTypeSearchDataManager.register(new PostTypeSearchData(
				<?=json_encode($params['column_count'])?>,
				<?=json_encode($params['column_width'])?>,
				<?=json_encode($search_data)?>
			));
		}
	</script>
	<?

	// Split up this post type's posts by term
	$by_term = array();
	foreach(get_terms($params['taxonomy']) as $term) {
        $posts = get_posts(array(
            'numberposts' => -1,
            'post_type'   => $params['post_type_name'],
            'tax_query'   => array(
                array(
                    'taxonomy' => $params['taxonomy'],
                    'field'    => 'id',
                    'terms'    => $term->term_id
                )
            ),
            'meta_key'    => $params['meta_key'],
            'meta_value'  => $params['meta_value'],
            'orderby'     => $params['order_by'],
            'order'       => $params['order']
        ));

        if(count($posts) == 0 && $params['show_empty_sections']) {
            $by_term[$term->name] = array();
        } else {
            $by_term[$term->name] = $posts;
        }
	}

	// Split up this post type's posts by the first alpha character
	$by_alpha = array();
	$by_alpha_posts = get_posts(array(
		'numberposts' => -1,
		'post_type'   => $params['post_type_name'],
		'orderby'     => 'title',
		'order'       => 'alpha',
		'meta_key'    => $params['meta_key'],
		'meta_value'  => $params['meta_value'],
	));
	foreach($by_alpha_posts as $post) {
		if(preg_match('/([a-zA-Z])/', $post->post_title, $matches) == 1) {
			$by_alpha[strtoupper($matches[1])][] = $post;
		} else {
			$by_alpha[$params['non_alpha_section_name']][] = $post;
		}
	}
	ksort($by_alpha);

	if($params['show_empty_sections']) {
		foreach(range('a', 'z') as $letter) {
			if(!isset($by_alpha[strtoupper($letter)])) {
				$by_alpha[strtoupper($letter)] = array();
			}
		}
	}

	$sections = array(
		'post-type-search-term'  => $by_term,
		'post-type-search-alpha' => $by_alpha,
	);

	ob_start();
	?>
	<div class="post-type-search">
		<div class="post-type-search-header">
			<form class="post-type-search-form" action="." method="get">
				<label style="display:none;">Search</label>
				<input type="text" class="span3" placeholder="<?=$params['default_search_text']?>" />
			</form>
		</div>
		<div class="post-type-search-results "></div>
		<? if($params['show_sorting']) { ?>
		<div class="btn-group post-type-search-sorting">
			<button class="btn<?if($params['default_sorting'] == 'term') echo ' active';?>"><i class="icon-list-alt"></i></button>
			<button class="btn<?if($params['default_sorting'] == 'alpha') echo ' active';?>"><i class="icon-font"></i></button>
		</div>
		<? } ?>
	<?

	if (is_null($post_type_class = get_custom_post_type('document'))) {
		return '<p>Invalid post type.</p>';
	}
	$post_type = new $post_type_class;

	foreach($sections as $id => $section) {
		$hide = false;
		switch($id) {
			case 'post-type-search-alpha':
				if($params['default_sorting'] == 'term') {
					$hide = True;
				}
				break;
			case 'post-type-search-term':
				if($params['default_sorting'] == 'alpha') {
					$hide = True;
				}
				break;
		}
		?>
        <div class="<?=$id?>"<? if($hide) echo ' style="display:none;"'; ?>>
            <? foreach($section as $section_title => $section_posts) { ?>
            <? if(count($section_posts) > 0 || $params['show_empty_sections']) { ?>
                <div>
                    <h3><?=esc_html($section_title)?></h3>
                    <div class="row tt-search-docs">
                        <? if(count($section_posts) > 0) { ?>
                        <? $posts_per_column = ceil(count($section_posts) / $params['column_count']); ?>
                        <? foreach(range(0, $params['column_count'] - 1) as $column_index) { ?>
                            <? $start = $column_index * $posts_per_column; ?>
                            <? $end   = $posts_per_column; ?>
                            <? if(count($section_posts) > $start) { ?>
                                <div class="<?=$params['column_width']?> document-list">
                                    <ul>
                                        <? foreach(array_slice($section_posts, $start, $end) as $post) { ?>
                                        <li class="<?=$post_type->get_document_application($post); ?>" data-post-id="<?=$post->ID?>"><?=$post_type->toHTML($post)?></li>
                                        <? } ?>
                                    </ul>
                                </div>
                                <? } ?>
                            <? } ?>
                        <? } ?>
                    </div>
                </div>
                <? } ?>
            <? } ?>
        </div>
		<?
	}
	?> </div> <?
	return ob_get_clean();
}
add_shortcode('post-type-search', 'sc_post_type_search');

/**
 * License Post search
 *
 * @return string
 * @author Brandon Goves
 **/
function sc_license_post_type_search($params=array(), $content='') {
    $defaults = array(
        'post_type_name'         => 'post',
        'taxonomy'               => 'category',
        'show_empty_sections'    => false,
        'non_alpha_section_name' => 'Other',
        'column_width'           => 'span4',
        'column_count'           => '3',
        'order_by'               => 'title',
        'order'                  => 'ASC',
        'show_sorting'           => True,
        'default_sorting'        => 'term',
        'show_sorting'           => False,
        'meta_key'               => '',
        'meta_value'             => '',
    );

    $params = ($params === '') ? $defaults : array_merge($defaults, $params);

    $params['show_empty_sections'] = (bool)$params['show_empty_sections'];
    $params['column_count']        = is_numeric($params['column_count']) ? (int)$params['column_count'] : $defaults['column_count'];
    $params['show_sorting']        = (bool)$params['show_sorting'];

    if(!in_array($params['default_sorting'], array('term', 'alpha'))) {
        $params['default_sorting'] = $defaults['default_sorting'];
    }

    // Resolve the post type class
    if(is_null($post_type_class = get_custom_post_type($params['post_type_name']))) {
        return '<p>Invalid post type.</p>';
    }
    $post_type = new $post_type_class;

    // Set default search text if the user didn't
    if(!isset($params['default_search_text'])) {
        $params['default_search_text'] = 'Find a '.$post_type->singular_name;
    }

    // Register if the search data with the JS PostTypeSearchDataManager
    // Format is array(post->ID=>terms) where terms include the post title
    // as well as all associated tag names
    $search_data = array();
    foreach(get_posts(array('numberposts' => -1, 'post_type' => $params['post_type_name'], 'meta_key' => $params['meta_key'], 'meta_value' => $params['meta_value'])) as $post) {
        $search_data[$post->ID] = array($post->post_title);
        foreach(wp_get_object_terms($post->ID, 'post_tag') as $term) {
            $search_data[$post->ID][] = $term->name;
        }
    }
    ?>
<script type="text/javascript">
    if(typeof PostTypeSearchDataManager != 'undefined') {
        PostTypeSearchDataManager.register(new PostTypeSearchData(
            <?=json_encode($params['column_count'])?>,
            <?=json_encode($params['column_width'])?>,
            <?=json_encode($search_data)?>
        ));
    }
</script>
    <?

    // Split up this post type's posts by term
    $by_term = array();
    foreach(get_terms($params['taxonomy'], array('parent' => 0)) as $term) {
        foreach(get_term_children($term->term_id, $params['taxonomy']) as $child_term_id) {
            $posts = get_posts(array(
                'numberposts' => -1,
                'post_type'   => $params['post_type_name'],
                'tax_query'   => array(
                    array(
                        'taxonomy' => $params['taxonomy'],
                        'field'    => 'id',
                        'terms'    => $child_term_id
                    )
                ),
                'meta_key'    => $params['meta_key'],
                'meta_value'  => $params['meta_value'],
                'orderby'     => $params['order_by'],
                'order'       => $params['order']
            ));

            $child_term = get_term_by('id', $child_term_id, $params['taxonomy']);
            if(count($posts) == 0 && $params['show_empty_sections']) {
                $by_term[$term->name][$child_term->name] = array();
            } else if (count($posts)) {
                $by_term[$term->name][$child_term->name] = $posts;
                ksort($by_term[$term->name]);
            }
        }
    }

    // Split up this post type's posts by the first alpha character
    $by_alpha = array();
    $by_alpha_posts = get_posts(array(
        'numberposts' => -1,
        'post_type'   => $params['post_type_name'],
        'orderby'     => 'title',
        'order'       => 'alpha',
        'meta_key'    => $params['meta_key'],
        'meta_value'  => $params['meta_value'],
    ));
    foreach($by_alpha_posts as $post) {
        if(preg_match('/([a-zA-Z])/', $post->post_title, $matches) == 1) {
            $by_alpha[strtoupper($matches[1])][] = $post;
        } else {
            $by_alpha[$params['non_alpha_section_name']][] = $post;
        }
    }
    ksort($by_alpha);

    if($params['show_empty_sections']) {
        foreach(range('a', 'z') as $letter) {
            if(!isset($by_alpha[strtoupper($letter)])) {
                $by_alpha[strtoupper($letter)] = array();
            }
        }
    }

    $sections = array(
        'post-type-search-term'  => $by_term,
        'post-type-search-alpha' => $by_alpha,
    );

    ob_start();
    ?>
	<div class="post-type-search">
        <div class="post-type-search-header">
            <form class="post-type-search-form" action="." method="get">
                <label style="display:none;">Search</label>
                <input type="text" class="span3" placeholder="<?=$params['default_search_text']?>" />
            </form>
        </div>

        <div class="post-type-search-results "></div>
        <? if($params['show_sorting']) { ?>
        <div class="btn-group post-type-search-sorting">
            <button class="btn<?if($params['default_sorting'] == 'term') echo ' active';?>"><i class="icon-list-alt"></i></button>
            <button class="btn<?if($params['default_sorting'] == 'alpha') echo ' active';?>"><i class="icon-font"></i></button>
        </div>
        <? } ?>
        <?

        if (is_null($post_type_class = get_custom_post_type('document'))) {
            return '<p>Invalid post type.</p>';
        }
        $post_type = new $post_type_class;

        foreach($sections as $id => $section) {
            $hide = false;
            switch($id) {
                case 'post-type-search-alpha':
                    if($params['default_sorting'] == 'term') {
                        $hide = True;
                    }
                    break;
                case 'post-type-search-term':
                    if($params['default_sorting'] == 'alpha') {
                        $hide = True;
                    }
                    break;
            }
            ?>
            <? if($id == 'post-type-search-term') { ?>
                <div class="tt-search-header-index">
            	<?php foreach($section as $section_title => $sub_section) { ?>
            		<h3 name="<?=sanitize_title($section_title); ?>" id="<?=sanitize_title($section_title); ?>" class="tt-search-header"><?=esc_html($section_title)?></h3>
            		<? foreach($sub_section as $sub_section_title => $sub_section_posts) { ?>
            		<? if(count($sub_section_posts) > 0 || $params['show_empty_sections']) { ?>
                            <? $subheader_tag = esc_html(str_replace(' ', '', $sub_section_title)); ?>
                            <a href="#<?=sanitize_title($subheader_tag); ?>"><h4 class="tt-search-subheader btn btn-default btn-flat"><?=esc_html($sub_section_title); ?></h4></a>
                   	<?php } ?>
                   <?php } ?>
            	<?php } ?>
            	</div>
                <div class="<?=$id?>"<? if($hide) echo ' style="display:none;"'; ?>>
                    <? foreach($section as $section_title => $sub_section) { ?>
                    <div>
                        <h3 name="<?=sanitize_title($section_title); ?>" id="<?=sanitize_title($section_title); ?>" class="tt-search-header"><?=esc_html($section_title)?></h3>
                        <div class="row"><div class="span12 tt-search-divider"></div></div>
                        <? foreach($sub_section as $sub_section_title => $sub_section_posts) { ?>
                        <? if(count($sub_section_posts) > 0 || $params['show_empty_sections']) { ?>
                            <? $subheader_tag = esc_html(str_replace(' ', '', $sub_section_title)); ?>
                            <a href="#<?=sanitize_title($subheader_tag); ?>"><h4 id="<?=sanitize_title($subheader_tag); ?>" class="tt-search-subheader"><?=strtoupper(esc_html($sub_section_title)); ?></h4></a>
                            <div class="row tt-search-docs">
                                <? if(count($sub_section_posts) > 0) { ?>
                                <? $posts_per_column = ceil(count($sub_section_posts) / $params['column_count']); ?>
                                <? foreach(range(0, $params['column_count'] - 1) as $column_index) { ?>
                                    <? $start = $column_index * $posts_per_column; ?>
                                    <? $end   = $posts_per_column; ?>
                                    <? if(count($sub_section_posts) > $start) { ?>
                                        <div class="<?=$params['column_width']?> document-list">
                                            <ul>
                                                <? foreach(array_slice($sub_section_posts, $start, $end) as $post) { ?>
                                                <li class="<?=$post_type->get_document_application($post); ?>"
                                                    data-post-id="<?=$post->ID?>"><?=$post_type->toHTML($post)?></li>
                                                <? } ?>
                                            </ul>
                                        </div>
                                        <? } ?>
                                    <? } ?>
                                <? } ?>
                            </div>
                            <? } ?>
                        <? } ?>
                    </div>
                    <? } ?>
                </div>
            <? } else { ?>
                <div class="<?=$id?>"<? if($hide) echo ' style="display:none;"'; ?>>
                    <? foreach($section as $section_title => $section_posts) { ?>
                        <? if(count($section_posts) > 0 || $params['show_empty_sections']) { ?>
                            <div>
                                <h3><?=esc_html($section_title)?></h3>
                                <div class="row tt-search-docs">
                                    <? if(count($section_posts) > 0) { ?>
                                    <? $posts_per_column = ceil(count($section_posts) / $params['column_count']); ?>
                                    <? foreach(range(0, $params['column_count'] - 1) as $column_index) { ?>
                                        <? $start = $column_index * $posts_per_column; ?>
                                        <? $end   = $posts_per_column; ?>
                                        <? if(count($section_posts) > $start) { ?>
                                            <div class="<?=$params['column_width']?> document-list">
                                                <ul>
                                                    <? foreach(array_slice($section_posts, $start, $end) as $post) { ?>
                                                    <li class="<?=$post_type->get_document_application($post); ?>" data-post-id="<?=$post->ID?>"><?=$post_type->toHTML($post)?></li>
                                                    <? } ?>
                                                </ul>
                                            </div>
                                            <? } ?>
                                        <? } ?>
                                    <? } ?>
                                </div>
                            </div>
                            <? } ?>
                        <? } ?>
                </div>
                    <? } ?>
            <?
        }
        ?> </div>
        <script>
			jQuery(document).ready(function() {
				var offset = 220;
				var duration = 500;
				jQuery(window).scroll(function() {
					if (jQuery(this).scrollTop() > offset) {
						jQuery('.back-to-top').fadeIn(duration);
					} else {
						jQuery('.back-to-top').fadeOut(duration);
					}
				});
				jQuery('.back-to-top').click(function(event) {
					event.preventDefault();
					jQuery('html, body').animate({scrollTop: 0}, duration);
					return false;
				});
		});
		</script>
        <a href="#" class="back-to-top">Back to Top</a>
    <?php
	return ob_get_clean();
}
add_shortcode('license-post-type-search', 'sc_license_post_type_search');
?>
