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


function trigger_edit_attachment( $attachment_id ) {
	do_action( 'edit_attachment', $attachment_id );
}
include_once ABSPATH . 'wp-admin/includes/plugin.php';
if ( is_plugin_active( 'enable-media-replace/enable-media-replace.php' ) ) {
	add_action( 'enable-media-replace-upload-done', 'trigger_edit_attachment', 10, 1 );
}
?>
