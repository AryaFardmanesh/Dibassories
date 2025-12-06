<?php

include_once __DIR__ . "/../config.php";
include_once __DIR__ . "/model.php";

class AccountModel extends BaseModel {
	public function __construct(
		public string $id,
		public string $username,
		public string $password,
		public string $email,
		public string $fname,
		public string $lname,
		public string $phone,
		public string|null $pangirno,
		public string $address,
		public string $zipcode,
		public string|null $card_number = null,
		public string|null $card_terminal = null,
		public int $wallet_balance = 0,
		public string|null $instagram = null,
		public string|null $telegram = null,
		public int $role = ROLE_CUSTOMER,
		public int $status = STATUS_OK,
		public DateTimeImmutable $created_at = new DateTimeImmutable(),
	) {
		$this->validate();
	}

	final public function validate(): bool {
		if (!ModelTest::inRange(32, 32, $this->id)) {
			$this->setError("شناسه کاربری باید 32 کاراکتری باشد.");
			return false;
		}
		if (!ModelTest::inRange(6, 32, $this->username)) {
			$this->setError("نام کاربری باید بین 6 تا 32 کاراکتر باشد.");
			return false;
		}
		if (!ModelTest::inRange(60, 60, $this->password)) {
			$this->setError("رمز عبور رمز نگاری نشده است.");
			return false;
		}
		if (!ModelTest::inRange(11, 320, $this->email)) {
			$this->setError("ایمیل باید بین 11 تا 320 کاراکتر باشد.");
			return false;
		}
		if (!ModelTest::inRange(2, 32, $this->fname)) {
			$this->setError("نام باید بین 2 تا 32 کاراکتر باشد.");
			return false;
		}
		if (!ModelTest::inRange(2, 32, $this->lname)) {
			$this->setError("نام خوانوادگی باید بین 2 تا 32 کاراکتر باشد.");
			return false;
		}
		if (!ModelTest::inRange(11, 12, $this->phone)) {
			$this->setError("شماره تلفن همراه باید بین 11 تا 12 کاراکتر باشد.");
			return false;
		}
		if (!ModelTest::inRange(16, 16, $this->pangirno, true)) {
			$this->setError("کد ملی باید 16 رقمی باشد.");
			return false;
		}
		if (!ModelTest::inRange(12, 512, $this->address)) {
			$this->setError("آدرس باید بین 12 تا 512 کاراکتر باشد.");
			return false;
		}
		if (!ModelTest::inRange(10, 10, $this->zipcode)) {
			$this->setError("کد پستی باید 10 رقم باشد.");
			return false;
		}
		if (!ModelTest::inRange(16, 16, $this->card_number, true)) {
			$this->setError("شماره کارت باید 16 رقم باشد.");
			return false;
		}
		if (!ModelTest::inRange(32, 32, $this->card_terminal, true)) {
			$this->setError("شماره شبا باید 32 رقم باشد.");
			return false;
		}
		if (!ModelTest::inRange(8, 128, $this->instagram, true)) {
			$this->setError("لینک استاگرام باید بین 8 تا 128 کاراکتر باشد.");
			return false;
		}
		if (!ModelTest::inRange(8, 128, $this->telegram, true)) {
			$this->setError("لینک تلگرام باید بین 8 تا 128 کاراکتر باشد.");
			return false;
		}

		return true;
	}
}

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
