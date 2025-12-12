<?php

include_once __DIR__ . "/../config.php";
include_once __DIR__ . "/model.php";

class OrderModel extends BaseModel {
	public function __construct(
		public string $id,
		public string $owner,
		public string $provider,
		public string $product,
		public string $product_color,
		public string $product_material,
		public string $product_size,
		public int $count,
		public int $total,
		public string $phone,
		public string $address,
		public string $zipcode,
		public int $status = STATUS_OPENED,
		public DateTimeImmutable $created_at = new DateTimeImmutable(),
	) {
		$this->validate();
	}

	final public function validate(): bool {
		if (!ModelTest::inRange(32, 32, $this->id)) {
			$this->setError("شناسه سبد خرید باید 32 کاراکتری باشد.");
			return false;
		}
		if (!ModelTest::inRange(32, 32, $this->owner)) {
			$this->setError("شناسه صاحب سبد خرید باید 32 کاراکتر باشد.");
			return false;
		}
		if (!ModelTest::inRange(32, 32, $this->provider)) {
			$this->setError("شناسه صاحب مصحول باید 32 کاراکتر باشد.");
			return false;
		}
		if (!ModelTest::inRange(32, 32, $this->product)) {
			$this->setError("شناسه محصول باید 32 کاراکتر باشد.");
			return false;
		}
		if (!ModelTest::inRange(32, 32, $this->product_color)) {
			$this->setError("شناسه رنگ محصول باید 32 کاراکتر باشد.");
			return false;
		}
		if (!ModelTest::inRange(32, 32, $this->product_material)) {
			$this->setError("شناسه جنس محصول باید 32 کاراکتر باشد.");
			return false;
		}
		if (!ModelTest::inRange(32, 32, $this->product_size)) {
			$this->setError("شناسه سایز محصول باید 32 کاراکتر باشد.");
			return false;
		}
		if (!ModelTest::inRange(11, 12, $this->phone)) {
			$this->setError("شماره تلفن همراه باید 11 یا 12 کاراکتر باشد.");
			return false;
		}
		if (!ModelTest::inRange(12, 512, $this->address)) {
			$this->setError("آدرس باید بین 12 تا 512 کاراکتر باشد.");
			return false;
		}
		if (!ModelTest::inRange(10, 10, $this->zipcode)) {
			$this->setError("کد پستی باید 10 کاراکتر باشد.");
			return false;
		}

		return true;
	}
}

?>
