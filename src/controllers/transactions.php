<?php

include_once __DIR__ . "/controller.php";
include_once __DIR__ . "/../repositories/transactions.php";
include_once __DIR__ . "/../repositories/accounts.php";

$req = (int)Controller::getRequest(CONTROLLER_REQ_NAME, true);
$owner = Controller::getRequest("owner", true);

$account = AccountRepository::findById($owner);

if (AccountRepository::hasError()) {
	Controller::setError(AccountRepository::getError());
	goto out;
}

if ($account === null) {
	Controller::setError("کاربر یافت نشد.");
	goto out;
}

if ($req === CONTROLLER_TRANSACTION_CHARGE) {
	$amount = (int)Controller::getRequest("amount", true);
	$isTest = Controller::getRequest("tcode") === TRANSACTION_TEST_CODE ? true : false;

	if ($isTest) {
		TransactionRepository::create($owner, $amount, TRANSACTION_TYPE_CHARGE, STATUS_NOT_PAID);

		if (TransactionRepository::hasError()) {
			Controller::setError(TransactionRepository::getError());
			goto out;
		}

		goto out;
	}

	// Should be redirect to zarinpal payment gate.
}elseif ($req === CONTROLLER_TRANSACTION_EXCHANGE) {
	$amount = (int)Controller::getRequest("amount", true);

	TransactionRepository::create($owner, $amount, TRANSACTION_TYPE_EXCHANGE, STATUS_NOT_PAID);

	if (TransactionRepository::hasError()) {
		Controller::setError(TransactionRepository::getError());
		goto out;
	}
}elseif ($req === CONTROLLER_TRANSACTION_REMOVE) {
	// ...
}elseif ($req === CONTROLLER_TRANSACTION_OPEN) {
	// ...
}elseif ($req === CONTROLLER_TRANSACTION_CLOSE) {
	// ...
}elseif ($req === CONTROLLER_TRANSACTION_STATUS_PAIED) {
	// ...
}elseif ($req === CONTROLLER_TRANSACTION_STATUS_NOT_PAIED) {
	// ...
}elseif ($req === CONTROLLER_TRANSACTION_STATUS_SUSPENDED) {
	// ...
}elseif ($req === CONTROLLER_TRANSACTION_STATUS_OK) {
	// ...
}

out:
Controller::redirect(Controller::getRequest("redirect"));

?>
