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
		$exp = strtotime($data["exp"]["date"]);
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
		throw new \Exception("Not implemented yet.");
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
