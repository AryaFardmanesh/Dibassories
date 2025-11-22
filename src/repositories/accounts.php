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
		if (!Database::connect()) {
			AccountRepository::setError(
				Database::getError() . "<br />" .
				"خطایی در برقراری با پایگاه داده به وجود آمده است."
			);
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
			Database::close();
			return null;
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
			Database::close();
			return null;
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
			Database::close();
			return null;
		}

		Database::close();
		return $model;
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
