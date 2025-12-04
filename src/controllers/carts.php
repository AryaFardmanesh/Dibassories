<?php

include_once __DIR__ . "/controller.php";
include_once __DIR__ . "/../repositories/accounts.php";
include_once __DIR__ . "/../repositories/carts.php";
include_once __DIR__ . "/../repositories/products.php";

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
	$productId = Controller::getRequest("product", true);
	$colorId = Controller::getRequest("color", true);
	$materialId = Controller::getRequest("material", true);
	$sizeId = Controller::getRequest("size", true);
	$count = (int)Controller::getRequest("count", true);

	$product = ProductRepository::findById($productId);

	if (ProductRepository::hasError()) {
		Controller::setError(ProductRepository::getError());
		goto out;
	}

	if ($product->owner !== $user || $account->role !== ROLE_ADMIN) {
		Controller::setError("شما مجوز ایجاد تغییر در سبد خرید این کاربر را ندارید.");
		goto out;
	}

	ShoppingCartRepository::add($user, $productId, $colorId, $sizeId, $materialId, $count);

	if (ShoppingCartRepository::hasError()) {
		Controller::setError(ShoppingCartRepository::getError());
		goto out;
	}
}elseif ($req === CONTROLLER_CART_REMOVE_CART) {
	$productId = Controller::getRequest("product", true);

	$product = ProductRepository::findById($productId);

	if (ProductRepository::hasError()) {
		Controller::setError(ProductRepository::getError());
		goto out;
	}

	if ($product->owner !== $user || $account->role !== ROLE_ADMIN) {
		Controller::setError("شما مجوز ایجاد تغییر در سبد خرید این کاربر را ندارید.");
		goto out;
	}

	ShoppingCartRepository::remove($user, $productId);

	if (ShoppingCartRepository::hasError()) {
		Controller::setError(ShoppingCartRepository::getError());
		goto out;
	}
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
