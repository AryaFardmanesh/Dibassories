<?php

function testInput(string $data): string {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;	
}

function testEmail(string $email): bool {
	return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function dbFlatData(string|null $data): string {
	if ($data === null) {
		return "NULL";
	}
	return "'$data'";
}

?>
