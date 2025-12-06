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

function convertToEnglish(string $raw) {
	$newNumbers = range(0, 9);
	// 1. Persian HTML decimal
	$persianDecimal = array('&#1776;', '&#1777;', '&#1778;', '&#1779;', '&#1780;', '&#1781;', '&#1782;', '&#1783;', '&#1784;', '&#1785;');
	// 2. Arabic HTML decimal
	$arabicDecimal = array('&#1632;', '&#1633;', '&#1634;', '&#1635;', '&#1636;', '&#1637;', '&#1638;', '&#1639;', '&#1640;', '&#1641;');
	// 3. Arabic Numeric
	$arabic = array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩');
	// 4. Persian Numeric
	$persian = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');

	$raw =  str_replace($persianDecimal, $newNumbers, $raw);
	$raw =  str_replace($arabicDecimal, $newNumbers, $raw);
	$raw =  str_replace($arabic, $newNumbers, $raw);
	return str_replace($persian, $newNumbers, $raw);
}

?>
