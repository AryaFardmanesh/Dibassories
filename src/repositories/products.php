<?php

include_once __DIR__ . "/../config.php";
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

	final public static function update(ProductModel $model): bool {
		throw new \Exception("Not yet implemented.");
	}

	final public static function updateCount(int|string $newCount): bool {
		throw new \Exception("Not yet implemented.");
	}

	final public static function updateStatus(int $newStatus): bool {
		throw new \Exception("Not yet implemented.");
	}

	final public static function updateColors(array $colors): bool {
		throw new \Exception("Not yet implemented.");
	}

	final public static function updateMaterials(array $materials): bool {
		throw new \Exception("Not yet implemented.");
	}

	final public static function updateSizes(array $sizes): bool {
		throw new \Exception("Not yet implemented.");
	}

	final private static function find(string $field, string $value): ?ProductModel {
		throw new \Exception("Not yet implemented.");
	}

	final public static function findById(string $id): ?ProductModel {
		throw new \Exception("Not yet implemented.");
	}

	final public static function findBySlug(string $slug): ?ProductModel {
		throw new \Exception("Not yet implemented.");
	}

	final public static function findColors(string $id): array {
		throw new \Exception("Not yet implemented.");
	}

	final public static function findMaterials(string $id): array {
		throw new \Exception("Not yet implemented.");
	}

	final public static function findSizes(string $id): array {
		throw new \Exception("Not yet implemented.");
	}

	final public static function filter(
		int $page = 1,
		int $limit = PAGINATION_LIMIT,
		int $sort = SORT_NEWEST,
		string|null $name = null,
		int|null $type = null,
		int|null $minPrice = null,
		int|null $maxPrice = null
	): array {
		throw new \Exception("Not yet implemented.");
	}

	final public static function getPageCount(
		int $limit = PAGINATION_LIMIT,
		string|null $name = null,
		int|null $type = null,
		int|null $minPrice = null,
		int|null $maxPrice = null
	): array {
		throw new \Exception("Not yet implemented.");
	}
}

?>
