<?php

include_once __DIR__ . "/../config.php";

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
