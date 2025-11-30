<?php

include_once __DIR__ . "/../config.php";

class Controller {
	final public static function getRequest(string $name, array $req = $_GET): string|null {
		if (isset($req[$name])) {
			return $req[$name];
		}

		return null;
	}

	final public static function redirect(string|null $path): never {
		if ($path === null) {
			$path = CONTROLLER_REDIRECT_URL;
		}

		header("location: $path");
		die;
	}
}

?>
