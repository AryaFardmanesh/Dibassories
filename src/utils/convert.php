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
	switch ($role) {
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

function convertStatusToString(int $status): string {
	switch ($status) {
		case STATUS_OK:
			return "تایید";
		case STATUS_SUSPENDED:
			return "معلغ";
		case STATUS_REMOVED:
			return "حذف";
		case STATUS_NOT_PAID:
			return "پرداخت نشده";
		case STATUS_PAID:
			return "پرداخت شده";
		case STATUS_OPENED:
			return "باز";
		case STATUS_CONFIRM:
			return "تایید";
		case STATUS_SEND:
			return "ارسال شده";
		case STATUS_CLOSED:
			return "بسته";
		default:
			return "نامشخص";
	}
}

function convertProductTypesToString(int $types): string {
	switch ($types) {
		case PRODUCT_TYPE_RING:
			return "حلقه";
		case PRODUCT_TYPE_NECKLACE:
			return "گردنبند";
		case PRODUCT_TYPE_EARRING:
			return "گوشواره";
		default:
			return "نامشخص";
	}
}

function convertTransactionTypeToString(int $types): string {
	switch ($types) {
		case TRANSACTION_TYPE_BUY:
			return "خرید";
		case TRANSACTION_TYPE_CHARGE:
			return "شارژ";
		case TRANSACTION_TYPE_EXCHANGE:
			return "برداشت";
		default:
			return "نامشخص";
	}
}

?>
