<?php

include __DIR__ . "/../src/config.php";
include __DIR__ . "/../src/repositories/carts.php";
include __DIR__ . "/../src/repositories/products.php";
include __DIR__ . "/../src/services/accounts.php";
include __DIR__ . "/../src/controllers/controller.php";

$error = Controller::getRequest("error");
$account = AccountService::getAccountFromCookie();

if ($account === null) {
	Controller::redirect(null);
}

$cart = ShoppingCartRepository::find($account->id);

if (ShoppingCartRepository::hasError()) {
	$error = "سبد خرید یافت نشد.";
}

if (count($cart) === 0) {
	Controller::redirect(BASE_URL . "/profile/");
}

?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="<?= ASSETS_DIR ?>/img/logo/logo-nobg.png" type="image/x-icon" />
	<link rel="stylesheet" href="<?= ASSETS_DIR ?>/libs/bootstrap.rtl.min.css" />
	<link rel="stylesheet" href="<?= ASSETS_DIR ?>/fonts/font.patch.css" />
	<script src="<?= ASSETS_DIR ?>/libs/jquery.min.js"></script>
	<script src="<?= ASSETS_DIR ?>/libs/bootstrap.bundle.min.js"></script>
	<title>دیبا اکسسوری - پرداخت</title>
	<style>
	.product-card {
		border-radius: 1rem;
		transition: all 0.3s ease;
	}
	.product-card:hover {
		transform: translateY(-5px);
		box-shadow: 0 0.8rem 1.5rem rgba(0, 0, 0, 0.1);
	}
	.product-card img {
		height: 180px;
		object-fit: cover;
		border-top-left-radius: 1rem;
		border-top-right-radius: 1rem;
	}
	::-webkit-scrollbar {
		height: 8px;
	}
	::-webkit-scrollbar-thumb {
		background-color: #ccc;
		border-radius: 10px;
	}
	</style>
