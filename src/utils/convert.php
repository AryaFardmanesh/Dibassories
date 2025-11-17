<?php

function convertPriceToReadableFormat(int $amount): string {
	$amount = "" . $amount;
	$amount = strrev($amount);

	$seg = str_split($amount, 3);
	$segCount = count($seg);

	$result = "";

	for ($i = ($segCount - 1); $i >= 0; $i--) {
		$result .= strrev($seg[$i]);

		if ($i != 0) {
			$result .= ",";
		}
	}

	return $result;
}

function convertRolesToString(int $role): string {
	switch ( $role ) {
		case ROLE_CUSTOMER:
			return "مشتری";
		case ROLE_SELLER:
			return "فروشنده";
		case ROLE_ADMIN:
			return "مدیر";
		default:
			return "نامشخص";
	}
}

?>
