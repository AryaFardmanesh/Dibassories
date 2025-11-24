<?php

include_once __DIR__ . "/repository.php";
include_once __DIR__ . "/../models/accounts.php";
include_once __DIR__ . "/../utils/uuid.php";
include_once __DIR__ . "/../utils/sanitizer.php";

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
	): ?AccountModel {
		if (!AccountRepository::dbConnect()) {
			goto failed;
		}

		$model = new AccountModel(
			uuid(),
			$username,
			$password,
			$email,
			$fname,
			$lname,
			$phone,
			$pangirno,
			$address,
			$zipcode
		);

		if ($model->hasError()) {
			AccountRepository::setError($model->getError());
			goto failed;
		}

		// Extract model data
		$id = $model->id;
		$username = $model->username;
		$password = $model->password;
		$email = $model->email;
		$fname = $model->fname;
		$lname = $model->lname;
		$phone = $model->phone;
		$pangirno = $model->pangirno;
		$address = $model->address;
		$zipcode = $model->zipcode;
		$card_number = dbFlatData($model->card_number);
		$card_terminal = dbFlatData($model->card_terminal);
		$wallet_balance = $model->wallet_balance;
		$instagram = dbFlatData($model->instagram);
		$telegram = dbFlatData($model->telegram);
		$role = $model->role;
		$status = $model->status;

		// Check for duplicate data
		$result = Database::query(
			"SELECT `username`, `email`, `phone`, `pangirno` FROM `dibas_accounts`
			WHERE `dibas_accounts`.`username` = '$username'
			OR `dibas_accounts`.`email` = '$email'
			OR `dibas_accounts`.`phone` = '$phone'
			OR `dibas_accounts`.`pangirno` = '$pangirno';"
		);
		$result_data = $result->fetch();

		if ($result_data !== FALSE) {
			$field = "_";

			if ($result_data["username"] === $username) {
				$field = "نام کاربری";
			}elseif ($result_data["email"] === $email) {
				$field = "ایمیل";
			}elseif ($result_data["phone"] === $phone) {
				$field = "شماره تلفن همراه";
			}elseif ($result_data["pangirno"] === $pangirno) {
				$field = "کد ملی";
			}

			AccountRepository::setError("این $field قبلا ثبت شده است.");
			goto failed;
		}

		// Insert new record
		Database::query("INSERT INTO `dibas_accounts` (
			`id`,
			`username`,
			`password`,
			`email`,
			`fname`,
			`lname`,
			`phone`,
			`pangirno`,
			`address`,
			`zipcode`,
			`card_number`,
			`card_terminal`,
			`wallet_balance`,
			`instagram`,
			`telegram`,
			`role`,
			`status`,
			`created_at`
		) VALUES (
			'$id',
			'$username',
			'$password',
			'$email',
			'$fname',
			'$lname',
			'$phone',
			'$pangirno',
			'$address',
			'$zipcode',
			$card_number,
			$card_terminal,
			$wallet_balance,
			$instagram,
			$telegram,
			$role,
			$status,
			CURRENT_TIMESTAMP()
		);");

		if (Database::hasError()) {
			AccountRepository::setError(Database::getError());
			goto failed;
		}

		Database::close();
		return $model;

		failed:
			Database::close();
			return null;
	}

	final public static function requestForSeller(string $id): bool {
		if (!AccountRepository::dbConnect()) {
			goto failed;
		}

		// Check user was not have request
		$result = Database::query(
			"SELECT `id` FROM `dibas_accounts_confirm`
			WHERE `dibas_accounts_confirm`.`user` = '$id';"
		);
		$row = $result->fetch();

		if ($row !== FALSE) {
			AccountRepository::setError("کاربری با شناسه تعیین شده قبلا این درخواست را ثبت کرده است.");
			goto failed;
		}

		// Check user exists
		$result = Database::query(
			"SELECT `role`, `status` FROM `dibas_accounts`
			WHERE `dibas_accounts`.`id` = '$id';"
		);
		$row = $result->fetch();

		if ($row === FALSE) {
			AccountRepository::setError("کاربری با شناسه تعیین شده یافت نشد.");
			goto failed;
		}

		// Check role and status
		$role = (int)$row["role"];
		$status = (int)$row["status"];

		if ($role !== ROLE_CUSTOMER) {
			AccountRepository::setError("کاربر باید نقش مشتری را داشته باشد تا بتواند به فروشنده ارتقا یابد.");
			goto failed;
		}

		if ($status !== STATUS_OK) {
			AccountRepository::setError("کاربر در وضعیت مسدود یا حذف است.");
			goto failed;
		}

		// Insert new requset for user
		$reqId = uuid();
		Database::query("INSERT INTO `dibas_accounts_confirm` (
			`id`,
			`user`,
			`created_at`
		) VALUES (
			'$reqId',
			'$id',
			CURRENT_TIMESTAMP()
		);");

		if (Database::hasError()) {
			AccountRepository::setError(Database::getError());
			goto failed;
		}

		Database::close();
		return true;

		failed:
			Database::close();
			return false;
	}

	private static function remove(string $field, string $value): bool {
		if (!AccountRepository::dbConnect()) {
			goto failed;
		}

		$result = Database::query(
			"SELECT `id`, `status` FROM `dibas_accounts`
			WHERE `dibas_accounts`.`$field` = '$value';"
		);
		$row = $result->fetch();

		if ($row === FALSE) {
			goto failed;
		}

		$id = $row["id"];
		$status = (int)$row["status"];

		if ($status === STATUS_REMOVED) {
			Database::query(
				"DELETE FROM `dibas_accounts_confirm` WHERE `dibas_accounts_confirm`.`user` = '$id';"
			);
			Database::query(
				"DELETE FROM `dibas_accounts` WHERE `dibas_accounts`.`$field` = '$value';"
			);
			goto success;
		}else {
			$removedStatusCode = STATUS_REMOVED;
			Database::query(
				"UPDATE `dibas_accounts`
				SET `status` = $removedStatusCode
				WHERE `dibas_accounts`.`$field` = '$value';"
			);
			goto success;
		}

		success:
			Database::close();
			return true;

		failed:
			Database::close();
			return false;
	}

	final public static function removeById(string $id): bool {
		return AccountRepository::remove("id", $id);
	}

	final public static function removeByUsername(string $username): bool {
		return AccountRepository::remove("username", $username);
	}

	final public static function removeSellerRequest(string $id): bool {
		if (!AccountRepository::dbConnect()) {
			Database::close();
			return false;
		}

		Database::query(
			"DELETE FROM `dibas_accounts_confirm` WHERE `dibas_accounts_confirm`.`user` = '$id';"
		);
		Database::close();
		return true;
	}

	final public static function update(AccountModel $model): ?AccountModel {
		if ($model->hasError()) {
			AccountRepository::setError($model->getError());
			goto failed;
		}

		if (!AccountRepository::dbConnect()) {
			goto failed;
		}

		// Extract model data
		$id = $model->id;
		$username = $model->username;
		$password = $model->password;
		$email = $model->email;
		$fname = $model->fname;
		$lname = $model->lname;
		$phone = $model->phone;
		$pangirno = $model->pangirno;
		$address = $model->address;
		$zipcode = $model->zipcode;
		$card_number = dbFlatData($model->card_number);
		$card_terminal = dbFlatData($model->card_terminal);
		$wallet_balance = $model->wallet_balance;
		$instagram = dbFlatData($model->instagram);
		$telegram = dbFlatData($model->telegram);
		$role = $model->role;
		$status = $model->status;

		// Check for duplicate data
		$result = Database::query(
			"SELECT `id`, `username`, `email`, `phone`, `pangirno` FROM `dibas_accounts`
			WHERE `dibas_accounts`.`username` = '$username'
			OR `dibas_accounts`.`email` = '$email'
			OR `dibas_accounts`.`phone` = '$phone'
			OR `dibas_accounts`.`pangirno` = '$pangirno';"
		);
		$result_data = $result->fetchAll();

		foreach ($result_data as $row) {
			if ($row["id"] !== $id) {
				$field = "_";

				if ($row["username"] === $username) {
					$field = "نام کاربری";
				}elseif ($row["email"] === $email) {
					$field = "ایمیل";
				}elseif ($row["phone"] === $phone) {
					$field = "شماره تلفن همراه";
				}elseif ($row["pangirno"] === $pangirno) {
					$field = "کد ملی";
				}

				AccountRepository::setError("این $field قبلا ثبت شده است.");
				goto failed;
			}
		}

		// Update
		Database::query(
			"UPDATE `dibas_accounts`
			SET
				`username` = '$username',
				`password` = '$password',
				`email` = '$email',
				`fname` = '$fname',
				`lname` = '$lname',
				`phone` = '$phone',
				`pangirno` = '$pangirno',
				`address` = '$address',
				`zipcode` = '$zipcode',
				`card_number` = $card_number,
				`card_terminal` = $card_terminal,
				`wallet_balance` = $wallet_balance,
				`instagram` = $instagram,
				`telegram` = $telegram,
				`role` = $role,
				`status` = $status
			WHERE `dibas_accounts`.`id` = '$id';"
		);
		Database::close();
		return $model;

		failed:
			Database::close();
			return null;
	}

	final public static function updateRole(string $id, int $newRole): bool {
		if (!AccountRepository::dbConnect()) {
			Database::close();
			return false;
		}

		Database::query(
			"UPDATE `dibas_accounts`
			SET
				`role` = '$newRole'
			WHERE `dibas_accounts`.`id` = '$id';"
		);
		Database::close();
		return true;
	}

	final public static function updateStatus(string $id, int $newStatus): bool {
		if (!AccountRepository::dbConnect()) {
			Database::close();
			return false;
		}

		Database::query(
			"UPDATE `dibas_accounts`
			SET
				`status` = '$newStatus'
			WHERE `dibas_accounts`.`id` = '$id';"
		);
		Database::close();
		return true;
	}

	private static function find(string $field, string $value): AccountModel|null {
		if (!AccountRepository::dbConnect()) {
			goto failed;
		}

		$row = Database::query(
			"SELECT * FROM `dibas_accounts` WHERE `dibas_accounts`.`$field` = '$value';"
		)->fetch();

		if ($row === FALSE) {
			goto failed;
		}

		$model = new AccountModel(
			$row["id"],
			$row["username"],
			$row["password"],
			$row["email"],
			$row["fname"],
			$row["lname"],
			$row["phone"],
			$row["pangirno"],
			$row["address"],
			$row["zipcode"],
			$row["card_number"] === "NULL" ? null : $row["card_number"],
			$row["card_terminal"] === "NULL" ? null : $row["card_terminal"],
			$row["wallet_balance"],
			$row["instagram"] === "NULL" ? null : $row["instagram"],
			$row["telegram"] === "NULL" ? null : $row["telegram"],
			$row["role"],
			$row["status"],
			new DateTimeImmutable($row["created_at"])
		);

		if ($model->hasError()) {
			AccountRepository::setError($model->getError());
			goto failed;
		}

		Database::close();
		return $model;

		failed:
			Database::close();
			return null;
	}

	final public static function findById(string $id): AccountModel|null {
		return AccountRepository::find("id", $id);
	}

	final public static function findByUsername(string $username): AccountModel|null {
		return AccountRepository::find("username", $username);
	}

	final public static function filter(
		int $page = 1,
		int $limit = PAGINATION_LIMIT,
		bool|null $cardSeted = null,
		int|null $role = null,
		int|null $status = null

	): array {
		$models = [];

		if (!AccountRepository::dbConnect()) {
			goto out;
		}

		$offset = ($page - 1) * $limit;
		$sqlCondition = [];
		$sqlConditionStr = "";

		if ($cardSeted) {
			array_push($sqlCondition, "`dibas_accounts`.`card_number` != NULL");
		}
		if ($role !== null) {
			array_push($sqlCondition, "`dibas_accounts`.`role` = $role");
		}
		if ($status !== null) {
			array_push($sqlCondition, "`dibas_accounts`.`status` = $status");
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

		$rows = Database::query(
			"SELECT * FROM `dibas_accounts`
			$sqlConditionStr
			ORDER BY `dibas_accounts`.`created_at`
			LIMIT $limit OFFSET $offset;"
		)->fetchAll();

		foreach ($rows as $row) {
			$model = new AccountModel(
				$row["id"],
				$row["username"],
				$row["password"],
				$row["email"],
				$row["fname"],
				$row["lname"],
				$row["phone"],
				$row["pangirno"],
				$row["address"],
				$row["zipcode"],
				$row["card_number"] === "NULL" ? null : $row["card_number"],
				$row["card_terminal"] === "NULL" ? null : $row["card_terminal"],
				$row["wallet_balance"],
				$row["instagram"] === "NULL" ? null : $row["instagram"],
				$row["telegram"] === "NULL" ? null : $row["telegram"],
				$row["role"],
				$row["status"],
				new DateTimeImmutable($row["created_at"])
			);

			if ($model->hasError()) {
				AccountRepository::setError($model->getError());
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
		bool|null $cardSeted = null,
		int|null $role = null,
		int|null $status = null
	): int {
		$count = 0;

		if (!AccountRepository::dbConnect()) {
			goto out;
		}

		$sqlCondition = [];
		$sqlConditionStr = "";

		if ($cardSeted) {
			array_push($sqlCondition, "`dibas_accounts`.`card_number` != NULL");
		}
		if ($role !== null) {
			array_push($sqlCondition, "`dibas_accounts`.`role` = $role");
		}
		if ($status !== null) {
			array_push($sqlCondition, "`dibas_accounts`.`status` = $status");
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
			"SELECT COUNT(*) AS 'total'
			FROM `dibas_accounts`
			$sqlConditionStr
			;"
		);
		$count = (int)$count->fetch()["total"];

		out:
			Database::close();
			if ($count < $limit) $count = 1;
			else $count = (int)ceil($count / $limit);
			return $count;
	}

	final public static function filterConfirmRequest(int $page = 1, int $limit = PAGINATION_LIMIT): array {
		$models = [];

		if (!AccountRepository::dbConnect()) {
			goto out;
		}

		$offset = ($page - 1) * $limit;
		$rows = Database::query(
			"SELECT * FROM `dibas_accounts_confirm`
			ORDER BY `dibas_accounts_confirm`.`created_at`
			LIMIT $limit OFFSET $offset;"
		)->fetchAll();

		foreach ($rows as $row) {
			$model = new AccountConfirmModel(
				$row["id"],
				$row["user"],
				new DateTimeImmutable($row["created_at"])
			);

			if ($model->hasError()) {
				AccountRepository::setError($model->getError());
				goto out;
			}

			array_push($models, $model);
		}

		out:
			Database::close();
			return $models;
	}

	final public static function getPageCountForRequest(int $limit = PAGINATION_LIMIT): int {
		$count = 0;

		if (!AccountRepository::dbConnect()) {
			goto out;
		}

		$count = Database::query(
			"SELECT COUNT(*) AS 'total'
			FROM `dibas_accounts`;"
		);
		$count = (int)$count->fetch()["total"];

		out:
			Database::close();
			if ($count < $limit) $count = 1;
			else $count = (int)ceil($count / $limit);
			return $count;
	}
}

?>
