<?php

include_once __DIR__ . "/service.php";
include_once __DIR__ . "/../repositories/accounts.php";
include_once __DIR__ . "/../config.php";
include_once __DIR__ . "/../utils/cookie.php";
include_once __DIR__ . "/../utils/jwt.php";

class AccountService extends BaseService {
	final public static function isLogin(): bool {
		$token = Cookie::get(COOKIE_JWT_NAME);

		if ($token === null) {
			return false;
		}

		$data = JWT::decode($token)["body"];
		$id = $data["id"];
		$exp = $data["exp"];
		$now = strtotime("today midnight");

		if ($now >= $exp) {
			return false;
		}

		if (AccountRepository::findById($id) === null) {
			return false;
		}

		return true;
	}

	final public static function login(string $username, string $password): bool {
		$model = AccountRepository::findByUsername($username);

		if (AccountRepository::hasError()) {
			AccountService::setError(AccountRepository::getError());
			return false;
		}

		if ($model === null) {
			AccountService::setError("این نام کاربر وجود ندارد.");
			return false;
		}

		if (!password_verify($model->password, $password)) {
			AccountService::setError("نام کاربری یا رمز عبور اشتباه است.");
			return false;
		}

		$status = $model->status;
		if ($status === STATUS_SUSPENDED || $status === STATUS_REMOVED) {
			AccountService::setError("شما مجوز ورود ندارید.");
			return false;
		}

		$exp = (string)((int)strtotime("today") + COOKIE_EXP_TIME);
		$tokenData = [
			"id" => $model->id,
			"exp" => $exp,
		];
		$token = JWT::encode($tokenData);
		Cookie::set(COOKIE_JWT_NAME, $token);

		return true;
	}

	final public static function signup(
		string $username,
		string $password,
		string $passwordConfirm,
		string $email,
		string $fname,
		string $lname,
		string $address,
		string $zipcode
	): bool {
		throw new \Exception("Not implemented yet.");
	}

	final public static function sellerRequest(
		string $id,
		string $pangirno,
		string $card_number,
		string $card_terminal,
		string|null $instagram,
		string|null $telegram
	): bool {
		throw new \Exception("Not implemented yet.");
	}
}

?>
