<?php
/*
Plugin Name: Enable Media Replace
Plugin URI: http://www.mansjonasson.se/enable-media-replace
Description: Enable replacing media files by uploading a new file in the "Edit Media" section of the WordPress Media Library.
Version: 2.8.1
Author: Måns Jonasson
Author URI: http://www.mansjonasson.se

Dual licensed under the MIT and GPL licenses:
http://www.opensource.org/licenses/mit-license.php
http://www.gnu.org/licenses/gpl.html

Developed for .SE (Stiftelsen för Internetinfrastruktur) - http://www.iis.se
*/

/**
 * Main Plugin file
 * Set action hooks and add shortcode
 *
 * @author      Måns Jonasson  <http://www.mansjonasson.se>
 * @copyright   Måns Jonasson 13 sep 2010
 * @package     wordpress
 * @subpackage  enable-media-replace
 *
 * ** Modified for HR Theme **
 */

add_action('admin_menu', 'emr_menu');
add_filter('attachment_fields_to_edit', 'enable_media_replace', 10, 2);

add_shortcode('file_modified', 'emr_get_modified_date');

/**
 * Register this file in WordPress so we can call it with a ?page= GET var.
 * To suppress it in the menu we give it an empty menu title.
 */
function emr_menu() {
	//add_submenu_page('upload.php', __("Replace media", "enable-media-replace"), '','upload_files', __FILE__, 'emr_options');
	// usage:  add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
	add_submenu_page(NULL, 'Replace Media', '', 'upload_files', 'enable-media-replace/enable-media-replace.php', 'emr_options');
}

/**
 * Add some new fields to the attachment edit panel.
 * @param array form fields edit panel
 * @return array form fields with enable-media-replace fields added
 */
function enable_media_replace( $form_fields, $post ) {

	// Check if we are on media upload screen for insertion of replace link
	$on_media_edit_screen = false;
	$current_wp_version = get_bloginfo('version');
	if ($current_wp_version < 3.5) {
		if (isset($_GET["attachment_id"]) && $_GET["attachment_id"]) { $on_media_edit_screen = true; } 
	}
	else {
		$current_screen = get_current_screen();
		if ( $current_screen->base == 'post' && $current_screen->post_type == 'attachment' ) { $on_media_edit_screen = true; }
	}
	
	if ($on_media_edit_screen == true) {

		$url = admin_url( "upload.php?page=enable-media-replace/enable-media-replace.php&action=media_replace&attachment_id=" . $post->ID);
		$action = "media_replace";
      	$editurl = wp_nonce_url( $url, $action );

		if (FORCE_SSL_ADMIN) {
			$editurl = str_replace("http:", "https:", $editurl);
		}
		$link = "href=\"$editurl\"";
		$form_fields["enable-media-replace"] = array("label" => __("Replace media", "enable-media-replace"), "input" => "html", "html" => "<p><a class='button-secondary'$link>" . __("Upload a new file", "enable-media-replace") . "</a></p>", "helps" => __("To replace the current file, click the link and upload a replacement.", "enable-media-replace"));
	}
	return $form_fields;
}

/**
 * Load the replace media panel.
 * Panel is show on the action 'media-replace' and a given attachement.
 * Called by GET var ?page=enable-media-replace/enable-media-replace.php
 */
function emr_options() {

	if ( isset( $_GET['action'] ) && $_GET['action'] == 'media_replace' ) {
    	check_admin_referer( 'media_replace' ); // die if invalid or missing nonce
		if ( array_key_exists("attachment_id", $_GET) && (int) $_GET["attachment_id"] > 0) {
			include('popup.php');
		}
	}
	
	if ( isset( $_GET['action'] ) && $_GET['action'] == 'media_replace_upload' ) {
		$plugin_url =  str_replace("enable-media-replace.php", "", __FILE__);
    	check_admin_referer( 'media_replace_upload' ); // die if invalid or missing nonce
		require_once($plugin_url . 'upload.php');
	}

}

?>