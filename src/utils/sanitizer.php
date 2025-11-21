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

?>
