<?php

include_once __DIR__ . "/controller.php";
include_once __DIR__ . "/../repositories/accounts.php";
include_once __DIR__ . "/../repositories/orders.php";
include_once __DIR__ . "/../repositories/products.php";

$req = (int)Controller::getRequest(CONTROLLER_REQ_NAME, true);
$user = Controller::getRequest("user", true);
$order = Controller::getRequest("order", true);

$account = AccountRepository::findById($user);

if (AccountRepository::hasError()) {
	Controller::setError(AccountRepository::getError());
	goto out;
}

if ($account === null) {
	Controller::setError("کاربر یافت نشد.");
	goto out;
}

$orderModel = OrderRepository::findById($order);

if (OrderRepository::hasError()) {
	Controller::setError(OrderRepository::getError());
	goto out;
}

if ($orderModel === null) {
	Controller::setError("سفارش یافت نشد.");
	goto out;
}

permissionCheck($orderModel, $account);

if ($req === CONTROLLER_ORDER_STATUS_CONFIRM) {
	OrderRepository::updateStatus($order, STATUS_CONFIRM);
}elseif ($req === CONTROLLER_ORDER_STATUS_OPEN) {
	OrderRepository::updateStatus($order, STATUS_OPENED);
}elseif ($req === CONTROLLER_ORDER_STATUS_CLOSE) {
	OrderRepository::updateStatus($order, STATUS_CLOSED);
}elseif ($req === CONTROLLER_ORDER_STATUS_SENT) {
	OrderRepository::updateStatus($order, STATUS_SEND);
}

out:
Controller::redirect(Controller::getRequest("redirect"));

function permissionCheck(OrderModel $order, AccountModel $account) {
	if ($order->provider !== $account->id && $account->role === ROLE_CUSTOMER) {
		Controller::setError("شما مجاز به ویرایش این سفارش نیستید.");
		Controller::redirect(Controller::getRequest("redirect"));
	}
}

?>
