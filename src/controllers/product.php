<?php

# Suspend Product
# Remove Product
# Restore Product
# Accept Product
# Reject Product
# Increment Product Count
# Decrement Product Count

include_once __DIR__ . "/controller.php";
include_once __DIR__ . "/../repositories/products.php";

$req = Controller::getRequest(CONTROLLER_REQ_NAME);
$productId = Controller::getRequest("product");

if ($req === null || $productId === null) {
	goto out;
}

if ($req === CONTROLLER_PRODUCT_ADD) {
	// ...
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
