<?php

include_once __DIR__ . "/../config.php";

function uploadFile(string $name, string $address, bool $removeOldFile = false, string $oldPath = ""): string|int {
	if (!isset($_FILES[$name]) || $_FILES[$name]["size"] == 0) {
		return FILE_STATUS_NOT_FOUND;
	}

	$file = $_FILES[$name];
	$fileSuffix = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
	$newFilename = time() . rand(1000, 9999) . "." . $fileSuffix;
	$newFilename = $address . "/" . $newFilename;

	if (file_exists($newFilename)) {
		return FILE_STATUS_ALREADY_EXISTS;
	}

	if ($file["size"] > LIMIT_FILE_SIZE) {
		return FILE_STATUS_LARGE_SIZE;
	}

	if ($fileSuffix != "png" && $fileSuffix != "jpg" && $fileSuffix != "jpeg") {
		return FILE_STATUS_INVALID_SUFFIX;
	}

	if (!move_uploaded_file($file["tmp_name"], $newFilename)) {
		return FILE_STATUS_FAILED;
	}

	if ($removeOldFile && file_exists($oldPath)) {
		unlink($oldPath);
	}

	return basename($newFilename);
}

function convertUploadErrorToString(int $error): string {
	switch ($error) {
		case FILE_STATUS_NOT_FOUND:
			return "فایل در درخواست تنظیم نشده است.";
		case FILE_STATUS_ALREADY_EXISTS:
			return "این فایل فایل قبلا آپلود شده است.";
		case FILE_STATUS_LARGE_SIZE:
			return "اندازه فایل بزرگ است.";
		case FILE_STATUS_INVALID_SUFFIX:
			return "این فایل قابل آپلود نیست.";
		case FILE_STATUS_FAILED:
		default:
			return "فایل با موفقیت آپلود نشد.";
	}
}

?>
