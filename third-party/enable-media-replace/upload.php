<?php
if (!current_user_can('upload_files'))
	wp_die(__('You do not have permission to upload files.'));

// Define DB table names
global $wpdb;
$table_name = $wpdb->prefix . "posts";
$postmeta_table_name = $wpdb->prefix . "postmeta";

// Get old guid and filetype from DB
$sql = "SELECT guid, post_mime_type FROM $table_name WHERE ID = '" . (int) $_POST["ID"] . "'";
list($current_filename, $current_filetype) = mysql_fetch_array(mysql_query($sql));

// Massage a bunch of vars
$current_guid = $current_filename;
$current_filename = substr($current_filename, (strrpos($current_filename, "/") + 1));

$current_file = get_attached_file((int) $_POST["ID"], true); // FAILS FOR /files/file.ext UPLOADS!
if (!$current_file) {
	// get_attached_file() fails for files not using the /files/YYYY/MM/file.ext structure
	// so we need to explicitly define $current_file
	$current_path = BLOGUPLOADDIR;
	$current_file = $current_path.$current_filename;
}
else {
	$current_path = substr($current_file, 0, (strrpos($current_file, "/")));
	$current_file = str_replace("//", "/", $current_file);
	$current_filename = basename($current_file);
}

// Check for an uploaded file
if (is_uploaded_file($_FILES["userfile"]["tmp_name"])) {

	// New method for validating that the uploaded file is allowed, using WP:s internal wp_check_filetype_and_ext() function.
	$filedata = wp_check_filetype_and_ext($_FILES["userfile"]["tmp_name"], $_FILES["userfile"]["name"]);
	
	if ($filedata["ext"] == "") {
		echo __("File type does not meet security guidelines. Try another.");
		exit;
	}
	
	$new_filename = $_FILES["userfile"]["name"];
	$new_filesize = $_FILES["userfile"]["size"];
	$new_filetype = $filedata["type"];
	
	// Drop-in replace and we don't even care if you uploaded something that is the wrong file-type.
	// That's your own fault, because we warned you!

	// Useful for debugging:
	/*print "Post ID is: ";
	var_dump((int)$_POST['ID']);
	print "<br/>Current Filename is: ";
	var_dump($current_filename);
	print "<br/>Current File is: ";
	var_dump($current_file);
	print "<br/>Current path is: ";
	var_dump($current_path);
	print "<br/> Current GUID is: ";
	var_dump($current_guid);
	exit;*/


	// Delete old file
	unlink($current_file);
		
	// Delete old resized versions if this was an image
	$suffix = substr($current_file, (strlen($current_file)-4));
	$prefix = substr($current_file, 0, (strlen($current_file)-4));
	$imgAr = array(".png", ".gif", ".jpg");
	if (in_array($suffix, $imgAr)) {
		// Get thumbnail filenames from metadata
		$metadata = wp_get_attachment_metadata($_POST["ID"]);
		foreach($metadata["sizes"] AS $thissize) {
			// Get all filenames and do an unlink() on each one;
			$thisfile = $thissize["file"];
			if (strlen($thisfile)) {
				$thisfile = $current_path . "/" . $thissize["file"];
				if (file_exists($thisfile)) {
					unlink($thisfile);
				}
			}
		}
	}

	// Move new file to old location/name
	move_uploaded_file($_FILES["userfile"]["tmp_name"], $current_file);

	// Chmod new file to 644
	chmod($current_file, 0644);

	// Make thumb and/or update metadata
	wp_update_attachment_metadata( (int) $_POST["ID"], wp_generate_attachment_metadata( (int) $_POST["ID"], $current_file ) );


	$returnurl = get_bloginfo("wpurl") . "/wp-admin/upload.php?posted=3";
	
} else {
	//TODO Better error handling when no file is selected.
	//For now just go back to media management
	$returnurl = get_bloginfo("wpurl") . "/wp-admin/upload.php";
}

if (FORCE_SSL_ADMIN) {
	$returnurl = str_replace("http:", "https:", $returnurl);
}

//save redirection
wp_redirect($returnurl);
?>