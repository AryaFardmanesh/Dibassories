<?php

include_once __DIR__ . "/../config.php";
include_once __DIR__ . "/model.php";

class ShoppingCartModel extends BaseModel {
	public function __construct(
		public string $id,
		public string $owner,
		public string $product,
		public string $product_color,
		public string $product_size,
		public string $product_material,
		public int $count,
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
			$this->setError("شناسه صاحب سبد خرید باید بین 32 کاراکتر باشد.");
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
		if (!ModelTest::inRange(32, 32, $this->product_size)) {
			$this->setError("شناسه سایز محصول باید 32 کاراکتر باشد.");
			return false;
		}
		if (!ModelTest::inRange(32, 32, $this->product_material)) {
			$this->setError("شناسه جنس محصول باید 32 کاراکتر باشد.");
			return false;
		}

		return true;
	}
}

?>
