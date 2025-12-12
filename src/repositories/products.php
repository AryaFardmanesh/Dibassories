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

		if (Database::hasError()) {
			ProductRepository::setError(Database::getError());
			goto failed;
		}

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

			if (Database::hasError()) {
				ProductRepository::setError(Database::getError());
				goto failed;
			}
		}

		Database::close();
		return true;

		failed:
			Database::close();
			return false;
	}

	private static function removeAssoc(string $table, string $field, string $value): bool {
		if (!ProductRepository::dbConnect()) {
			goto failed;
		}

		Database::query(
			"DELETE FROM `dibas_products_$table` WHERE `dibas_products_$table`.`$field` = '$value';"
		);

		if (Database::hasError()) {
			ProductRepository::setError(Database::getError());
			goto failed;
		}

		Database::close();
		return true;

		failed:
			Database::close();
			return false;
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

		if (Database::hasError()) {
			ProductRepository::setError(Database::getError());
			goto failed;
		}

		Database::close();
		return $model;

		failed:
			Database::close();
			return null;
	}

	final public static function updateCount(string $id, int|string $newCount): bool {
		if (!ProductRepository::dbConnect()) {
			goto failed;
		}

		// Update the record
		Database::query(
			"UPDATE `dibas_products`
			SET
				`count` = $newCount
			WHERE `dibas_products`.`id` = '$id';"
		);

		if (Database::hasError()) {
			ProductRepository::setError(Database::getError());
			goto failed;
		}

		Database::close();
		return true;

		failed:
			Database::close();
			return false;
	}

	final public static function updateStatus(string $id, int $newStatus): bool {
		if (!ProductRepository::dbConnect()) {
			goto failed;
		}

		// Update the record
		Database::query(
			"UPDATE `dibas_products`
			SET
				`status` = $newStatus
			WHERE `dibas_products`.`id` = '$id';"
		);

		if (Database::hasError()) {
			ProductRepository::setError(Database::getError());
			goto failed;
		}

		Database::close();
		return true;

		failed:
			Database::close();
			return false;
	}

	final public static function updateColor(string $id, string $name, string $hex): bool {
		if (!ProductRepository::dbConnect()) {
			goto failed;
		}

		Database::query(
			"UPDATE `dibas_products_color`
			SET
				`color_name` = '$name',
				`color_hex` = '$hex'
			WHERE `dibas_products_color`.`id` = '$id';"
		);

		if (Database::hasError()) {
			ProductRepository::setError(Database::getError());
			goto failed;
		}

		Database::close();
		return true;

		failed:
			Database::close();
			return false;
	}

	final public static function updateMaterial(string $id, string $value): bool {
		if (!ProductRepository::dbConnect()) {
			goto failed;
		}

		Database::query(
			"UPDATE `dibas_products_material`
			SET
				`material` = '$value'
			WHERE `dibas_products_material`.`id` = '$id';"
		);

		if (Database::hasError()) {
			ProductRepository::setError(Database::getError());
			goto failed;
		}

		Database::close();
		return true;

		failed:
			Database::close();
			return false;
	}

	final public static function updateSize(string $id, string $value): bool {
		if (!ProductRepository::dbConnect()) {
			goto failed;
		}

		Database::query(
			"UPDATE `dibas_products_size`
			SET
				`size` = '$value'
			WHERE `dibas_products_size`.`id` = '$id';"
		);

		if (Database::hasError()) {
			ProductRepository::setError(Database::getError());
			goto failed;
		}

		Database::close();
		return true;

		failed:
			Database::close();
			return false;
	}

	final public static function findForOwner(string $id): array {
		$models = [];

		if (!ProductRepository::dbConnect()) {
			goto out;
		}

		$rows = Database::query(
			"SELECT * FROM `dibas_products` WHERE `dibas_products`.`owner` = '$id';"
		)->fetchAll();

		if (Database::hasError()) {
			ProductRepository::setError(Database::getError());
			goto out;
		}

		if ($rows === FALSE) {
			goto out;
		}

		foreach ($rows as $row) {
			$model = new ProductModel(
				$row["id"],
				$row["owner"],
				(int)$row["type"],
				$row["name"],
				$row["description"],
				str_getcsv($row["image"], "|"),
				(int)$row["count"],
				(int)$row["price"],
				(int)$row["offer"],
				(int)$row["status"],
				new DateTimeImmutable($row["created_at"])
			);

			if ($model->hasError()) {
				ProductRepository::setError($model->getError());
				goto out;
			}

			array_push($models, $model);
		}

		out:
			Database::close();
			return $models;
	}

	private static function find(string $field, string $value): ?ProductModel {
		if (!ProductRepository::dbConnect()) {
			goto failed;
		}

		$row = Database::query(
			"SELECT * FROM `dibas_products` WHERE `dibas_products`.`$field` = '$value';"
		)->fetch();

		if (Database::hasError()) {
			ProductRepository::setError(Database::getError());
			goto failed;
		}

		if ($row === FALSE) {
			goto failed;
		}

		$model = new ProductModel(
			$row["id"],
			$row["owner"],
			(int)$row["type"],
			$row["name"],
			$row["description"],
			str_getcsv($row["image"], "|"),
			(int)$row["count"],
			(int)$row["price"],
			(int)$row["offer"],
			(int)$row["status"],
			new DateTimeImmutable($row["created_at"])
		);

		if ($model->hasError()) {
			ProductRepository::setError($model->getError());
			goto failed;
		}

		Database::close();
		return $model;

		failed:
			Database::close();
			return null;
	}

	final public static function findById(string $id): ?ProductModel {
		return ProductRepository::find("id", $id);
	}

	final public static function findBySlug(string $slug): ?ProductModel {
		return ProductRepository::find("name", $slug);
	}

	final public static function findColors(string $id): array {
		$models = [];

		if (!ProductRepository::dbConnect()) {
			goto out;
		}

		$rows = Database::query(
			"SELECT * FROM `dibas_products_color` WHERE `dibas_products_color`.`product` = '$id';"
		)->fetchAll();

		if (Database::hasError()) {
			ProductRepository::setError(Database::getError());
			goto out;
		}

		if ($rows === FALSE) {
			goto out;
		}

		foreach ($rows as $row) {
			$model = new ProductColorModel(
				$row["id"],
				$row["product"],
				$row["color_name"],
				$row["color_hex"]
			);

			if ($model->hasError()) {
				ProductRepository::setError($model->getError());
				goto out;
			}

			array_push($models, $model);
		}

		out:
			Database::close();
			return $models;
	}

	final public static function findColor(string $id): ProductColorModel|null {
		$models = [];

		if (!ProductRepository::dbConnect()) {
			goto out;
		}

		$row = Database::query(
			"SELECT * FROM `dibas_products_color` WHERE `dibas_products_color`.`id` = '$id';"
		)->fetch();

		if (Database::hasError()) {
			ProductRepository::setError(Database::getError());
			goto out;
		}

		$model = new ProductColorModel(
			$row["id"],
			$row["product"],
			$row["color_name"],
			$row["color_hex"]
		);

		if ($model->hasError()) {
			ProductRepository::setError($model->getError());
			goto out;
		}

		out:
			Database::close();
			return $model;
	}

	final public static function findMaterials(string $id): array {
		$models = [];

		if (!ProductRepository::dbConnect()) {
			goto out;
		}

		$rows = Database::query(
			"SELECT * FROM `dibas_products_material` WHERE `dibas_products_material`.`product` = '$id';"
		)->fetchAll();

		if (Database::hasError()) {
			ProductRepository::setError(Database::getError());
			goto out;
		}

		if ($rows === FALSE) {
			goto out;
		}

		foreach ($rows as $row) {
			$model = new ProductMaterialModel(
				$row["id"],
				$row["product"],
				$row["material"]
			);

			if ($model->hasError()) {
				ProductRepository::setError($model->getError());
				goto out;
			}

			array_push($models, $model);
		}

		out:
			Database::close();
			return $models;
	}

	final public static function findMaterial(string $id): ProductMaterialModel|null {
		$models = [];

		if (!ProductRepository::dbConnect()) {
			goto out;
		}

		$row = Database::query(
			"SELECT * FROM `dibas_products_material` WHERE `dibas_products_material`.`id` = '$id';"
		)->fetch();

		if (Database::hasError()) {
			ProductRepository::setError(Database::getError());
			goto out;
		}

		$model = new ProductMaterialModel(
			$row["id"],
			$row["product"],
			$row["material"]
		);

		if ($model->hasError()) {
			ProductRepository::setError($model->getError());
			goto out;
		}

		out:
			Database::close();
			return $model;
	}

	final public static function findSizes(string $id): array {
		$models = [];

		if (!ProductRepository::dbConnect()) {
			goto out;
		}

		$rows = Database::query(
			"SELECT * FROM `dibas_products_size` WHERE `dibas_products_size`.`product` = '$id';"
		)->fetchAll();

		if (Database::hasError()) {
			ProductRepository::setError(Database::getError());
			goto out;
		}

		if ($rows === FALSE) {
			goto out;
		}

		foreach ($rows as $row) {
			$model = new ProductSizeModel(
				$row["id"],
				$row["product"],
				$row["size"]
			);

			if ($model->hasError()) {
				ProductRepository::setError($model->getError());
				goto out;
			}

			array_push($models, $model);
		}

		out:
			Database::close();
			return $models;
	}

	final public static function findSize(string $id): ProductSizeModel|null {
		$models = [];

		if (!ProductRepository::dbConnect()) {
			goto out;
		}

		$row = Database::query(
			"SELECT * FROM `dibas_products_size` WHERE `dibas_products_size`.`id` = '$id';"
		)->fetch();

		if (Database::hasError()) {
			ProductRepository::setError(Database::getError());
			goto out;
		}

		$model = new ProductSizeModel(
			$row["id"],
			$row["product"],
			$row["size"]
		);

		if ($model->hasError()) {
			ProductRepository::setError($model->getError());
			goto out;
		}

		out:
			Database::close();
			return $model;
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
		$models = [];

		if (!ProductRepository::dbConnect()) {
			goto out;
		}

		$offset = ($page - 1) * $limit;
		$sqlCondition = [];
		$sqlConditionStr = "";

		if ($name !== null) {
			array_push($sqlCondition, "`dibas_products`.`name` LIKE '$name'");
		}
		if ($type !== null) {
			array_push($sqlCondition, "`dibas_products`.`type` = $type");
		}
		if ($minPrice !== null && $maxPrice !== null) {
			array_push($sqlCondition, "`dibas_products`.`price` BETWEEN $minPrice AND $maxPrice");
		}elseif ($minPrice !== null) {
			array_push($sqlCondition, "`dibas_products`.`price` > $minPrice");
		}elseif ($maxPrice !== null) {
			array_push($sqlCondition, "`dibas_products`.`price` < $maxPrice");
		}

		$sqlConditionCount = count($sqlCondition);
		if ($sqlConditionCount) {
			$sqlConditionStr = "WHERE ";
		}

		for ($i = 0; $i < $sqlConditionCount; $i++) {
			$sqlConditionStr .= $sqlCondition[$i];

			if ($i + 1 < $sqlConditionCount) {
				$sqlConditionStr .= " AND ";
			}
		}

		$sortField = "created_at";
		$arrow = "DESC";

		if ($sort === SORT_CHEAPEST) {
			$sortField = "price";
			$arrow = "ASC";
		}elseif ($sort === SORT_EXPENSIVE) {
			$sortField = "price";
			$arrow = "DESC";
		}elseif ($sort === SORT_MOST_OFFER) {
			$sortField = "offer";
			$arrow = "DESC";
		}

		$rows = Database::query(
			"SELECT * FROM `dibas_products`
			$sqlConditionStr
			ORDER BY `dibas_products`.`$sortField` $arrow
			LIMIT $limit OFFSET $offset;"
		)->fetchAll();

		if (Database::hasError()) {
			ProductRepository::setError(Database::getError());
			goto out;
		}

		if ($rows === FALSE) {
			goto out;
		}

		foreach ($rows as $row) {
			$model = new ProductModel(
				$row["id"],
				$row["owner"],
				(int)$row["type"],
				$row["name"],
				$row["description"],
				str_getcsv($row["image"], "|"),
				(int)$row["count"],
				(int)$row["price"],
				(int)$row["offer"],
				(int)$row["status"],
				new DateTimeImmutable($row["created_at"])
			);

			if ($model->hasError()) {
				ProductRepository::setError($model->getError());
				goto out;
			}

			array_push($models, $model);
		}

		out:
			Database::close();
			return $models;
	}

	final public static function getPageCount(
		int $limit = PAGINATION_LIMIT,
		string|null $name = null,
		int|null $type = null,
		int|null $minPrice = null,
		int|null $maxPrice = null
	): int {
		$count = 0;

		if (!ProductRepository::dbConnect()) {
			goto out;
		}

		$sqlCondition = [];
		$sqlConditionStr = "";

		if ($name !== null) {
			array_push($sqlCondition, "`dibas_products`.`name` LIKE '$name'");
		}
		if ($type !== null) {
			array_push($sqlCondition, "`dibas_products`.`type` = $type");
		}
		if ($minPrice !== null && $maxPrice !== null) {
			array_push($sqlCondition, "`dibas_products`.`price` BETWEEN $minPrice AND $maxPrice");
		}elseif ($minPrice !== null) {
			array_push($sqlCondition, "`dibas_products`.`price` > $minPrice");
		}elseif ($maxPrice !== null) {
			array_push($sqlCondition, "`dibas_products`.`price` < $maxPrice");
		}

		$sqlConditionCount = count($sqlCondition);
		if ($sqlConditionCount) {
			$sqlConditionStr = "WHERE ";
		}

		for ($i = 0; $i < $sqlConditionCount; $i++) {
			$sqlConditionStr .= $sqlCondition[$i];

			if ($i + 1 < $sqlConditionCount) {
				$sqlConditionStr .= " AND ";
			}
		}

		$count = Database::query(
			"SELECT COUNT(*) as 'total' FROM `dibas_products`
			$sqlConditionStr;"
		);
		$count = (int)$count->fetch()["total"];

		if (Database::hasError()) {
			ProductRepository::setError(Database::getError());
			goto out;
		}

		out:
			Database::close();
			if ($count < $limit) $count = 1;
			else $count = (int)ceil($count / $limit);
			return $count;
	}
}

?>
