<?php

include __DIR__ . "/../../src/config.php";
include __DIR__ . "/../../assets/components/pagination.php";
include __DIR__ . "/../../src/utils/convert.php";
include __DIR__ . "/../../src/controllers/controller.php";
include __DIR__ . "/../../src/repositories/products.php";
include __DIR__ . "/../../src/repositories/orders.php";
include __DIR__ . "/../../src/services/accounts.php";

$account = AccountService::getAccountFromCookie();
$page = Controller::getRequest("page");

if ($page === null) {
	$page = 1;
}

if ($account === null || $account->role !== ROLE_ADMIN) {
	Controller::redirect(null);
}

$orders = OrderRepository::findAll(1, PHP_INT_MAX);
$ordersTotal = 0;
$ordersOpenTotal = 0;
$orderSentTotal = 0;
foreach ($orders as $order) {
	$ordersTotal++;
	if ($order->status === STATUS_OPENED) $ordersOpenTotal++;
	if ($order->status === STATUS_SEND) $orderSentTotal++;
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
	<link rel="stylesheet" href="<?= ASSETS_DIR ?>/css/slidebar.css" />
	<script src="<?= ASSETS_DIR ?>/libs/jquery.min.js"></script>
	<script src="<?= ASSETS_DIR ?>/libs/bootstrap.bundle.min.js"></script>
	<script src="<?= ASSETS_DIR ?>/scripts/slidebar.js"></script>
	<title>دیبا اکسسوری - داشبورد - سفارشات</title>
</head>
<body>
	<?php include __DIR__ . "/../../assets/components/navbar.php"; ?>
	<?php
		$setActiveLinkForSidebar = 'orders';
		include __DIR__ . "/../../assets/components/sidebar.php";
	?>

	<main class="app-content" id="mainContent">
		<div class="d-flex justify-content-between align-items-center mb-4">
			<div class="d-flex align-items-center gap-2">
				<button class="btn btn-outline-primary d-lg-none p-0" aria-controls="appSidebar" aria-expanded="false">
					<img id="mobileSidebarBtn" src="<?= ASSETS_DIR ?>/img/icons/hamburger-button.png" alt="دکمه نوار کناری" width="25" />
				</button>
				<h4 class="mb-0">داشبورد مدیر - سفارشات</h4>
			</div>
			<div class="text-muted small">سلام، <?= $account->fname ?> — امروز <span class="show-time"></span></div>
		</div>

		<div class="row g-4">
			<div class="col-md-4">
				<div class="card shadow-sm">
					<div class="card-body">
						<h6 class="mb-1 fw-bold">تعداد سفارشات</h6>
						<p class="h4 text-primary mb-0"><?= number_format((float)$ordersTotal) ?></p>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card shadow-sm">
					<div class="card-body">
						<h6 class="mb-1 fw-bold">تعداد سفارشات جاری</h6>
						<p class="h4 text-success mb-0"><?= number_format((float)$ordersOpenTotal) ?></p>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card shadow-sm">
					<div class="card-body">
						<h6 class="mb-1 fw-bold">تعداد سفارشات ارسال شده</h6>
						<p class="h4 text-warning mb-0"><?= number_format((float)$orderSentTotal) ?></p>
					</div>
				</div>
			</div>
		</div>

		<hr />

		<section class="container-fluid my-5">
			<div class="card shadow-sm border-0 rounded-4">
				<div class="card-body p-4 p-md-5">
					<div class="table-responsive">
						<table class="table align-middle text-center">
							<thead class="table-light">
								<tr>
									<th>#</th>
									<th>نام (خریدار)</th>
									<th>نام (فروشنده)</th>
									<th>محصول</th>
									<th>تعداد</th>
									<th>قیمت نهایی</th>
									<th>وضعیت</th>
									<th>اغدام ها</th>
								</tr>
							</thead>
							<tbody>

								<?php
									$i = ($page * PAGINATION_LIMIT) - PAGINATION_LIMIT;
									$orders = OrderRepository::findAll($page);
									foreach ($orders as $order) {
										if ($order->status === STATUS_CLOSED) continue;
										$product = ProductRepository::findById($order->product);
										$owner = AccountRepository::findById($order->owner);
										$provider = AccountRepository::findById($order->provider);
										$i++;
								?>
								<tr>
									<td><?= $i ?></td>
									<td><?= $owner->fname . " " . $owner->lname ?></td>
									<td><?= $provider->fname . " " . $provider->lname ?></td>
									<td>
										<a href="<?= BASE_URL . "/product/" . urlencode($product->name) ?>" class="text-decoration-none">
											<img src="<?= ASSETS_DIR  ?>/img/products/<?= $product->image[0] ?>" width="60" height="60" class="rounded shadow-sm" alt="<?= $product->name ?>" />
										</a>
									</td>
									<td><?= $order->count ?></td>
									<td><?= number_format((float)$order->total) ?></td>
									<td><span class="badge text-bg-<?= convertStatusToColor($order->status) ?>"><?= convertStatusToString($order->status) ?></span></td>
									<td>
										<?php
											$blockOrUnBlockText = "مسدود";
											$blockOrUnBlockStatusCode = STATUS_SUSPENDED;
											if ($order->status === STATUS_SUSPENDED) {
												$blockOrUnBlockText = "باز کردن سفارش";
												$blockOrUnBlockStatusCode = STATUS_OPENED;
											}

											$blockOrOpenLink = Controller::makeControllerUrl("orders", CONTROLLER_ORDER_STATUS_UPDATE, [
												"user" => $account->id,
												"order" => $order->id,
												"status" => $blockOrUnBlockStatusCode,
												"redirect" => dirname($_SERVER["PHP_SELF"])
											]);

											$removeLink = Controller::makeControllerUrl("orders", CONTROLLER_ORDER_STATUS_REMOVE, [
												"user" => $account->id,
												"order" => $order->id,
												"redirect" => dirname($_SERVER["PHP_SELF"])
											]);
										?>
										<a href="<?= $blockOrOpenLink ?>" class="btn btn-sm btn-danger w-100 mb-1"><?= $blockOrUnBlockText ?></a>
										<a href="<?= $removeLink ?>" class="btn btn-sm btn-danger w-100 mb-1">حذف</a>
									</td>
								</tr>
								<?php } ?>

							</tbody>
						</table>
					</div>

					<div class="container-fluid">
						<?= createPagination(OrderRepository::getPageCount(), $page) ?>
					</div>
				</div>
			</div>
		</section>
	</main>

	<?php include __DIR__ . "/../../assets/components/footer.php"; ?>
</body>
</html>
