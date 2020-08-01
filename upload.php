<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
	header('location: index.php');
}
	require_once 'DB.php';
	$fileName = $_FILES["fl_upload"]["name"]; // The file name
	$fileTmpLoc = $_FILES["fl_upload"]["tmp_name"]; // File in the PHP tmp folder
	$fileType = $_FILES["fl_upload"]["type"]; // The type of file it is
	$fileSize = round($_FILES["fl_upload"]["size"] / 1024) . 'KB'; // File size in bytes
	$fileErrorMsg = $_FILES["fl_upload"]["error"]; // 0 for false... and 1 for true
	if (!$fileTmpLoc) { // if file not chosen
	    echo "ERROR: Please browse for a file before clicking the upload button.";
	    exit();
	}
	if(move_uploaded_file($fileTmpLoc, "uploads/$fileName")){
		$uploadSql = $con->query("INSERT INTO files (name, size, date) VALUES('$fileName', '$fileSize', now())");
	    echo "upload_success";
	} else {
	    echo "move_uploaded_file function failed";
	}
?>