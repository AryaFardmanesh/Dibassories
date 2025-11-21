<?php

include_once __DIR__ . "/../config.php";
include_once __DIR__ . "/model.php";

class CartSessionModel extends BaseModel {
	public function __construct(
		public string $id,
		public string $owner,
		public int $status = STATUS_NOT_PAID,
		public DateTimeImmutable $created_at = new DateTimeImmutable(),
	) {
		$this->validate();
	}

	final public function validate(): bool {
		if (!ModelTest::inRange(32, 32, $this->id)) {
			$this->setError("شناسه جلسه برای خرید باید 32 کاراکتری باشد.");
			return false;
		}
		if (!ModelTest::inRange(32, 32, $this->owner)) {
			$this->setError("شناسه کاربری باید 32 کاراکتر باشد.");
			return false;
		}

		return true;
	}
}

?>
