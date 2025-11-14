<?php include __DIR__ . "/../../src/config.php"; ?>
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
	<title>دیبا اکسسوری - داشبورد - تراکنش ها</title>
</head>
<body>
	<?php include __DIR__ . "/../../assets/components/navbar.php"; ?>
	<?php
		$setActiveLinkForSidebar = 'transactions';
		include __DIR__ . "/../../assets/components/sidebar.php";
	?>

	<main class="app-content" id="mainContent">
		<div class="d-flex justify-content-between align-items-center mb-4">
			<div class="d-flex align-items-center gap-2">
				<button class="btn btn-outline-primary d-lg-none p-0" aria-controls="appSidebar" aria-expanded="false">
					<img id="mobileSidebarBtn" src="<?= ASSETS_DIR ?>/img/icons/hamburger-button.png" alt="دکمه نوار کناری" width="25" />
				</button>
				<h4 class="mb-0">داشبورد مدیر - تراکنش ها</h4>
			</div>
			<div class="text-muted small">سلام، آریا — امروز <span class="show-time"></span></div>
		</div>

		<div class="row g-4">
			<div class="col-md-4">
				<div class="card shadow-sm">
					<div class="card-body">
						<h6 class="mb-1 fw-bold">تعداد تراکنش ها</h6>
						<p class="h4 text-primary mb-0">1,234</p>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card shadow-sm">
					<div class="card-body">
						<h6 class="mb-1 fw-bold">جمع تراکنش ها</h6>
						<p class="h4 text-success mb-0">115,780,000</p>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card shadow-sm">
					<div class="card-body">
						<h6 class="mb-1 fw-bold">جمع تراکنش های امروز</h6>
						<p class="h4 text-warning mb-0">780,000</p>
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
									<th>نام</th>
									<th>شماره کارت</th>
									<th>شماره شبا</th>
									<th>مبلغ</th>
									<th>نوع تراکنش</th>
									<th>وضعیت</th>
									<th>تاریخ</th>
									<th>اغدام ها</th>
								</tr>
							</thead>
							<tbody>

								<tr>
									<td>1</td>
									<td>آریا فردمنش</td>
									<td>5022-2913-6789-1748</td>
									<td>IR-3222291367891748</td>
									<td>14,000,000</td>
									<td><span class="badge text-bg-success">خرید</span></td>
									<td><span class="badge text-bg-success">پرداخت شده</span></td>
									<td>1404/8/19</td>
									<td>
										<a href="#" class="btn btn-sm btn-danger w-100 mb-1">حذف</a>
										<a href="#" class="btn btn-sm btn-danger w-100 mb-1">پرداخت شده</a>
										<a href="#" class="btn btn-sm btn-danger w-100 mb-1">باز</a>
										<a href="#" class="btn btn-sm btn-danger w-100 mb-1">معلق</a>
									</td>
								</tr>

							</tbody>
						</table>
					</div>

					<div class="container-fluid">
						<nav>
							<ul class="pagination justify-content-center flex-wrap gap-2">
								<li class="page-item disabled">
									<a class="page-link rounded-3" href="#" tabindex="-1" aria-disabled="true">قبلی</a>
								</li>

								<li class="page-item active" aria-current="page">
									<a class="page-link rounded-3" href="#">1</a>
								</li>
								<li class="page-item">
									<a class="page-link rounded-3" href="#">2</a>
								</li>
								<li class="page-item">
									<a class="page-link rounded-3" href="#">3</a>
								</li>

								<li class="page-item">
									<span class="page-link border-0 bg-transparent text-muted">...</span>
								</li>

								<li class="page-item">
									<a class="page-link rounded-3" href="#">10</a>
								</li>

								<li class="page-item">
									<a class="page-link rounded-3" href="#">بعدی</a>
								</li>
							</ul>
						</nav>
					</div>
				</div>
			</div>
		</section>
	</main>

	<?php include __DIR__ . "/../../assets/components/footer.php"; ?>
</body>
</html>
