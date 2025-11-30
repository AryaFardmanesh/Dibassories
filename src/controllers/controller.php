<?php

include_once __DIR__ . "/../config.php";

class Controller {
	final public static function getRequest(string $name, array $req = $_GET): string|null {
		if (isset($req[$name])) {
			return $req[$name];
		}

		return null;
	}
}

?>
