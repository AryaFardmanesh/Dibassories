<?php

include __DIR__ . "/../src/config.php";
include __DIR__ . "/../src/repositories/carts.php";
include __DIR__ . "/../src/repositories/products.php";
include __DIR__ . "/../src/repositories/orders.php";
include __DIR__ . "/../src/repositories/transactions.php";
include __DIR__ . "/../src/services/accounts.php";
include __DIR__ . "/../src/controllers/controller.php";
include __DIR__ . "/../src/utils/convert.php";

$error = Controller::getRequest("error");
$account = AccountService::getAccountFromCookie();

if ($account === null) {
	Controller::redirect(null);
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
	<title><?= PROJ_NAME ?> - پروفایل</title>
	<style>
	.cart-slider {
		scroll-behavior: smooth;
	}

	.cart-slider::-webkit-scrollbar {
		height: 8px;
	}
	.cart-slider::-webkit-scrollbar-thumb {
		background-color: rgba(0,0,0,0.15);
		border-radius: 6px;
	}

	.cart-item {
		border-radius: 0.75rem;
		overflow: hidden;
		transition: transform .18s ease, box-shadow .18s ease;
		box-shadow: 0 .25rem .6rem rgba(0,0,0,0.06);
		background: #fff;
	}

	.cart-item:hover {
		transform: translateY(-6px);
		box-shadow: 0 .8rem 1.4rem rgba(0,0,0,0.10);
	}

	.cart-item img.card-img-top {
		height: 160px;
		object-fit: cover;
		padding: .8rem;
		background: #fafafa;
	}

	.cart-item .card-body {
		padding: .8rem 1rem 1rem;
	}

	@media (max-width: 576px) {
		.cart-slider {
			padding-left: .25rem;
			padding-right: .25rem;
			gap: .5rem;
		}

		.cart-item {
			min-width: 100%;
			margin-right: 0 !important;
			margin-left: 0 !important;
			border-radius: 0.5rem;
		}
	}

	#walletAlert {
		border-radius: .5rem;
	}

	.card .form-text code {
		background: rgba(0,0,0,0.03);
		padding: .15rem .4rem;
		border-radius: .25rem;
	}

	#sellerRequestForm .form-text {
		color: #495057;
	}
	.card-header .btn {
		font-size: 0.9rem;
	}
	</style>
