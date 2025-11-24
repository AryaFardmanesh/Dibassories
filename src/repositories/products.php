<?php

include_once __DIR__ . "/repository.php";
include_once __DIR__ . "/../models/products.php";
include_once __DIR__ . "/../utils/uuid.php";
include_once __DIR__ . "/../utils/sanitizer.php";

class ProductRepository extends BaseRepository {
	final public static function create(
		string $owner,
		int $type,
		array $colors,
		array $materials,
		array $size,
		string $name,
		string $description,
		array $images,
		int $count,
		int $price,
		int $offer
	): ProductModel {
		throw new \Exception("Not yet implemented.");
	}

	final public static function remove(string $id): bool {
		throw new \Exception("Not yet implemented.");
	}
}

?>
