<?php
/**
 * Uploadscreen for selecting and uploading new media file
 *
 * @author      Måns Jonasson  <http://www.mansjonasson.se>
 * @copyright   Måns Jonasson 13 sep 2010
 * @version     $Revision: 2303 $ | $Date: 2010-09-13 11:12:35 +0200 (ma, 13 sep 2010) $
 * @package     wordpress
 * @subpackage  enable-media-replace
 *
 * ** Modified for HR Theme **
 */

if (!current_user_can('upload_files'))
	wp_die(__('You do not have permission to upload files.', 'enable-media-replace'));

global $wpdb;

$table_name = $wpdb->prefix . "posts";

$sql = "SELECT guid, post_mime_type FROM $table_name WHERE ID = " . (int) $_GET["attachment_id"];

list($current_filename, $current_filetype) = mysql_fetch_array(mysql_query($sql));

$current_filename = substr($current_filename, (strrpos($current_filename, "/") + 1));


?>
<div class="wrap">
		<div id="icon-upload" class="icon32"><br /></div>
	<h2><?php echo __("Replace Media Upload", "enable-media-replace"); ?></h2>

	<?php
	$url = admin_url( "upload.php?page=enable-media-replace/enable-media-replace.php&noheader=true&action=media_replace_upload&attachment_id=" . (int) $_GET["attachment_id"]);
	$action = "media_replace_upload";
    $formurl = wp_nonce_url( $url, $action );
	if (FORCE_SSL_ADMIN) {
			$formurl = str_replace("http:", "https:", $formurl);
		}
	?>

	<form enctype="multipart/form-data" method="post" action="<?php echo $formurl; ?>">
		<input type="hidden" name="ID" value="<?php echo (int) $_GET["attachment_id"]; ?>" />
		<div id="message" class="updated fade" style="margin-top:20px;"><p>NOTE: You are about to replace the media file <strong>"<?php echo $current_filename?>"</strong>. There is <strong>no undo</strong>. Think about it!</p></div>

		<p>Choose a file to upload from your computer:</p>

		<input type="file" name="userfile" />

		<div class="directions">
		<p>The name of the attachment will stay the same <strong>(<?php echo $current_filename; ?>)</strong> no matter what the file you upload is called. This will maintain any existing links or bookmarks to the attachment while ensuring the most up-to-date file is associated with the attachment.<br/>
		The file you are uploading MUST use the same filetype as the original file <strong>(<?php echo $current_filetype; ?>)</strong>. Uploading a new file with a different filetype can cause the file to not load correctly.</p>
		</div>

		<input type="submit" class="button-primary" value="Upload" /> <a class="button" href="#" onclick="history.back();">Cancel</a>

	</form>
</div>
