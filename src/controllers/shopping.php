<?php

include_once __DIR__ . "/controller.php";
include_once __DIR__ . "/../repositories/accounts.php";
include_once __DIR__ . "/../repositories/orders.php";
include_once __DIR__ . "/../repositories/sessions.php";

$req = (int)Controller::getRequest(CONTROLLER_REQ_NAME, true);
$user = Controller::getRequest("user", true);

$account = AccountRepository::findById($user);

if (AccountRepository::hasError()) {
	Controller::setError(AccountRepository::getError());
	goto out;
}

if ($account === null) {
	Controller::setError("کاربر یافت نشد.");
	goto out;
}

if ($req === CONTROLLER_ORDER_PURCHE) {
	// ...
}

out:
Controller::redirect(Controller::getRequest("redirect"));

?>
