<?php

define('BASE_URL', '/Dibassories');
define('ASSETS_DIR', BASE_URL . '/assets');

// Database enumerations
define('ROLE_CUSTOMER', 10);
define('ROLE_SELLER', 20);
define('ROLE_ADMIN', 30);

define('STATUS_OK', 0);
define('STATUS_SUSPENDED', 1);
define('STATUS_REMOVED', 2);
define('STATUS_NOT_PAID', 3);
define('STATUS_PAID', 4);
define('STATUS_OPENED', 5);
define('STATUS_CONFIRM', 6);
define('STATUS_SEND', 7);
define('STATUS_CLOSED', 8);

define('PRODUCT_TYPE_RING', 0);
define('PRODUCT_TYPE_NECKLACE', 1);
define('PRODUCT_TYPE_EARRING', 2);

define('TRANSACTION_TYPE_BUY', 0);
define('TRANSACTION_TYPE_CHARGE', 1);
define('TRANSACTION_TYPE_EXCHANGE', 2);

// Cookies data
define('COOKIE_JWT_NAME', 'DIBAS_TK');

?>
