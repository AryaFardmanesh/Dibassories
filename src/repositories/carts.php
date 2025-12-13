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
		$model = new ShoppingCartModel(
			uuid(),
			$owner,
			$product,
			$color,
			$size,
			$material,
			$count
		);

		if ($model->hasError()) {
			ShoppingCartRepository::setError($model->getError());
			goto failed;
		}

		if (!ShoppingCartRepository::dbConnect()) {
			goto failed;
		}

		$id = $model->id;

		Database::query(
			"INSERT INTO `dibas_shopping_carts` (
				`id`,
				`owner`,
				`product`,
				`product_color`,
				`product_size`,
				`product_material`,
				`count`,
				`created_at`
			) VALUES (
				'$id',
				'$owner',
				'$product',
				'$color',
				'$size',
				'$material',
				'$count',
				CURRENT_TIMESTAMP()
			);"
		);

		if (Database::hasError()) {
			ShoppingCartRepository::setError(Database::getError());
			goto failed;
		}

		Database::close();
		return $model;

		failed:
			Database::close();
			return null;
	}

	final public static function remove(string $owner, string $productId): bool {
		if (!ShoppingCartRepository::dbConnect()) {
			goto failed;
		}

		Database::query(
			"DELETE FROM `dibas_shopping_carts`
			WHERE `dibas_shopping_carts`.`owner` = '$owner'
			AND `dibas_shopping_carts`.`product` = '$productId';"
		);

		if (Database::hasError()) {
			ShoppingCartRepository::setError(Database::getError());
			goto failed;
		}

		Database::close();
		return true;

		failed:
			Database::close();
			return false;
	}

	final public static function removeAll(string $owner): bool {
		if (!ShoppingCartRepository::dbConnect()) {
			goto failed;
		}

		Database::query(
			"DELETE FROM `dibas_shopping_carts`
			WHERE `dibas_shopping_carts`.`owner` = '$owner';"
		);

		if (Database::hasError()) {
			ShoppingCartRepository::setError(Database::getError());
			goto failed;
		}

		Database::close();
		return true;

		failed:
			Database::close();
			return false;
	}

	final public static function update(
		string $id,
		string $product,
		string $color,
		string $size,
		string $material,
		int $count
	): bool {
		if (!ShoppingCartRepository::dbConnect()) {
			goto failed;
		}

		Database::query(
			"UPDATE `dibas_shopping_carts`
			SET
				`product` = '$product',
				`product_color` = '$color',
				`product_size` = '$size',
				`product_material` = '$material',
				`count` = $count
			WHERE `dibas_shopping_carts`.`id` = '$id';"
		);

		if (Database::hasError()) {
			ShoppingCartRepository::setError(Database::getError());
			goto failed;
		}

		Database::close();
		return true;

		failed:
			Database::close();
			return false;
	}

	private static function updateAssoc(string $id, string $field, string|int $value): bool {
		if (!ShoppingCartRepository::dbConnect()) {
			goto failed;
		}

		Database::query(
			"UPDATE `dibas_shopping_carts`
			SET
				`$field` = '$value'
			WHERE `dibas_shopping_carts`.`id` = '$id';"
		);

		if (Database::hasError()) {
			ShoppingCartRepository::setError(Database::getError());
			goto failed;
		}

		Database::close();
		return true;

		failed:
			Database::close();
			return false;
	}

	final public static function updateColor(string $id, string $color): bool {
		return ShoppingCartRepository::updateAssoc($id, "product_color", $color);
	}

	final public static function updateSize(string $id, string $size): bool {
		return ShoppingCartRepository::updateAssoc($id, "product_size", $size);

	}

	final public static function updateMaterial(string $id, string $material): bool {
		return ShoppingCartRepository::updateAssoc($id, "product_material", $material);

	}

	final public static function updateCount(string $id, int $count): bool {
		return ShoppingCartRepository::updateAssoc($id, "count", $count);
	}

	final public static function find(string $owner): array {
		$models = [];

		if (!ShoppingCartRepository::dbConnect()) {
			goto failed;
		}

		$rows = Database::query(
			"SELECT * FROM `dibas_shopping_carts` WHERE `dibas_shopping_carts`.`owner` = '$owner';"
		)->fetchAll();

		if (Database::hasError()) {
			ShoppingCartRepository::setError(Database::getError());
			goto failed;
		}

		if ($rows === FALSE) {
			goto failed;
		}

		foreach ($rows as $row) {
			$model = new ShoppingCartModel(
				$row["id"],
				$row["owner"],
				$row["product"],
				$row["product_color"],
				$row["product_size"],
				$row["product_material"],
				(int)$row["count"],
				new DateTimeImmutable($row["created_at"])
			);

			if ($model->hasError()) {
				ShoppingCartRepository::setError($model->getError());
				goto failed;
			}

			array_push($models, $model);
		}

		Database::close();
		return $models;

		failed:
			Database::close();
			return $models;
	}

	final public static function findById(string $id): ShoppingCartModel|null {
		if (!ShoppingCartRepository::dbConnect()) {
			goto failed;
		}

		$row = Database::query(
			"SELECT * FROM `dibas_shopping_carts` WHERE `dibas_shopping_carts`.`id` = '$id';"
		)->fetch();

		if ($row === FALSE) {
			goto failed;
		}

		if (Database::hasError()) {
			ShoppingCartRepository::setError(Database::getError());
			goto failed;
		}

		$model = new ShoppingCartModel(
			$row["id"],
			$row["owner"],
			$row["product"],
			$row["product_color"],
			$row["product_size"],
			$row["product_material"],
			(int)$row["count"],
			new DateTimeImmutable($row["created_at"])
		);

		if ($model->hasError()) {
			ShoppingCartRepository::setError($model->getError());
			goto failed;
		}

		Database::close();
		return $model;

		failed:
			Database::close();
			return null;
	}
}

?>
