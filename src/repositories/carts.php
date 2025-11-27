<?php

include_once __DIR__ . "/repository.php";
include_once __DIR__ . "/../models/carts.php";
include_once __DIR__ . "/../utils/uuid.php";

class ShoppingCartRepository extends BaseRepository {
	final public static function add(
		string $owner,
		string $product,
		string $color,
		string $size,
		string $material,
		int $count
	): ?ShoppingCartModel {
		throw new \Exception("Not yet implemented.");
	}

	final public static function remove(string $owner, string $productId): bool {
		throw new \Exception("Not yet implemented.");
	}

	final public static function removeAll(string $owner): bool {
		throw new \Exception("Not yet implemented.");
	}

	final public static function find(string $owner): array {
		throw new \Exception("Not yet implemented.");
	}
}

?>
