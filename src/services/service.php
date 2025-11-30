<?php

abstract class BaseService {
	static private string|null $error = null;

	final static public function hasError(): bool {
		return BaseService::$error !== null;
	}

	final static public function getError(): string|null {
		$error = BaseService::$error;
		BaseService::$error = null;
		return $error;
	}

	final static protected function setError(string $err): void {
		BaseService::$error = $err;
	}
}

?>
