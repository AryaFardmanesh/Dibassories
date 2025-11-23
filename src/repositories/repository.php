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

	final static protected function setError(string $err): void {
		BaseRepository::$error = $err;
	}

	final static protected function dbConnect(): bool {
		if (!Database::connect()) {
			AccountRepository::setError(
				"خطایی در برقراری با پایگاه داده به وجود آمده است." . "<br />" .
				Database::getError()
			);
			return false;
		}

		return true;
	}
}

?>