</head>
<body>
	<?php include __DIR__ . "/../assets/components/navbar.php"; ?>

	<?php if ($error !== null) echo "<div class='alert alert-danger mx-3 mt-3'>$error</div>"; ?>

	<section class="container-fluid my-5">
		<div class="row justify-content-center">
			<div class="col-12 col-md-10 col-lg-8">
				<div class="card shadow-lg border-0 rounded-4">
					<div class="card-header bg-info text-white text-center py-3 rounded-top-4">
						<h4 class="mb-0">اطلاعات حساب کاربری</h4>
					</div>
					<div class="card-body p-4">
						<form action="<?= BASE_URL . "/src/controllers/accounts.php" ?>" method="GET" class="needs-validation" novalidate>
							<input type="hidden" name="req" value="<?= CONTROLLER_ACCOUNT_UPDATE ?>" />
							<input type="hidden" name="user" value="<?= $account->id ?>" />
							<input type="hidden" name="redirect" value="<?= $_SERVER["PHP_SELF"] ?>" />

							<div class="row g-3">
								<div class="col-md-6">
									<label for="username" class="form-label fw-bold">نام کاربری</label>
									<input
										type="text"
										id="username"
										name="username"
										class="form-control form-control-sm"
										value="<?= $account->username ?>"
										autocomplete="off"
										readonly
									>
								</div>
								<div class="col-md-6">
									<label for="email" class="form-label fw-bold">ایمیل</label>
									<input
										type="email"
										id="email"
										name="email"
										class="form-control form-control-sm"
										value="<?= $account->email ?>"
										autocomplete="off"
										required
									>
								</div>
								<div class="col-md-6">
									<label for="fname" class="form-label fw-bold">نام</label>
									<input
										type="text"
										id="fname"
										name="fname"
										class="form-control form-control-sm"
										value="<?= $account->fname ?>"
										autocomplete="off"
										min="4"
										max="32"
										required
									>
								</div>
								<div class="col-md-6">
									<label for="lname" class="form-label fw-bold">نام خانوادگی</label>
									<input
										type="text"
										id="lname"
										name="lname"
										class="form-control form-control-sm"
										value="<?= $account->lname ?>"
										autocomplete="off"
										min="4"
										max="32"
										required
									>
								</div>
								<div class="col-md-6">
									<label for="phone" class="form-label fw-bold">شماره تلفن</label>
									<input
										type="tel"
										id="phone"
										name="phone"
										class="form-control form-control-sm"
										value="<?= $account->phone ?>"
										autocomplete="off"
										max="14"
										required
									>
								</div>
								<div class="col-md-6">
									<label for="zipcode" class="form-label fw-bold">کد پستی</label>
									<input
										type="text"
										id="zipcode"
										name="zipcode"
										class="form-control form-control-sm"
										value="<?= $account->zipcode ?>"
										autocomplete="off"
										max="10"
										required
									>
								</div>
								<?php if ($account->card_number !== null) { ?>
								<div class="col-md-6">
									<label for="card_number" class="form-label fw-bold">شماره کارت</label>
									<input
										type="text"
										id="card_number"
										name="card_number"
										class="form-control form-control-sm"
										value="<?= $account->card_number ?>"
										autocomplete="off"
										min="16"
										max="16"
										required
									>
								</div>
								<?php } ?>
								<?php if ($account->card_terminal !== null) { ?>
								<div class="col-md-6">
									<label for="card_terminal" class="form-label fw-bold">شماره کارت</label>
									<input
										type="text"
										id="card_terminal"
										name="card_terminal"
										class="form-control form-control-sm"
										value="<?= $account->card_terminal ?>"
										autocomplete="off"
										min="32"
										max="32"
										required
									>
								</div>
								<?php } ?>
								<div class="col-12">
									<label for="address" class="form-label fw-bold">آدرس</label>
									<textarea
										id="address"
										name="address"
										class="form-control form-control-sm"
										autocomplete="off"
										max="10"
										rows="3"
										required
									><?= $account->address ?></textarea>
								</div>
							</div>
							<div class="text-center mt-4">
								<button type="submit" class="btn btn-sm btn-danger px-5 py-2 fw-bold w-100 shadow-sm">بروزرسانی اطلاعات</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="container-fluid my-5">
		<div class="d-flex align-items-center gap-3 mb-3">
			<h4 class="fw-bold mb-0">سبد خرید شما</h4>

			<div class="d-flex gap-2">
				<button id="clearCartBtn" class="btn btn-sm btn-danger">حذف سبد خرید</button>
				<a href="<?= BASE_URL . "/checkout/" ?>" id="checkoutBtn" class="btn btn-sm btn-success">ثبت سفارش</a>
			</div>
		</div>

		<div class="cart-slider d-flex flex-row flex-nowrap overflow-auto pb-3">

		<?php
			$cart = ShoppingCartRepository::find($account->id);
			foreach ($cart as $cartInfo) {
				$cartProduct = ProductRepository::findById($cartInfo->product);
				if ($cartProduct === null) {
					continue;
				}
		?>
			<a href="<?= BASE_URL . "/product/" . urlencode($cartProduct->name) ?>" class="card cart-item me-3 text-decoration-none text-dark" style="min-width: 260px;">
				<div class="position-relative">
					<img src="<?= ASSETS_DIR ?>/img/products/<?= $cartProduct->image[0] ?>" class="card-img-top" alt="<?= $cartProduct->name ?>">
				</div>
				<div class="card-body">
					<h6 class="card-title fw-bold mb-1 text-truncate"><?= $cartProduct->name ?></h6>
					<span> تعداد: <?= $cartInfo->count ?></span>
					<div class="d-flex justify-content-between align-items-center">
						<?php if ($cartProduct->offer === 0) { ?>
							<div>
								<span class="text-muted small"><?= number_format((float)$cartProduct->price)  ?></span>
								<span class="badge bg-light text-dark border ms-1">تومان</span>
							</div>
						<?php }else { ?>
							<div>
								<span class="text-muted text-decoration-line-through small"><?= number_format((float)$cartProduct->price)  ?></span>
								<span class="text-danger fw-bold ms-1"><?= number_format((float)$cartProduct->price - ($cartProduct->price * $cartProduct->offer / 100)) ?></span>
							</div>
							<div>
								<span class="badge bg-danger">٪<?= $cartProduct->offer ?></span>
								<span class="badge bg-light text-dark border ms-1">تومان</span>
							</div>
						<?php } ?>
					</div>
				</div>
			</a>
		<?php } ?>

		</div>
	</section>

	<div class="modal fade" id="confirmClearModal" tabindex="-1" aria-labelledby="confirmClearModalLabel" aria-hidden="true">
		<?php
			$emptyCartLink = Controller::makeControllerUrl("carts", CONTROLLER_CART_EMPTY_CART, [
				"user" => $account->id,
				"redirect" => pathinfo($_SERVER["PHP_SELF"], PATHINFO_DIRNAME)
			]);
		?>
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="confirmClearModalLabel">تأیید حذف سبد خرید</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="بستن"></button>
				</div>
				<div class="modal-body">
					آیا از حذف کامل سبد خرید خود مطمئن هستید؟ این عمل قابل بازگشت نیست.
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-info text-white" data-bs-dismiss="modal">انصراف</button>
					<a href="<?= $emptyCartLink ?>" id="confirmClearBtn" class="btn btn-danger">بله، حذف کن</a>
				</div>
			</div>
		</div>
	</div>

	<script>
		$( function() {
			$( '#clearCartBtn' ).on( 'click', function( e ) {
				e.preventDefault();
				$( '#confirmClearModal' ).modal( 'show' );
			} );
		} );
	</script>

	<section class="container-fluid my-5">
		<div class="row justify-content-center">
			<div class="col-lg-10 col-md-12">

				<div class="card shadow-sm mb-4 border-0 rounded-4">
					<div class="card-body text-center py-4">
						<h4 class="fw-bold text-info mb-2">موجودی کیف پول شما</h4>
						<h2 class="fw-bolder text-success mb-3"><?= number_format((float)$account->wallet_balance) ?> <small class="text-muted fs-5">تومان</small></h2>
						<p class="text-muted">از موجودی خود می‌توانید برای خرید یا برداشت وجه استفاده کنید.</p>
					</div>
				</div>

				<div class="card shadow-sm mb-4 border-0 rounded-4">
					<div class="card-body">
						<h5 class="fw-bold mb-3 text-info">شارژ کیف پول</h5>
						<p class="text-muted small mb-3">
							می‌توانید مبلغ مورد نظر را وارد کرده و با انتخاب روش پرداخت، کیف پول خود را شارژ کنید.
							(در نسخهٔ آزمایشی، از کد تست برای شارژ بدون پرداخت واقعی می‌توان استفاده کرد.)
						</p>

						<form action="<?= BASE_URL . "/src/controllers/transactions.php" ?>" method="GET" id="chargeForm" class="row g-3 align-items-end needs-validation" novalidate>
							<input type="hidden" name="req" value="<?= CONTROLLER_TRANSACTION_CHARGE ?>" />
							<input type="hidden" name="user" value="<?= $account->id ?>" />
							<input type="hidden" name="redirect" value="<?= pathinfo($_SERVER["PHP_SELF"], PATHINFO_DIRNAME) ?>" />

							<div class="col-12 col-md-6 mb-auto">
								<label for="chargeAmount" class="form-label fw-semibold">مبلغ (تومان)</label>
								<input
									type="number"
									class="form-control form-control-sm"
									id="chargeAmount"
									name="amount"
									placeholder="مثلاً ۵۰۰۰۰"
									autocomplete="off"
									min="1000"
									required
								>
							</div>

							<div class="col-12 col-md-6">
								<label for="testCode" class="form-label fw-semibold">کد تست (اختیاری)</label>
								<input
									type="text"
									id="testCode"
									name="tcode"
									class="form-control form-control-sm"
									placeholder="اگر کد تست دارید وارد کنید"
									autocomplete="off"
									min="6"
									max="12"
								>
								<div class="form-text">
									این فیلد برای تست است — کاربران می‌توانند کد تست را وارد کنند تا بدون پرداخت واقعی حساب‌شان شارژ شود.
								</div>
							</div>

							<div class="col-12 d-flex gap-2 justify-content-start">
								<button type="submit" class="btn btn-info text-white w-100">پرداخت و شارژ</button>
							</div>
						</form>
					</div>
				</div>

				<div class="card shadow-sm mb-4 border-0 rounded-4">
					<div class="card-body">
						<h5 class="fw-bold mb-3 text-info">برداشت وجه از کیف پول</h5>
						<form action="<?= BASE_URL . "/src/controllers/transactions.php" ?>" method="GET" class="needs-validation" novalidate>
							<input type="hidden" name="req" value="<?= CONTROLLER_TRANSACTION_EXCHANGE ?>" />
							<input type="hidden" name="user" value="<?= $account->id ?>" />
							<input type="hidden" name="redirect" value="<?= pathinfo($_SERVER["PHP_SELF"], PATHINFO_DIRNAME) ?>" />

							<div class="mb-3">
								<label for="withdrawAmount" class="form-label">مبلغ مورد نظر (تومان)</label>
								<input
									type="number"
									class="form-control form-control-sm rounded-3"
									id="withdrawAmount"
									name="amount"
									placeholder="مثلاً ۵۰۰,۰۰۰"
									autocomplete="off"
									min="0"
									max="<?= $account->wallet_balance ?>"
									required
								>
							</div>
							<div class="text-end">
								<button type="submit" class="btn btn-info text-white w-100 px-4">درخواست برداشت</button>
							</div>
						</form>
					</div>
				</div>

				<div class="card shadow-sm mb-4 border-0 rounded-4">
					<div class="card-body">
						<h5 class="fw-bold mb-3 text-info">تاریخچه سفارشات</h5>
						<div class="table-responsive">
							<table class="table table-striped align-middle text-center">
								<thead class="table-light">
									<tr>
										<th>تصویر</th>
										<th>تعداد</th>
										<th>مبلغ (تومان)</th>
										<th>تاریخ</th>
										<th>وضعیت</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$orders = OrderRepository::findForOwner($account->id);
										foreach ($orders as $order) {
											$product = ProductRepository::findById($order->product);
											if ($product === null) continue;
									?>
									<tr>
										<td>
											<a href="<?= BASE_URL . "/product/" . urlencode($product->name) ?>" class="text-decoration-none">
												<img src="<?= ASSETS_DIR ?>/img/products/<?= $product->image[0] ?>" class="rounded shadow-sm" width="40" height="40" alt="<?= $product->name ?>" />
											</a>
										</td>
										<td><?= $order->count ?></td>
										<td><?= number_format((float)$order->total) ?></td>
										<td><?= $order->created_at->format("Y/m/d") ?></td>
										<td><span class="badge bg-<?= convertStatusToColor($order->status) ?>"><?= convertStatusToString($order->status) ?></span></td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>

				<div class="card shadow-sm border-0 rounded-4">
					<div class="card-body">
						<h5 class="fw-bold mb-3 text-info">تاریخچه تراکنش‌ها</h5>
						<div class="table-responsive">
							<table class="table table-striped align-middle text-center">
								<thead class="table-light">
									<tr>
										<th>عنوان تراکنش</th>
										<th>مبلغ (تومان)</th>
										<th>تاریخ</th>
										<th>وضعیت</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$transactions = TransactionRepository::findOwner($account->id);
										foreach ($transactions as $transaction) {
									?>
									<tr>
										<td><?= convertTransactionTypeToString($transaction->type) ?></td>
										<td><?= number_format((float)$transaction->amount) ?></td>
										<td><?= $transaction->created_at->format("Y/m/d") ?></td>
										<td><span class="badge bg-<?= convertStatusToColor($transaction->status) ?>"><?= convertStatusToString($transaction->status) ?></span></td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>

			</div>
		</div>
	</section>

	<?php if ($account->role === ROLE_CUSTOMER) { ?>
	<section class="container-fluid my-4">
		<div class="card shadow-sm border-0 rounded-4">
			<div class="card-header bg-light d-flex justify-content-between align-items-center">
				<h5 class="mb-0 fw-bold text-info">درخواست ارتقاء به فروشنده</h5>
				<button class="btn btn-sm btn-outline-info" type="button" data-bs-toggle="collapse" data-bs-target="#sellerRequestCollapse" aria-expanded="false" aria-controls="sellerRequestCollapse">
					ارسال درخواست
				</button>
			</div>
			<div class="collapse" id="sellerRequestCollapse">
				<div class="card-body">
					<form action="<?= BASE_URL . "/src/controllers/accounts.php" ?>" method="GET" id="sellerRequestForm" class="row g-3 needs-validation" novalidate>
						<input type="hidden" name="req" value="<?= CONTROLLER_ACCOUNT_SELLER_REQUEST ?>" />
						<input type="hidden" name="user" value="<?= $account->id ?>" />
						<input type="hidden" name="redirect" value="<?= dirname($_SERVER["PHP_SELF"]) ?>" />

						<div class="col-12">
							<p class="small text-muted mb-0">
								برای تبدیل نقش به فروشنده لطفاً اطلاعات زیر را با دقت وارد کنید.
								<strong>فیلدهای ستاره‌دار (*) الزامی هستند.</strong>
							</p>
							<hr>
						</div>

						<div class="col-12 col-md-6">
							<label for="national_id" class="form-label fw-semibold">کد ملی *</label>
							<input
								type="text"
								id="national_id"
								name="pangirno"
								class="form-control form-control-sm"
								placeholder="مثال: 0012345678"
								pattern="\d{10}"
								required
							>
							<div class="form-text">کد ملی ۱۰ رقمی را بدون فاصله وارد کنید.</div>
							<div class="invalid-feedback">لطفاً یک کد ملی معتبر ۱۰ رقمی وارد کنید.</div>
						</div>

						<div class="col-12 col-md-6">
							<label for="card_number" class="form-label fw-semibold">شماره کارت بانکی *</label>
							<input
								type="text"
								id="card_number"
								name="card_number"
								class="form-control form-control-sm"
								placeholder="16 رقم شماره کارت"
								pattern="\d{16}"
								required
							>
							<div class="form-text">شماره کارت ۱۶ رقمی بدون فاصله یا خط وارد شود.</div>
							<div class="invalid-feedback">شماره کارت باید ۱۶ رقم باشد.</div>
						</div>

						<div class="col-12">
							<label for="shaba" class="form-label fw-semibold">شماره شبا (IR...) *</label>
							<input
								type="text"
								id="shaba"
								name="card_terminal"
								class="form-control form-control-sm"
								placeholder="مثال: .........................."
								pattern="[0-9]{24}"
								required
							>
							<div class="form-text">
								دقت کنید نام صاحب حساب باید با <strong>نام و نام خانوادگی ثبت‌شده در پروفایل</strong> مطابقت داشته باشد.
							</div>
							<div class="invalid-feedback">لطفاً یک شماره شبا معتبر وارد کنید.</div>
						</div>

						<div class="col-12 col-md-6">
							<label for="instagram" class="form-label">آیدی اینستاگرام (اختیاری)</label>
							<input
								type="text"
								id="instagram"
								name="instagram"
								class="form-control form-control-sm"
								placeholder="@your_instagram"
								max="128"
							>
							<div class="form-text">در صورت وجود آیدی صفحهٔ فروشتان را وارد کنید.</div>
						</div>

						<div class="col-12 col-md-6">
							<label for="telegram" class="form-label">آیدی تلگرام (اختیاری)</label>
							<input
								type="text"
								id="telegram"
								name="telegram"
								class="form-control form-control-sm"
								placeholder="@your_telegram"
								max="128"
							>
						</div>

						<div class="col-12">
							<div class="alert alert-info small mb-1" role="alert">
								<strong>توجه:</strong> پس از ارسال درخواست، تیم پشتیبانی اطلاعات را بررسی می‌کند. در صورت صحت اطلاعات و تایید، نقش شما به «فروشنده» تغییر خواهد کرد.
							</div>
							<div class="alert alert-info small mb-0" role="alert">
								<strong>توجه:</strong> بعد از تایید و تغییر نقش حساب شما, پنل فروشندگان برای شما در تب منو باز خواهد شد.
							</div>
						</div>

						<div class="col-12 text-center">
							<button type="submit" class="btn btn-info text-white w-100 px-4 py-2 fw-semibold">ارسال درخواست</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>
	<?php } ?>

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
