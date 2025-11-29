<?php

include_once __DIR__ . "/service.php";
include_once __DIR__ . "/../repositories/products.php";
include_once __DIR__ . "/../config.php";

class ProductService extends BaseService {
	final public static function find(string $id): ProductDetailModel|null {
		throw new \Exception("Not implemented yet.");
	}

	final public static function findAll(
		int $page = 1,
		int $sort = SORT_NEWEST,
		string|null $name = null,
		int|null $type = null,
		int|null $minPrice = null,
		int|null $maxPrice = null
	): array {
		throw new \Exception("Not implemented yet.");
	}
}

?>
