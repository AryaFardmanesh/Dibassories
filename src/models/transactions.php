<?php

include_once __DIR__ . "/../config.php";
include_once __DIR__ . "/model.php";

class TransactionModel extends BaseModel {
	public function __construct(
		public string $id,
		public string $wallet,
		public int $amount,
		public int $type,
		public int $status,
		public DateTimeImmutable $created_at = new DateTimeImmutable(),
	) {
		$this->validate();
	}

	final public function validate(): bool {
		if (!ModelTest::inRange(32, 32, $this->id)) {
			$this->setError("شناسه سبد خرید باید 32 کاراکتری باشد.");
			return false;
		}
		if (!ModelTest::inRange(32, 32, $this->wallet)) {
			$this->setError("شناسه کیف پول باید 32 کاراکتر باشد.");
			return false;
		}

		return true;
	}
}

?>
