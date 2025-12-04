<?php

include_once __DIR__ . "/controller.php";
include_once __DIR__ . "/../repositories/accounts.php";
include_once __DIR__ . "/../repositories/carts.php";

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

if ($req === CONTROLLER_CART_ADD_CART) {
	// ...
}elseif ($req === CONTROLLER_CART_REMOVE_CART) {
	// ....
}elseif ($req === CONTROLLER_CART_EMPTY_CART) {
	// ....
}elseif ($req === CONTROLLER_CART_INC_PRODUCT_COUNT) {
	// ....
}elseif ($req === CONTROLLER_CART_DEC_PRODUCT_COUNT) {
	// ....
}

out:
Controller::redirect(Controller::getRequest("redirect"));

?>
