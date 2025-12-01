<?php

include_once __DIR__ . "/../config.php";
include_once __DIR__ . "/../utils/sanitizer.php";

class Controller {
	private static string|null $error = null;

	final static public function hasError(): bool {
		return Controller::$error !== null;
	}

	final static public function getError(): string|null {
		$error = Controller::$error;
		Controller::$error = null;
		return $error;
	}

	final static public function setError(string $err): void {
		Controller::$error = $err;
	}

	final public static function getRequest(string $name, bool $mandatory = false): string|null {
		if (isset($_GET[$name])) {
			return testInput($_GET[$name]);
		}

		if ($mandatory) {
			Controller::setError("نمیتوان فیلد $name خالی باشد.");
			Controller::redirect(Controller::getRequest("redirect"));
		}

		return null;
	}

	final public static function redirect(string|null $path): never {
		if ($path === null) {
			$path = CONTROLLER_REDIRECT_URL;
		}

		$error = Controller::getError();
		if ($error !== null) {
			if (!str_contains($path, "?")) {
				$path .= "?";
			}

			$path .= "error=$error";
		}

		header("location: $path");
		die;
	}

	final public static function fetchSerialized(string $name, int $limit, bool $split = false, string $separator = ""): array {
		$result = [];

		for ($i = 0; $i < $limit; $i++) {
			$data = Controller::getRequest($name . $i);

			if ($data === null) {
				break;
			}

			if ($split) {
				$data = str_getcsv($data, $separator);
			}

			array_push($result, $data);
		}

		return $result;
	}
}

?>
