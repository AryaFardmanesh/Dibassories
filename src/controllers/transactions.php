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
	// ...
}elseif ($req === CONTROLLER_TRANSACTION_EXCHANGE) {
	// ...
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
