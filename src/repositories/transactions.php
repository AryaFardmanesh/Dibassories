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
		throw new \Exception("Not implemented yet.");
	}

	final public static function findAll(int $page, $limit = PAGINATION_LIMIT): array {
		throw new \Exception("Not implemented yet.");
	}

	final public static function getPageCount($limit = PAGINATION_LIMIT): int {
		throw new \Exception("Not implemented yet.");
	}
}

?>
