<?php

include_once __DIR__ . "/../config.php";

/*
// Handle Image
$target_dir = "../assets/images/hotels/";
$target_filename = "hotel-" . count(glob($target_dir . "*")) + 1;
$target_file = $target_dir . $target_filename;
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
$needRemoveOldImg = false;

// Check if image file is a actual image or fake image
if(isset($_FILES["hotelImage"])) {
	$target_filename .= "." . pathinfo($_FILES["hotelImage"]["name"], PATHINFO_EXTENSION);
	$target_file .=  "." . pathinfo($_FILES["hotelImage"]["name"], PATHINFO_EXTENSION);
	$image = $target_filename;

	if ($action === "edit-hotel" && $_FILES["hotelImage"]["tmp_name"] === "") {
		$image = $hotelModel->image;
		goto hotel_service;
	}elseif ($action === "edit-hotel") {
		$target_filename = $hotelModel->image;
		$target_file = $target_dir . $target_filename;
		$image = $target_filename;
		$needRemoveOldImg = true;
	}

	if(!getimagesize($_FILES["hotelImage"]["tmp_name"])) {
		$uploadOk = 0;
	}
}else {
	$hotelFormError = "The hotel image was not uploaded.";
	goto view;
}

// Remove old image
if ($needRemoveOldImg) {
	unlink($target_dir . $hotelModel->image);
}

// Check if file already exists
if (file_exists($target_file)) {
	$uploadOk = 0;
	$hotelFormError = "File is exists in file system.";
}

// Check file size
if ($_FILES["hotelImage"]["size"] > 5000000) {
	$hotelFormError = "Sorry, your file is too large.";
	$uploadOk = 0;
}

// Allow certain file formats
$imageFileType = $_FILES["hotelImage"]["type"];
if($imageFileType != "image/jpg" && $imageFileType != "image/png" && $imageFileType != "image/jpeg" ) {
	$hotelFormError = "Sorry, only JPG, JPEG, PNG files are allowed.";
	$uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk !== 0 && !move_uploaded_file($_FILES["hotelImage"]["tmp_name"], $target_file)) {
	$hotelFormError = "Sorry, there was an error uploading your file.";
}
// Handle Image
*/

function uploadFile(string $name, string $address): string|int {
	if (!isset($_FILES[$name])) {
		return FILE_STATUS_NOT_FOUND;
	}

	$file = $_FILES[$name];
	$fileSuffix = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
	$newFilename = time() . rand(1000, 9999) . "." . $fileSuffix;

	if (file_exists($newFilename)) {
		return FILE_STATUS_ALREADY_EXISTS;
	}

	if ($file["size"] > LIMIT_FILE_SIZE) {
		return FILE_STATUS_LARGE_SIZE;
	}

	if ($fileSuffix != "png" && $fileSuffix != "jpg" && $fileSuffix != "jpeg") {
		return FILE_STATUS_INVALID_SUFFIX;
	}

	if (!move_uploaded_file($file["tmp_name"], $address . $newFilename)) {
		return FILE_STATUS_FAILED;
	}

	return $newFilename;
}

?>
