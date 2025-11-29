<?php

include_once __DIR__ . "/service.php";

class AccountService extends BaseService {
	final public static function isLogin(string $username, string $password): bool {
		throw new \Exception("Not implemented yet.");
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
