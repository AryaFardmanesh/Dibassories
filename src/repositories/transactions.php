<?php

include_once __DIR__ . "/../config.php";
include_once __DIR__ . "/repository.php";
include_once __DIR__ . "/../models/transactions.php";
include_once __DIR__ . "/../utils/uuid.php";

class TransactionRepository extends BaseRepository {
	final public static function create(
		string $wallet,
		int $amount,
		int $type,
		int $status
	): TransactionModel|null {
		throw new \Exception("Not implemented yet.");
	}

	final public static function remove(string $id): TransactionModel|null {
		throw new \Exception("Not implemented yet.");
	}

	final public static function updateStatus(string $id): TransactionModel|null {
		throw new \Exception("Not implemented yet.");
	}

	final public static function find(string $id): TransactionModel|null {
		if (!TransactionRepository::dbConnect()) {
			TransactionRepository::setError(Database::getError());
			goto failed;
		}

		$row = Database::query(
			"SELECT * FROM `dibas_transactions` WHERE `dibas_transactions`.`id` = '$id';"
		)->fetch();

		if (Database::hasError()) {
			TransactionRepository::setError(Database::getError());
			goto out;
		}

		$model = new TransactionModel(
			$row["id"],
			$row["wallet"],
			(int)$row["amount"],
			(int)$row["type"],
			(int)$row["status"],
			new DateTimeImmutable($row["created_at"])
		);

		if ($model->hasError()) {
			TransactionRepository::setError($model->getError());
			goto out;
		}

		Database::close();
		return $model;

		failed:
			Database::close();
			return null;
	}

	final public static function findAll(int $page = 1, $limit = PAGINATION_LIMIT): array {
		$models = [];

		if (!TransactionRepository::dbConnect()) {
			TransactionRepository::setError(Database::getError());
			goto out;
		}

		$offset = ($page - 1) * $limit;

		$rows = Database::query(
			"SELECT * FROM `dibas_transactions`
			ORDER BY `dibas_transactions`.`created_at`
			LIMIT $limit OFFSET $offset;"
		)->fetchAll();

		if (Database::hasError()) {
			TransactionRepository::setError(Database::getError());
			goto out;
		}

		foreach ($rows as $row) {
			$model = new TransactionModel(
				$row["id"],
				$row["wallet"],
				(int)$row["amount"],
				(int)$row["type"],
				(int)$row["status"],
				new DateTimeImmutable($row["created_at"])
			);

			if ($model->hasError()) {
				TransactionRepository::setError($model->getError());
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

		if (!TransactionRepository::dbConnect()) {
			TransactionRepository::setError(Database::getError());
			goto out;
		}

		$count = Database::query(
			"SELECT COUNT(*) AS 'total'
			FROM `dibas_transactions`;"
		);

		if (Database::hasError()) {
			TransactionRepository::setError(Database::getError());
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
