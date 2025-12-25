<?php

include_once __DIR__ . "/../src/config.php";
include_once __DIR__ . "/../src/services/accounts.php";
include_once __DIR__ . "/../src/controllers/controller.php";

if (AccountService::isLogin()) {
	Controller::redirect(null);
}

$error = Controller::fetchError();

Controller::onSubmit("POST", function (array $params) {
	$result = AccountService::signup(
		$params["username"],
		$params["password"],
		$params["password-confirm"],
		$params["email"],
		$params["fname"],
		$params["lname"],
		$params["phone"],
		$params["address"],
		$params["zipcode"]
	);

	if (!$result || AccountService::hasError()) {
		Controller::setError(AccountService::getError());
		Controller::redirect(htmlspecialchars($_SERVER["PHP_SELF"]));
	}

	Controller::redirect(null);

}, [], [
	"username",
	"password",
	"password-confirm",
	"email",
	"fname",
	"lname",
	"phone",
	"address",
	"zipcode"
]);

?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="shortcut icon" href="./../assets/img/logo/logo-nobg.png" type="image/x-icon" />
	<link rel="stylesheet" href="./../assets/libs/bootstrap.rtl.min.css" />
	<link rel="stylesheet" href="./../assets/fonts/font.patch.css" />
	<link rel="stylesheet" href="./../assets/css/login.css" />
	<script src="./../assets/libs/jquery.min.js"></script>
	<script src="./../assets/libs/bootstrap.bundle.min.js"></script>
	<title><?= PROJ_NAME ?> - ثبت نام</title>
</head>
<body>
	<div class="login-card my-4">
		<?php
			if ($error) echo "<div class='alert alert-danger' role='alert'>$error</div>";
		?>

		<div class="logo"><?= PROJ_NAME ?></div>
		<h5 class="mb-4 fw-bold fs-6 text-secondary">ایجاد حساب کاربری</h5>

		<form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
			<div class="mb-3 text-start">
				<label for="username" class="form-label">نام کاربری:</label>
				<input
					type="text"
					id="username"
					name="username"
					class="form-control form-control-sm"
					placeholder="نام کاربری خود را وارد کنید"
					autocomplete="off"
					spellcheck="false"
					min="6"
					max="64"
					required
				>
			</div>

			<div class="mb-3 text-start">
				<label for="password" class="form-label">رمز عبور:</label>
				<input
					type="password"
					id="password"
					name="password"
					class="form-control form-control-sm"
					placeholder="رمز عبور خود را وارد کنید"
					autocomplete="off"
					min="6"
					max="64"
					required
				>
			</div>

			<div class="mb-3 text-start">
				<label for="password-confirm" class="form-label">تایید رمز عبور:</label>
				<input
					type="password"
					id="password-confirm"
					name="password-confirm"
					class="form-control form-control-sm"
					placeholder="رمز عبور خود را دوباره وارد کنید"
					autocomplete="off"
					min="6"
					max="64"
					required
				>
			</div>

			<div class="mb-3 text-start">
				<label for="email" class="form-label">ایمیل:</label>
				<div class="input-group">
					<span class="input-group-text" id="basic-addon1">gmail.com@</span>
					<input
						type="email"
						id="email"
						name="email"
						class="form-control form-control-sm"
						placeholder="ایمیل خود را وارد کنید"
						autocomplete="off"
						required
					>
				</div>
			</div>

			<div class="mb-3 text-start">
				<label for="fname" class="form-label">نام و نام خانوادگی:</label>
				<div class="input-group mb-3">
					<input
						type="text"
						id="fname"
						name="fname"
						class="form-control form-control-sm"
						placeholder="نام"
						autocomplete="off"
						min="3"
						max="32"
						required
					>
					<input
						type="text"
						id="lname"
						name="lname"
						class="form-control form-control-sm"
						placeholder="نام خانوادگی"
						autocomplete="off"
						min="3"
						max="32"
						required
					>
				</div>
			</div>

			<div class="mb-3 text-start">
				<label for="phone" class="form-label">شماره تلفن همراه:</label>
				<input
					type="text"
					id="phone"
					name="phone"
					class="form-control form-control-sm tlpr"
					placeholder=" شماره تلفن خود را وارد کنید"
					autocomplete="off"
					spellcheck="false"
					min="6"
					max="64"
					required
				>
			</div>

			<div class="mb-3 text-start">
				<label for="address" class="form-label">آدرس:</label>
				<textarea
					name="address"
					id="address"
					class="form-control form-control-sm"
					placeholder="آدرس خود را وارد کنید."
					autocomplete="off"
					spellcheck="false"
					max="512"
					required
				></textarea>
			</div>

			<div class="mb-3 text-start">
				<label for="zipcode" class="form-label">کد پستی:</label>
				<input
					type="text"
					id="zipcode"
					name="zipcode"
					class="form-control form-control-sm tlpr"
					placeholder="کد پستی خود را وارد کنید"
					autocomplete="off"
					spellcheck="false"
					min="10"
					max="10"
					required
				>
			</div>

			<button type="submit" class="btn btn-sm btn-primary w-100 mt-2">ثبت نام</button>

			<div class="footer-text">
				<span>حساب کاربری دارید؟</span>
				<a href="<?= BASE_URL ?>/login/">وارد شوید.</a>
			</div>
		</form>
	</div>
</body>
</html>
