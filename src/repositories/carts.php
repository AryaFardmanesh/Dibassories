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
		throw new \Exception("Not yet implemented.");
	}

	final public static function removeAll(string $owner): bool {
		throw new \Exception("Not yet implemented.");
	}

	final public static function update(
		string $id,
		string $product,
		string $color,
		string $size,
		string $material,
		int $count
	): bool {
		throw new \Exception("Not yet implemented.");
	}

	final public static function updateColor(string $id, string $color): bool {
		throw new \Exception("Not yet implemented.");
	}

	final public static function updateSize(string $id, string $color): bool {
		throw new \Exception("Not yet implemented.");
	}

	final public static function updateMaterial(string $id, string $color): bool {
		throw new \Exception("Not yet implemented.");
	}

	final public static function updateCount(string $id, int $count): bool {
		throw new \Exception("Not yet implemented.");
	}

	final public static function find(string $owner): array {
		throw new \Exception("Not yet implemented.");
	}
}

?>
