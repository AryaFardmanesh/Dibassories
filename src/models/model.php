<?php

abstract class BaseModel {
	private string|null $error = null;

	final public function hasError(): bool {
		return BaseModel::$error !== null;
	}

	final public function getError(): string|null {
		$error = BaseModel::$error;
		BaseModel::$error = null;
		return $error;
	}

	final public function setError(string $err): void {
		BaseModel::$error = $err;
	}

	abstract public function validate(): bool;
}

class ModelTest {
	public static function inRange(int $min, int $max, int|string|null $value, bool $nullable = false): bool {
		$_type = gettype($value);
		$_length = 0;

		if ($_type == "integer") {
			$_length = $value;
		}if ($_type == "NULL") {
			return $nullable;
		}else {
			$_length = strlen($value);
		}

		return ($min <= $_length && $max >= $_length);
	}
}

?>
