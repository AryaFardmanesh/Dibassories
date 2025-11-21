<?php

abstract class BaseRepository {
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
}

?>
