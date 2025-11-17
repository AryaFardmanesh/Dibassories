<?php

include_once __DIR__ . "/../config.php";

class Cookie {
	public static function set(string $key, string $value): void {
		setcookie($key, $value, (86400 * 30), COOKIE_EXP_TIME, "/");
	}

	public static function get(string $key): string|null {
		if (!isset($_COOKIE[$key])) {
			return null;
		}
		return (string)$_COOKIE[$key];
	}
}

?>
