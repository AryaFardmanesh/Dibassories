<?php

include_once __DIR__ . "/../config.php";
include_once __DIR__ . "/../utils/sanitizer.php";

class Controller {
	final public static function getRequest(string $name): string|null {
		if (isset($_GET[$name])) {
			return testInput($_GET[$name]);
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
