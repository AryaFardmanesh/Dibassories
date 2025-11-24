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
		array $sizes,
		string $name,
		string $description,
		array $images,
		int $count,
		int $price,
		int $offer
	): ?ProductModel {
		if (!ProductRepository::dbConnect()) {
			goto failed;
		}

		$model = new ProductModel(
			uuid(),
			$owner,
			$type,
			$name,
			$description,
			$images,
			$count,
			$price,
			$offer
		);

		if ($model->hasError()) {
			ProductRepository::setError($model->getError());
			goto failed;
		}

		// Extract model data
		$id = $model->id;
		$owner = $model->owner;
		$type = $model->type;
		$name = $model->name;
		$description = $model->description;
		$image = join("|", $model->image);
		$count = $model->count;
		$price = $model->price;
		$offer = $model->offer;
		$status = $model->status;

		// Insert new record
		Database::query(
			"INSERT INTO `dibas_products` (
				`id`,
				`owner`,
				`type`,
				`name`,
				`description`,
				`image`,
				`count`,
				`price`,
				`offer`,
				`status`,
				`created_at`
			) VALUES (
				'$id',
				'$owner',
				$type,
				'$name',
				'$description',
				'$image',
				$count,
				$price,
				$offer,
				$status,
				CURRENT_TIMESTAMP()
			);"
		);

		if (Database::hasError()) {
			ProductRepository::setError(Database::getError());
			goto failed;
		}

		// Insert new record for color
		foreach ($colors as $color) {
			$idColor = uuid();
			$colorName = $color[0];
			$colorHex = $color[1];

			Database::query(
				"INSERT INTO `dibas_products_color` (
					`id`,
					`product`,
					`color_name`,
					`color_hex`
				) VALUES (
					'$idColor',
					'$id',
					'$colorName',
					'$colorHex'
				);"
			);

			if (Database::hasError()) {
				ProductRepository::setError(Database::getError());
				goto failed;
			}
		}

		// Insert new record for material
		foreach ($materials as $material) {
			$idMaterial = uuid();

			Database::query(
				"INSERT INTO `dibas_products_material` (
					`id`,
					`product`,
					`material`
				) VALUES (
					'$idMaterial',
					'$id',
					'$material'
				);"
			);

			if (Database::hasError()) {
				ProductRepository::setError(Database::getError());
				goto failed;
			}
		}

		// Insert new record for size
		foreach ($sizes as $size) {
			$idSize = uuid();

			Database::query(
				"INSERT INTO `dibas_products_size` (
					`id`,
					`product`,
					`size`
				) VALUES (
					'$idSize',
					'$id',
					'$size'
				);"
			);

			if (Database::hasError()) {
				ProductRepository::setError(Database::getError());
				goto failed;
			}
		}

		Database::close();
		return $model;

		failed:
			Database::close();
			return null;
	}

	final public static function remove(string $id): bool {
		throw new \Exception("Not yet implemented.");
	}

	final public static function removeColor(string $id): bool {
		throw new \Exception("Not yet implemented.");
	}

	final public static function removeMaterial(string $id): bool {
		throw new \Exception("Not yet implemented.");
	}

	final public static function removeSize(string $id): bool {
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

	private static function find(string $field, string $value): ?ProductModel {
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
