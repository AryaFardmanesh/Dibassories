<?php

use function PHPSTORM_META\type;

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
		)");

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
		)");

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
			$deleteResult = (bool)Database::query(
				"DELETE FROM `dibas_accounts` WHERE `dibas_accounts`.`$field` = '$value';"
			);
			Database::close();
			return $deleteResult;
		}else {
			$removedStatusCode = STATUS_REMOVED;
			$removeResult = (bool)Database::query(
				"UPDATE `dibas_accounts`
				SET `status` = $removedStatusCode
				WHERE `dibas_accounts`.`$field` = '$value';"
			);
			Database::close();
			return $removeResult;
		}

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

// AccountRepository::create(
// 	"admin12346",
// 	"admin1234",
// 	"admin6@gmail.com",
// 	"Arya",
// 	"Fardmanesh",
// 	"09024708906",
// 	"1057867912013124",
// 	"Theran, Iran",
// 	"1057867912013128"
// );

// echo AccountRepository::removeByUsername("admin12346") === true ? "True" : "False";
// echo AccountRepository::requestForSeller("69216da7946ed69216da7946ef69216d") === true ? "True" : "False";
// echo "<br />";

echo "ERROR: " . AccountRepository::getError();

?>
