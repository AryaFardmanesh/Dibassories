<?php

include_once __DIR__ . "/../config.php";
include_once __DIR__ . "/repository.php";
include_once __DIR__ . "/../models/orders.php";
include_once __DIR__ . "/../utils/uuid.php";

class OrderRepository extends BaseRepository {
	final public static function create(
		string $owner,
		string $provider,
		string $product,
		string $productColor,
		string $productMaterial,
		string $productSize,
		int $count,
		int $total,
		string $phone,
		string $address,
		string $zipcode
	): OrderModel|null {
		if (!OrderRepository::dbConnect()) {
			OrderRepository::setError(Database::getError());
			goto failed;
		}

		$model = new OrderModel(
			uuid(),
			$owner,
			$provider,
			$product,
			$productColor,
			$productMaterial,
			$productSize,
			$count,
			$total,
			$phone,
			$address,
			$zipcode
		);

		if ($model->hasError()) {
			OrderRepository::setError($model->getError());
			goto failed;
		}

		$id = $model->id;
		$status = $model->status;

		Database::query(
			"INSERT INTO `dibas_orders` (
				`id`,
				`owner`,
				`provider`,
				`product`,
				`product_color`,
				`product_material`,
				`product_size`,
				`count`,
				`total`,
				`phone`,
				`address`,
				`zipcode`,
				`status`,
				`created_at`
			) VALUES (
				'$id',
				'$owner',
				'$provider',
				'$product',
				'$productColor',
				'$productMaterial',
				'$productSize',
				$count,
				$total,
				'$phone',
				'$address',
				'$zipcode',
				$status,
				CURRENT_TIMESTAMP()
			);"
		);

		if (Database::hasError()) {
			OrderRepository::setError(Database::getError());
			goto failed;
		}

		Database::close();
		return $model;

		failed:
			Database::close();
			return null;
	}

	final public static function remove(string $id): bool {
		if (!OrderRepository::dbConnect()) {
			OrderRepository::setError(Database::getError());
			Database::close();
			return false;
		}

		Database::query(
			"DELETE FROM `dibas_orders` WHERE `dibas_orders`.`id` = '$id';"
		);

		Database::close();
		return true;
	}

	final public static function updateStatus(string $id, int $newStatus): bool {
		if (!OrderRepository::dbConnect()) {
			goto failed;
		}

		Database::query(
			"UPDATE `dibas_orders`
			SET
				`status` = '$newStatus'
			WHERE `dibas_orders`.`id` = '$id';"
		);

		if (Database::hasError()) {
			OrderRepository::setError(Database::getError());
			goto failed;
		}

		Database::close();
		return true;

		failed:
			Database::close();
			return false;
	}

	final public static function find(): array {
		throw new \Exception("Not yet implemented.");
	}
}

?>
