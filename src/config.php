<?php

// Global
define('BASE_URL', '/Dibassories');
define('ASSETS_DIR', BASE_URL . '/assets');

// Database config
define('DB_SERVERNAME', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'dibassories');

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
define('COOKIE_EXP_TIME', (86400 * 30) /* 86400 = 1 Day - 30 Days */);

// Uploader Config
define('LIMIT_FILE_SIZE', 2000000);
define('PRODUCT_IMAGE_DIR', BASE_URL . '/assets/img/products');

define('FILE_STATUS_NOT_FOUND', 1);
define('FILE_STATUS_ALREADY_EXISTS', 2);
define('FILE_STATUS_LARGE_SIZE', 3);
define('FILE_STATUS_INVALID_SUFFIX', 4);
define('FILE_STATUS_FAILED', 5);

// Pagination Config
define('PAGINATION_LIMIT', 10);

// Sort Config
define('SORT_NEWEST', 0);
define('SORT_CHEAPEST', 2);
define('SORT_EXPENSIVE', 2);
define('SORT_MOST_OFFER', 3);

// Search Price Config
define('DEFAULT_MIN_PRICE', 0);
define('DEFAULT_MAX_PRICE', PHP_INT_MAX);

// Controller Config
define('CONTROLLER_REQ_NAME', 'req');
define('CONTROLLER_REDIRECT_URL', BASE_URL . "/");

/*
	Numbers must start at one because incorrect
	data will be converted to zero and will cause
	an error if the code is 0.
*/
define('CONTROLLER_ACCOUNT_UPDATE', 1);
define('CONTROLLER_ACCOUNT_BLOCK', 2);
define('CONTROLLER_ACCOUNT_REMOVE', 3);
define('CONTROLLER_ACCOUNT_UPGRADE', 4);
define('CONTROLLER_ACCOUNT_DOWNGRADE', 5);
define('CONTROLLER_ACCOUNT_SELLER_REQUEST', 6);
define('CONTROLLER_ACCOUNT_SELLER_ACCEPT', 7);
define('CONTROLLER_ACCOUNT_SELLER_REJECT', 8);

define('CONTROLLER_PRODUCT_ADD', 1);
define('CONTROLLER_PRODUCT_UPDATE', 2);
define('CONTROLLER_PRODUCT_SUSPEND', 3);
define('CONTROLLER_PRODUCT_REMOVE', 4);
define('CONTROLLER_PRODUCT_RESTORE', 5);
define('CONTROLLER_PRODUCT_ACCEPT', 6);
define('CONTROLLER_PRODUCT_REJECT', 7);
define('CONTROLLER_PRODUCT_INC', 8);
define('CONTROLLER_PRODUCT_DEC', 9);

define('CONTROLLER_PRODUCT_LIMIT_COLOR_COUNT', 10);
define('CONTROLLER_PRODUCT_LIMIT_MATERIAL_COUNT', 10);
define('CONTROLLER_PRODUCT_LIMIT_SIZE_COUNT', 10);

define('CONTROLLER_CART_ADD_CART', 1);
define('CONTROLLER_CART_REMOVE_CART', 2);
define('CONTROLLER_CART_EMPTY_CART', 3);
define('CONTROLLER_CART_INC_PRODUCT_COUNT', 4);
define('CONTROLLER_CART_DEC_PRODUCT_COUNT', 5);

define('CONTROLLER_TRANSACTION_CHARGE', 1);
define('CONTROLLER_TRANSACTION_EXCHANGE', 2);
define('CONTROLLER_TRANSACTION_REMOVE', 3);
define('CONTROLLER_TRANSACTION_OPEN', 4);
define('CONTROLLER_TRANSACTION_CLOSE', 5);
define('CONTROLLER_TRANSACTION_STATUS_PAIED', 6);
define('CONTROLLER_TRANSACTION_STATUS_NOT_PAIED', 7);
define('CONTROLLER_TRANSACTION_STATUS_SUSPENDED', 8);
define('CONTROLLER_TRANSACTION_STATUS_OK', 9);

?>
