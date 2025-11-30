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

	private static function findAssoc(string $field, string $value): array {
		$models = [];

		if (!OrderRepository::dbConnect()) {
			OrderRepository::setError(Database::getError());
			goto out;
		}

		$rows = Database::query(
			"SELECT * FROM `dibas_orders` WHERE `dibas_orders`.`$field` = '$value';"
		)->fetchAll();

		if (Database::hasError()) {
			OrderRepository::setError(Database::getError());
			goto out;
		}

		if ($rows === FALSE) {
			goto out;
		}

		foreach ($rows as $row) {
			$model = new OrderModel(
				$row["id"],
				$row["owner"],
				$row["provider"],
				$row["product"],
				$row["product_color"],
				$row["product_material"],
				$row["product_size"],
				(int)$row["count"],
				(int)$row["total"],
				$row["phone"],
				$row["address"],
				$row["zipcode"],
				(int)$row["status"],
				new DateTimeImmutable($row["created_at"])
			);

			if ($model->hasError()) {
				OrderRepository::setError($model->getError());
				goto out;
			}

			array_push($models, $model);
		}

		out:
			Database::close();
			return $models;
	}

	final public static function findForOwner(string $owner): array {
		return OrderRepository::findAssoc("owner", $owner);
	}

	final public static function findForProvider(string $provider): array {
		return OrderRepository::findAssoc("provider", $provider);
	}

	final public static function findAll(int $page = 1, $limit = PAGINATION_LIMIT): array {
		$models = [];

		if (!OrderRepository::dbConnect()) {
			goto out;
		}

		$offset = ($page - 1) * $limit;

		$rows = Database::query(
			"SELECT * FROM `dibas_orders`
			ORDER BY `dibas_orders`.`created_at`
			LIMIT $limit OFFSET $offset;"
		)->fetchAll();

		if (Database::hasError()) {
			OrderRepository::setError(Database::getError());
			goto out;
		}

		if ($rows === FALSE) {
			goto out;
		}

		foreach ($rows as $row) {
			$model = new OrderModel(
				$row["id"],
				$row["owner"],
				$row["provider"],
				$row["product"],
				$row["product_color"],
				$row["product_material"],
				$row["product_size"],
				(int)$row["count"],
				(int)$row["total"],
				$row["phone"],
				$row["address"],
				$row["zipcode"],
				(int)$row["status"],
				new DateTimeImmutable($row["created_at"])
			);

			if ($model->hasError()) {
				OrderRepository::setError($model->getError());
				goto out;
			}

			array_push($models, $model);
		}

		out:
			Database::close();
			return $models;
	}

	final public static function getPageCount($limit = PAGINATION_LIMIT): int {
		$count = 0;

		if (!OrderRepository::dbConnect()) {
			goto out;
		}

		$count = Database::query(
			"SELECT COUNT(*) AS 'total'
			FROM `dibas_orders`;"
		);

		if (Database::hasError()) {
			OrderRepository::setError(Database::getError());
			goto out;
		}

		$count = (int)$count->fetch()["total"];

		out:
			Database::close();
			if ($count < $limit) $count = 1;
			else $count = (int)ceil($count / $limit);
			return $count;
	}
}

?>
