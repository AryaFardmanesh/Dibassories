<?php

include_once __DIR__ . "/controller.php";
include_once __DIR__ . "/../repositories/products.php";
include_once __DIR__ . "/../repositories/accounts.php";

$req = (int)Controller::getRequest(CONTROLLER_REQ_NAME, true);
$owner = Controller::getRequest("owner", true);
$productId = Controller::getRequest("product");

$account = AccountRepository::findById($owner);

if (AccountRepository::hasError()) {
	Controller::setError(AccountRepository::getError());
	goto out;
}

if ($account === null) {
	Controller::setError("کاربر یافت نشد.");
	goto out;
}

if ($req === CONTROLLER_PRODUCT_ADD) {
	if ($account->role === ROLE_CUSTOMER) {
		Controller::setError("کاربر مجاز به ایجاد محصول نیست.");
		goto out;
	}

	$type = Controller::getRequest("type", true);
	$name = Controller::getRequest("name", true);
	$description = Controller::getRequest("description", true);
	$count = (int)Controller::getRequest("count", true);
	$price = (int)Controller::getRequest("price", true);
	$offer = (int)Controller::getRequest("offer", true);
	$images = Controller::fetchSerialized("image", 4);
	$colors = Controller::fetchSerialized("color", CONTROLLER_PRODUCT_LIMIT_COLOR_COUNT, true, ",");
	$materials = Controller::fetchSerialized("material", CONTROLLER_PRODUCT_LIMIT_MATERIAL_COUNT);
	$sizes = Controller::fetchSerialized("material", CONTROLLER_PRODUCT_LIMIT_SIZE_COUNT);

	ProductRepository::create(
		$owner,
		$type,
		$colors,
		$materials,
		$sizes,
		$name,
		$description,
		$images,
		$count,
		$price,
		$offer
	);

	if (ProductRepository::hasError()) {
		Controller::setError(ProductRepository::getError());
		goto out;
	}
}elseif ($req === CONTROLLER_PRODUCT_UPDATE) {
	// ...
}elseif ($req === CONTROLLER_PRODUCT_SUSPEND) {
	// ...
}elseif ($req === CONTROLLER_PRODUCT_REMOVE) {
	// ...
}elseif ($req === CONTROLLER_PRODUCT_RESTORE) {
	// ...
}elseif ($req === CONTROLLER_PRODUCT_ACCEPT) {
	// ...
}elseif ($req === CONTROLLER_PRODUCT_REJECT) {
	// ...
}elseif ($req === CONTROLLER_PRODUCT_INC) {
	// ...
}elseif ($req === CONTROLLER_PRODUCT_DEC) {
	// ...
}

out:
Controller::redirect(Controller::getRequest("redirect"));

?>
