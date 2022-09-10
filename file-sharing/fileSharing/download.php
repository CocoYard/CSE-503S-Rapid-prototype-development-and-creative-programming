<?php
session_start();
if (isset($_GET['file'])){
	$filename = $_GET['file'];

	// We believe any files that can be stored in PC are competent to transfer.
    // So it is no need to check the file name.
	// if( !preg_match('/^[\w_\.\-]+$/', $filename) ){
	// 	echo "Invalid filename";
	// 	exit;
	// }

	// Get the username and make sure that it is alphanumeric with limited other characters.
	// You shouldn't allow usernames with unusual characters anyway, but it's always best to perform a sanity check
	// since we will be concatenating the string to load files from the filesystem.
	$username = $_SESSION['username'];
	if( !preg_match('/^[\w_\-]+$/', $username) ){
		echo "Invalid username";
		exit;
	}

	$full_path = sprintf("/home/Yong/users/%s/%s", $username, $filename);
	// Now we need to get the MIME type (e.g., image/jpeg).  PHP provides a neat little interface to do this called finfo.
	$finfo = new finfo(FILEINFO_MIME_TYPE);
	$mime = $finfo->file($full_path);
	ob_clean();
	// Finally, set the Content-Type header to the MIME type of the file, and display the file.
	header("Content-Type: ".$mime);
    header('Content-Disposition: attachment; filename="'.$filename.'";');
	readfile($full_path);
}

?>