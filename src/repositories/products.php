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
		if (!ProductRepository::dbConnect()) {
			goto failed;
		}

		$row = Database::query(
			"SELECT `status` FROM `dibas_products`
			WHERE `dibas_products`.`id` = '$id';"
		)->fetch();

		if ($row === FALSE) {
			goto failed;
		}

		$status = $row["status"];

		if ($status === STATUS_REMOVED) {
			Database::query(
				"DELETE FROM `dibas_products` WHERE `dibas_products`.`id` = '$id';
				DELETE FROM `dibas_products_color` WHERE `dibas_products_color`.`product` = '$id';
				DELETE FROM `dibas_products_material` WHERE `dibas_products_material`.`product` = '$id';
				DELETE FROM `dibas_products_size` WHERE `dibas_products_size`.`product` = '$id';"
			);
		}else {
			$removedStatusCode = STATUS_REMOVED;
			Database::query(
				"UPDATE `dibas_products`
				SET `status` = $removedStatusCode
				WHERE `dibas_products`.`id` = '$id';"
			);
		}

		Database::close();
		return true;

		failed:
			Database::close();
			return false;
	}

	private static function removeAssoc(string $table, string $field, string $value): bool {
		if (!ProductRepository::dbConnect()) {
			Database::close();
			return false;
		}

		Database::query(
			"DELETE FROM `dibas_products_$table` WHERE `dibas_products_$table`.`$field` = '$value';"
		);

		Database::close();
		return true;
	}

	final public static function removeColor(string $id): bool {
		return ProductRepository::removeAssoc("color", "id", $id);
	}

	final public static function removeMaterial(string $id): bool {
		return ProductRepository::removeAssoc("material", "id", $id);
	}

	final public static function removeSize(string $id): bool {
		return ProductRepository::removeAssoc("size", "id", $id);
	}

	final public static function update(ProductModel $model): ?ProductModel {
		if ($model->hasError()) {
			ProductRepository::setError($model->getError());
			goto failed;
		}

		if (!ProductRepository::dbConnect()) {
			goto failed;
		}

		// Extract model data
		$id = $model->id;
		$type = $model->type;
		$name = $model->name;
		$description = $model->description;
		$image = join("|", $model->image);
		$count = $model->count;
		$price = $model->price;
		$offer = $model->offer;
		$status = $model->status;

		// Update the record
		Database::query(
			"UPDATE `dibas_products`
			SET
				`type` = '$type',
				`name` = '$name',
				`description` = '$description',
				`image` = '$image',
				`count` = $count,
				`price` = $price,
				`offer` = $offer,
				`status` = $status
			WHERE `dibas_products`.`id` = '$id';"
		);
		Database::close();
		return $model;

		failed:
			Database::close();
			return null;
	}

	final public static function updateCount(string $id, int|string $newCount): bool {
		if (!ProductRepository::dbConnect()) {
			Database::close();
			return false;
		}

		// Update the record
		Database::query(
			"UPDATE `dibas_products`
			SET
				`count` = $newCount
			WHERE `dibas_products`.`id` = '$id';"
		);

		Database::close();
		return true;
	}

	final public static function updateStatus(string $id, int $newStatus): bool {
		if (!ProductRepository::dbConnect()) {
			Database::close();
			return false;
		}

		// Update the record
		Database::query(
			"UPDATE `dibas_products`
			SET
				`status` = $newStatus
			WHERE `dibas_products`.`id` = '$id';"
		);

		Database::close();
		return true;
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
