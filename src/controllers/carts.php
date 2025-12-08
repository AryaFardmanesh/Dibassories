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

	ShoppingCartRepository::remove($user, $productId);

	if (ShoppingCartRepository::hasError()) {
		Controller::setError(ShoppingCartRepository::getError());
		goto out;
	}
}elseif ($req === CONTROLLER_CART_EMPTY_CART) {
	ShoppingCartRepository::removeAll($user);

	if (ShoppingCartRepository::hasError()) {
		Controller::setError(ShoppingCartRepository::getError());
		goto out;
	}
}elseif ($req === CONTROLLER_CART_INC_PRODUCT_COUNT) {
	$cart = Controller::getRequest("cart", true);
	$product = Controller::getRequest("product", true);

	$cart = ShoppingCartRepository::findById($cart);
	$product = ProductRepository::findById($product);

	if (ShoppingCartRepository::hasError()) {
		Controller::setError(ShoppingCartRepository::getError());
		goto out;
	}

	if (ProductRepository::hasError()) {
		Controller::setError(ProductRepository::getError());
		goto out;
	}

	if ($cart->count > ($product->count + 1)) {
		Controller::setError("تعداد محصول کمتر از درخواست شما است.");
		goto out;
	}

	ShoppingCartRepository::updateCount($cart->id, $cart->count + 1);

	if (ShoppingCartRepository::hasError()) {
		Controller::setError(ShoppingCartRepository::getError());
		goto out;
	}
}elseif ($req === CONTROLLER_CART_DEC_PRODUCT_COUNT) {
	$cart = Controller::getRequest("cart", true);
	$product = Controller::getRequest("product", true);

	$cart = ShoppingCartRepository::findById($cart);
	$product = ProductRepository::findById($product);

	if (ShoppingCartRepository::hasError()) {
		Controller::setError(ShoppingCartRepository::getError());
		goto out;
	}

	if (ProductRepository::hasError()) {
		Controller::setError(ProductRepository::getError());
		goto out;
	}

	if (($cart->count - 1) <= 0) {
		Controller::setError("تعداد درخواستی شما کمتر از یک است.");
		goto out;
	}

	ShoppingCartRepository::updateCount($cart->id, $cart->count - 1);

	if (ShoppingCartRepository::hasError()) {
		Controller::setError(ShoppingCartRepository::getError());
		goto out;
	}
}

out:
Controller::redirect(Controller::getRequest("redirect"));

?>
