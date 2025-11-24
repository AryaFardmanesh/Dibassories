<?php

include_once __DIR__ . "/repository.php";
include_once __DIR__ . "/../models/products.php";
include_once __DIR__ . "/../utils/uuid.php";
include_once __DIR__ . "/../utils/sanitizer.php";

class ProductRepository extends BaseRepository {
	public static function create(
		string $owner,
		int $type,
		string $name,
		string $description,
		array $images,
		int $count,
		int $price,
		int $offer
	): void {
		throw new \Exception("Not yet implemented.");
	}
}

?>
