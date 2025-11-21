<?php

include_once __DIR__ . "/repository.php";
include_once __DIR__ . "/../models/accounts.php";

class AccountRepository extends BaseRepository {
	final public static function create(
		string $username,
		string $password,
		string $email,
		string $fname,
		string $lname,
		string $phone,
		string $pangirno,
		string $address,
		string $zipcode
	): AccountModel {
		throw new \Exception("Not implemented yet.");
	}

	final public static function removeById(string $id): bool {
		throw new \Exception("Not implemented yet.");
	}

	final public static function removeByUsername(string $id): bool {
		throw new \Exception("Not implemented yet.");
	}

	final public static function removeFromRequest(string $id): bool {
		throw new \Exception("Not implemented yet.");
	}

	final public static function update(AccountModel $model): AccountModel {
		throw new \Exception("Not implemented yet.");
	}

	final public static function updateRole(string $id, int $newRole): AccountModel {
		throw new \Exception("Not implemented yet.");
	}

	final public static function updateStatus(string $id, int $newStatus): AccountModel {
		throw new \Exception("Not implemented yet.");
	}

	final public static function findById(string $id): AccountModel|null {
		throw new \Exception("Not implemented yet.");
	}

	final public static function findByUsername(string $username): AccountModel|null {
		throw new \Exception("Not implemented yet.");
	}

	final public static function filter(
		int|null $page = 1,
		bool|null $cardSeted = null,
		int|null $role = null,
		int|null $status = null

	): array {
		throw new \Exception("Not implemented yet.");
	}

	final public static function getPageCount(): int {
		throw new \Exception("Not implemented yet.");
	}

	final public static function filterConfirmRequest(int|null $page = 1): array {
		throw new \Exception("Not implemented yet.");
	}

	final public static function getPageCountForRequest(): int {
		throw new \Exception("Not implemented yet.");
	}
}

?>
