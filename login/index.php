<?php

include_once __DIR__ . "/../src/config.php";
include_once __DIR__ . "/../src/services/accounts.php";
include_once __DIR__ . "/../src/controllers/controller.php";

if (AccountService::isLogin()) {
	Controller::redirect(null);
}

$error = Controller::fetchError();

Controller::onSubmit("POST", function (array $params) {
	$result = AccountService::login(
		$params["username"],
		$params["password"]
	);

	if (!$result || AccountService::hasError()) {
		Controller::setError(AccountService::getError());
		Controller::redirect(htmlspecialchars($_SERVER["PHP_SELF"]));
	}

	Controller::redirect(null);

}, [], [
	"username",
	"password"
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
	<title>دیبا اکسسوری - ورود</title>
</head>
<body>
	<div class="login-card">
		<?php
			if ($error) echo "<div class='alert alert-danger' role='alert'>$error</div>";
		?>

		<div class="logo">دیبا اکسسوری</div>
		<h5 class="mb-4 fw-bold fs-6 text-secondary">ورود به حساب کاربری</h5>

		<form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">
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

			<div class="mb-4 text-start">
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

			<button type="submit" class="btn btn-sm btn-primary w-100">ورود</button>

			<div class="footer-text">
				<span>حساب کاربری ندارید؟</span>
				<a href="<?= BASE_URL ?>/signup/">یکی ایجاد کنید.</a>
			</div>
		</form>
	</div>
</body>
</html>
