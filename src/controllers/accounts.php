<?php

include_once __DIR__ . "/controller.php";

$req = (int)Controller::getRequest(CONTROLLER_REQ_NAME);
$user = Controller::getRequest("user");

if ($req === CONTROLLER_ACCOUNT_UPDATE) {
	// ...
}elseif ($req === CONTROLLER_ACCOUNT_BLOCK) {
	// ...
}elseif ($req === CONTROLLER_ACCOUNT_UPGRADE) {
	// ...
}elseif ($req === CONTROLLER_ACCOUNT_DOWNGRADE) {
	// ...
}elseif ($req === CONTROLLER_ACCOUNT_SELLER_REQUEST) {
	// ...
}elseif ($req === CONTROLLER_ACCOUNT_SELLER_ACCEPT) {
	// ...
}elseif ($req === CONTROLLER_ACCOUNT_SELLER_REJECT) {
	// ...
}

Controller::redirect(Controller::getRequest("redirect"));

?>
