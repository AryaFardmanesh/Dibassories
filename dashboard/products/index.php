<?php

include __DIR__ . "/../../src/config.php";
include __DIR__ . "/../../assets/components/pagination.php";
include __DIR__ . "/../../src/utils/convert.php";
include __DIR__ . "/../../src/controllers/controller.php";
include __DIR__ . "/../../src/repositories/products.php";
include __DIR__ . "/../../src/services/accounts.php";

$account = AccountService::getAccountFromCookie();
$page = Controller::getRequest("page");

if ($page === null) {
	$page = 1;
}

if ($account === null || $account->role !== ROLE_ADMIN) {
	Controller::redirect(null);
}

$products = ProductRepository::filter(1, PHP_INT_MAX, SORT_NEWEST, null, null, null, null, null);
$productsCount = 0;
$productsOkCount = 0;
$productsBlockCount = 0;
foreach ($products as $product) {
	$productsCount++;
	if ($product->status === STATUS_OK) $productsOkCount++;
	if ($product->status === STATUS_SUSPENDED) $productsBlockCount++;
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
	<title>دیبا اکسسوری - داشبورد - محصولات</title>
</head>
<body>
	<?php include __DIR__ . "/../../assets/components/navbar.php"; ?>
	<?php
		$setActiveLinkForSidebar = 'products';
		include __DIR__ . "/../../assets/components/sidebar.php";
	?>

	<main class="app-content" id="mainContent">
		<div class="d-flex justify-content-between align-items-center mb-4">
			<div class="d-flex align-items-center gap-2">
				<button class="btn btn-outline-primary d-lg-none p-0" aria-controls="appSidebar" aria-expanded="false">
					<img id="mobileSidebarBtn" src="<?= ASSETS_DIR ?>/img/icons/hamburger-button.png" alt="دکمه نوار کناری" width="25" />
				</button>
				<h4 class="mb-0">داشبورد مدیر - محصولات</h4>
			</div>
			<div class="text-muted small">سلام، <?= $account->fname ?> — امروز <span class="show-time"></span></div>
		</div>

		<div class="row g-4">
			<div class="col-md-4">
				<div class="card shadow-sm">
					<div class="card-body">
						<h6 class="mb-1 fw-bold">تعداد محصولات</h6>
						<p class="h4 text-primary mb-0"><?= number_format((float)$productsCount) ?></p>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card shadow-sm">
					<div class="card-body">
						<h6 class="mb-1 fw-bold">تعداد محصولات تایید شده</h6>
						<p class="h4 text-success mb-0"><?= number_format((float)$productsOkCount) ?></p>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card shadow-sm">
					<div class="card-body">
						<h6 class="mb-1 fw-bold">تعداد محصولات معلق</h6>
						<p class="h4 text-warning mb-0"><?= number_format((float)$productsBlockCount) ?></p>
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
									<th>تصویر</th>
									<th>عنوان</th>
									<th>تعداد</th>
									<th>قیمت</th>
									<th>تخفیف</th>
									<th>وضعیت</th>
									<th>اغدام ها</th>
								</tr>
							</thead>
							<tbody>

								<?php
									$i = ($page * PAGINATION_LIMIT) - PAGINATION_LIMIT;
									$products = ProductRepository::filter($page, PAGINATION_LIMIT);
									foreach ($products as $product) {
										if ($product->status === STATUS_SUSPENDED) continue;
										$i++;
								?>
								<tr>
									<td><?= $i ?></td>
									<td>
										<a href="<?= BASE_URL . "/product/" . urlencode($product->name) ?>" class="text-decoration-none">
											<img src="<?= ASSETS_DIR  ?>/img/products/<?= $product->image[0] ?>" width="60" height="60" class="rounded shadow-sm" alt="Product images" />
										</a>
									</td>
									<td><?= $product->name ?></td>
									<td><?= $product->count ?></td>
									<td><?= number_format((float)$product->price) ?></td>
									<td><span class="badge text-bg-warning"><?= $product->offer ?>%</span></td>
									<td><span class="badge bg-<?= convertStatusToColor($product->status) ?>"><?= convertStatusToString($product->status) ?></span></td>
									<td>
										<?php
											$removeOrUndoText = "حذف";
											$removeOrUndo = CONTROLLER_PRODUCT_REMOVE;
											if ($product->status === STATUS_REMOVED) {
												$removeOrUndoText = "بازگردانی";
												$removeOrUndo = CONTROLLER_PRODUCT_RESTORE;
											}

											$blockLink = Controller::makeControllerUrl("products", CONTROLLER_PRODUCT_SUSPEND, [
												"user" => $account->id,
												"product" => $product->id,
												"redirect" => dirname($_SERVER["PHP_SELF"])
											]);
											$removeOrUndoLink = Controller::makeControllerUrl("products", $removeOrUndo, [
												"user" => $account->id,
												"product" => $product->id,
												"redirect" => dirname($_SERVER["PHP_SELF"])
											]);
											$removeLink = Controller::makeControllerUrl("products", CONTROLLER_PRODUCT_REMOVE, [
												"user" => $account->id,
												"product" => $product->id,
												"redirect" => dirname($_SERVER["PHP_SELF"])
											]);
										?>
										<a href="<?= $blockLink ?>" class="btn btn-sm btn-danger w-100 mb-1">معلق</a>
										<a href="<?= $removeOrUndoLink ?>" class="btn btn-sm btn-danger w-100 mb-1"><?= $removeOrUndoText ?></a>
										<?php if ($removeOrUndo === CONTROLLER_PRODUCT_RESTORE) { ?>
										<a href="<?= $removeLink ?>" class="btn btn-sm btn-danger w-100 mb-1">پاک کردن</a>
										<?php } ?>
									</td>
								</tr>
								<?php } ?>

							</tbody>
						</table>
					</div>

					<div class="container-fluid">
						<?= createPagination(ProductRepository::getPageCount(PAGINATION_LIMIT), $page) ?>
					</div>
				</div>
			</div>
		</section>
	</main>

	<?php include __DIR__ . "/../../assets/components/footer.php"; ?>
</body>
</html>
