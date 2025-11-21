<?php

include_once __DIR__ . "/../config.php";
include_once __DIR__ . "/model.php";

class AccountConfirmModel extends BaseModel {
	public function __construct(
		public string $id,
		public string $user,
		public DateTimeImmutable $created_at = new DateTimeImmutable(),
	) {
		$this->validate();
	}

	final public function validate(): bool {
		if (!ModelTest::inRange(32, 32, $this->id)) {
			$this->setError("شناسه مدل باید 32 کاراکتر باشد.");
			return false;
		}
		if (!ModelTest::inRange(32, 32, $this->user)) {
			$this->setError("شناسه کاربری باید 32 کاراکتری باشد.");
			return false;
		}

		return true;
	}
}

?>
