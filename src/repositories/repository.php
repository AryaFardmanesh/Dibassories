<?php

include_once __DIR__ . "/../utils/database.php";

abstract class BaseRepository {
	static private string|null $error = null;

	final static public function hasError(): bool {
		return BaseRepository::$error !== null;
	}

	final static public function getError(): string|null {
		$error = BaseRepository::$error;
		BaseRepository::$error = null;
		return $error;
	}

	final static public function setError(string $err): void {
		BaseRepository::$error = $err;
	}
}

?>
