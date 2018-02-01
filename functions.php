<?php
require_once('functions/base.php');   			# Base theme functions
require_once('functions/feeds.php');			# Where functions related to feed data live
require_once('custom-taxonomies.php');  		# Where per theme taxonomies are defined
require_once('custom-post-types.php');  		# Where per theme post types are defined
require_once('functions/admin.php');  			# Admin/login functions
require_once('functions/config.php');			# Where per theme settings are registered
require_once('shortcodes.php');         		# Per theme shortcodes

//Add theme-specific functions here.

/**
 * Add ID attribute to registered University Header script.
 **/
function add_id_to_ucfhb($url) {
    if ( (false !== strpos($url, 'bar/js/university-header.js')) || (false !== strpos($url, 'bar/js/university-header-full.js')) ) {
      remove_filter('clean_url', 'add_id_to_ucfhb', 10, 3);
      return "$url' id='ucfhb-script";
    }
    return $url;
}
add_filter('clean_url', 'add_id_to_ucfhb', 10, 3);


function protocol_relative_attachment_url($url) {
    if (is_ssl()) {
        $url = str_replace('http://', 'https://', $url);
    }
    return $url;
}
add_filter('wp_get_attachment_url', 'protocol_relative_attachment_url');


/**
 * Force 'edit_attachment' to be fired whenever an attachment's metadata is
 * updated (for Enable Media Replace compatibility with Varnish plugins.)
 **/
function trigger_edit_attachment( $meta_id, $post_id, $meta_key, $meta_value ) {
    // Only $meta_id tends to be available at this point, so fill in the blanks:
    $meta = get_post_meta_by_id( $meta_id );
    $post_obj = get_post( intval( $meta->post_id ) );
    if ( $post_obj && $post_obj->post_type == 'attachment' ) {
        do_action( 'edit_attachment', intval( $post_obj->ID ) );
    }
}
add_action( 'updated_post_meta', 'trigger_edit_attachment', 10, 4 );

?>
