<?php

include_once __DIR__ . "/../config.php";
include_once __DIR__ . "/model.php";

class ProductModel extends BaseModel {
	public function __construct(
		public string $id,
		public string $owner,
		public int $type,
		public string $name,
		public string $description,
		public array $image,
		public int $count,
		public int $price,
		public int $offer,
		public int $status = STATUS_SUSPENDED,
		public DateTimeImmutable $created_at = new DateTimeImmutable(),
	) {
		$this->validate();
	}

	final public function validate(): bool {
		if (!ModelTest::inRange(32, 32, $this->id)) {
			$this->setError("شناسه محصول باید 32 کاراکتری باشد.");
			return false;
		}
		if (!ModelTest::inRange(32, 32, $this->owner)) {
			$this->setError("شناسه صاحب محصول باید 32 کاراکتر باشد.");
			return false;
		}
		if (!ModelTest::inRange(8, 128, $this->name)) {
			$this->setError("نام محصول باید بین 8 تا 128 کاراکتر باشد.");
			return false;
		}
		if (!ModelTest::inRange(12, 512, $this->description)) {
			$this->setError("شرح محصول باید بین 12 تا 512 کاراکتر باشد.");
			return false;
		}
		if (!ModelTest::inRange(6, 512, join("|", $this->image))) {
			$this->setError("نام تصاویر باید بین 6 تا 128 کاراکتر باشد.");
			return false;
		}

		return true;
	}
}

class ProductColorModel extends BaseModel {
	public function __construct(
		public string $id,
		public string $product,
		public string $name,
		public string $hex
	) {
		$this->validate();
	}

	final public function validate(): bool {
		if (!ModelTest::inRange(32, 32, $this->id)) {
			$this->setError("شناسه محصول باید 32 کاراکتری باشد.");
			return false;
		}
		if (!ModelTest::inRange(32, 32, $this->product)) {
			$this->setError("شناسه محصول باید 32 کاراکتر باشد.");
			return false;
		}
		if (!ModelTest::inRange(3, 32, $this->name)) {
			$this->setError("نام رنگ باید بین 3 تا 32 کاراکتر باشد.");
			return false;
		}
		if (!ModelTest::inRange(6, 6, $this->hex)) {
			$this->setError("کدهگز باید 6 کاراکتر باشد.");
			return false;
		}

		return true;
	}
}

?>
