<?php

include_once __DIR__ . "/../config.php";
include_once __DIR__ . "/repository.php";
include_once __DIR__ . "/../models/orders.php";
include_once __DIR__ . "/../utils/uuid.php";

class CartSessionModelRepository extends BaseRepository {
	final public static function create(): OrderModel|null {
		throw new \Exception("Not yet implemented.");
	}

	final public static function remove(): OrderModel|null {
		throw new \Exception("Not yet implemented.");
	}

	final public static function updateStatus(): bool {
		throw new \Exception("Not yet implemented.");
	}

	final public static function find(): array {
		throw new \Exception("Not yet implemented.");
	}
}

?>