</head>
<body>
	<?php include __DIR__ . "/../assets/components/navbar.php"; ?>

	<?php if ($error !== null) echo "<div class='alert alert-danger mx-3 mt-4'>$error</div>"; ?>

	<div class="container my-5">
		<h3 class="fw-bold mb-4 text-center">تسویه حساب و پرداخت</h3>

		<div class="card border-0 shadow-sm mb-4">
			<div class="card-body">
				<div class="d-flex justify-content-between align-items-center mb-3">
					<h5 class="fw-bold mb-0">سبد خرید شما</h5>
				</div>
				<div class="d-flex flex-nowrap overflow-auto pb-2">

					<?php
						$totalPrice = 0;
						foreach ($cart as $cartProduct) {
							$product = ProductRepository::findById($cartProduct->product);
							$color = ProductRepository::findColor($cartProduct->product_color);
							$material = ProductRepository::findMaterial($cartProduct->product_material);
							$size = ProductRepository::findSize($cartProduct->product_size);
							$cartTotalPrice = $cartProduct->count * ($product->price - ($product->price * $product->offer / 100));
							$totalPrice += $cartTotalPrice;
					?>
					<div class="card product-card me-3" style="min-width: 250px;">
						<img src="<?= ASSETS_DIR ?>/img/products/<?= $product->image[0] ?>" class="card-img-top" alt="<?= $product->name ?>">
						<div class="card-body text-center">
							<h6 class="fw-bold mb-2"><?= $product->name ?></h6>
							<div class="d-flex justify-content-center align-items-center mb-2">
								<?php
									$decCountLink = Controller::makeControllerUrl("carts", CONTROLLER_CART_DEC_PRODUCT_COUNT, [
										"user" => $account->id,
										"cart" => $cartProduct->id,
										"product" => $product->id,
										"redirect" => dirname($_SERVER["PHP_SELF"])
									]);
									$incCountLink = Controller::makeControllerUrl("carts", CONTROLLER_CART_INC_PRODUCT_COUNT, [
										"user" => $account->id,
										"cart" => $cartProduct->id,
										"product" => $product->id,
										"redirect" => dirname($_SERVER["PHP_SELF"])
									]);
									$removeCountLink = Controller::makeControllerUrl("carts", CONTROLLER_CART_REMOVE_CART, [
										"user" => $account->id,
										"product" => $product->id,
										"redirect" => dirname($_SERVER["PHP_SELF"])
									]);
								?>
								<a href="<?= $decCountLink ?>" class="btn btn-sm btn-outline-secondary minus-btn">-</a>
								<span class="form-control form-control-sm mx-2 text-center"><?= $cartProduct->count ?></span>
								<a href="<?= $incCountLink ?>" class="btn btn-sm btn-outline-secondary plus-btn">+</a>
							</div>
							<div class="fw-bold text-success mb-2"><?= number_format((float)$cartTotalPrice) ?> تومان</div>
							<a href="<?= $removeCountLink ?>" class="btn btn-sm btn-outline-danger w-100">حذف</a>
						</div>
					</div>
					<?php } ?>

				</div>

				<div class="border-top pt-3 mt-3 d-flex justify-content-between align-items-center">
					<span class="fw-bold">جمع کل:</span>
					<span class="fw-bold text-success fs-5"><?= number_format((float)$totalPrice) ?> تومان</span>
				</div>
			</div>
		</div>

		<div class="card shadow-sm mb-4 border-0 rounded-4">
			<div class="card-body text-center py-4">
				<h4 class="fw-bold text-primary mb-2">موجودی کیف پول شما</h4>
				<h2 class="fw-bolder text-<?= $account->wallet_balance < $totalPrice ? "danger" : "success" ?> mb-3"><?= number_format((float)$account->wallet_balance) ?> <small class="text-muted fs-5">تومان</small></h2>
				<p class="text-muted">از موجودی خود می‌توانید برای خرید یا برداشت وجه استفاده کنید.</p>
			</div>
		</div>

		<div class="card border-0 shadow-sm">
			<div class="card-body">
				<h5 class="fw-bold mb-3">اطلاعات ارسال و پرداخت</h5>
				<form action="<?= BASE_URL . "/src/controllers/shopping.php" ?>" method="GET" class="needs-validation" novalidate>
					<input type="hidden" name="req" value="<?= CONTROLLER_ORDER_PURCHE ?>" />
					<input type="hidden" name="user" value="<?= $account->id ?>" />
					<input type="hidden" name="redirect" value="<?= dirname($_SERVER["PHP_SELF"]) ?>" />

					<div class="row g-3">
						<div class="col-md-6">
							<label for="address" class="form-label">آدرس</label>
							<textarea
								class="form-control"
								id="address"
								name="address"
								rows="3"
								autocomplete="off"
								required
							><?= $account->address ?></textarea>
						</div>
						<div class="col-md-6">
							<label for="payment-method" class="form-label">روش پرداخت</label>
							<select class="form-select" name="payment-method" id="payment-method">
								<option value="<?= PAYMENT_METHOD_WALLET ?>">پرداخت از کیف پول</option>
								<option value="<?= PAYMENT_METHOD_ONLINE ?>">پرداخت آنلاین</option>
							</select>
						</div>
						<div class="col-md-3">
							<label for="zipcode" class="form-label">کد پستی</label>
							<input
								type="text"
								class="form-control"
								id="zipcode"
								name="zipcode"
								value="<?= $account->zipcode ?>"
								autocomplete="off"
								pattern="[0-9]{10}"
								required
							>
						</div>
						<div class="col-md-3">
							<label for="phone" class="form-label">شماره تماس</label>
							<input
								type="tel"
								class="form-control"
								id="phone"
								name="phone"
								value="<?= $account->phone ?>"
								autocomplete="off"
								pattern="^(\+98|0)?9\d{9}$"
								required
							>
						</div>
						<div class="col-12 text-center mt-4">
							<button type="submit" class="btn btn-success px-5 py-2 fs-6">پرداخت و ثبت سفارش</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Validating forms -->
	<script>
		( function () {
			'use strict'

			const forms = document.querySelectorAll( '.needs-validation' );

			Array.from( forms ).forEach( function ( form ) {
				form.addEventListener( 'submit', function ( event ) {
					if ( !form.checkValidity() ) {
						event.preventDefault();
						event.stopPropagation();
					}

					form.classList.add( 'was-validated' );
				}, false );
			})
		} )()
	</script>

	<?php include __DIR__ . "/../assets/components/footer.php"; ?>
</body>
</html>
