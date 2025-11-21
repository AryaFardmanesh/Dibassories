<?php

abstract class BaseModel {
	private string|null $error = null;

	final public function hasError(): bool {
		return $this->error !== null;
	}

	final public function getError(): string|null {
		$error = $this->error;
		$this->error = null;
		return $error;
	}

	final public function setError(string $err): void {
		$this->error = $err;
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
