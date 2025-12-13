<?php

include_once __DIR__ . "/../src/config.php";
include_once __DIR__ . "/../src/services/accounts.php";
include_once __DIR__ . "/../src/controllers/controller.php";
include_once __DIR__ . "/../src/utils/cookie.php";

if (!AccountService::isLogin()) {
	Controller::redirect(null);
}

Cookie::remove(COOKIE_JWT_NAME);
Controller::redirect(null);

?>
