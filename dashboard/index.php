<?php include __DIR__ . "/../src/config.php"; ?>
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
	<title>دیبا اکسسوری - داشبورد</title>
</head>
<body>
	<?php include __DIR__ . "/../assets/components/navbar.php"; ?>
	<?php
		$setActiveLinkForSidebar = 'docs';
		include __DIR__ . "/../assets/components/sidebar.php";
	?>

	<main class="app-content" id="mainContent">
		<div class="d-flex justify-content-between align-items-center mb-4">
			<div class="d-flex align-items-center gap-2">
				<button class="btn btn-outline-primary d-lg-none p-0" aria-controls="appSidebar" aria-expanded="false">
					<img id="mobileSidebarBtn" src="<?= ASSETS_DIR ?>/img/icons/hamburger-button.png" alt="دکمه نوار کناری" width="25" />
				</button>
				<h4 class="mb-0">داشبورد مدیر</h4>
			</div>
			<div class="text-muted small">سلام، آریا — امروز <span class="show-time">۱۴۰۳/۰۸/۲۵</span></div>
		</div>

		<div class="row g-4">
			<div class="col-md-4">
				<div class="card shadow-sm">
					<div class="card-body">
						<h6 class="mb-1 fw-bold">تعداد کاربران</h6>
						<p class="h4 text-primary mb-0">1,234</p>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card shadow-sm">
					<div class="card-body">
						<h6 class="mb-1 fw-bold">محصولات</h6>
						<p class="h4 text-success mb-0">356</p>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card shadow-sm">
					<div class="card-body">
						<h6 class="mb-1 fw-bold">سفارش‌های در انتظار</h6>
						<p class="h4 text-warning mb-0">12</p>
					</div>
				</div>
			</div>
		</div>

		<hr />

		<section class="container my-5">
			<div class="card shadow-sm border-0 rounded-4">
				<div class="card-body p-4 p-md-5">
					<h2 class="fw-bold text-center mb-4 text-primary">درباره پروژه</h2>
					<p class="text-muted lh-lg mb-4 text-justify">
						این وب‌سایت با عنوان <strong>دیبا اکسسوری (Dibassories)</strong> به‌عنوان یک پروژه دانشگاهی طراحی و توسعه داده شده است. هدف اصلی این پروژه، پیاده‌سازی یک سامانه فروش آنلاین برای اکسسوری‌ها مانند گردنبند، دستبند، انگشتر و گوشواره است تا مفاهیم طراحی رابط کاربری، پایگاه داده، منطق سمت سرور و تعامل کاربر با سیستم به‌صورت عملی نمایش داده شوند.
					</p>
					<p class="text-muted lh-lg mb-4 text-justify">
						در این پروژه تلاش شده است با استفاده از فناوری‌های پایه و استاندارد وب، یک ساختار تمیز، قابل‌فهم و کاربردی ایجاد شود که نه‌تنها برای اهداف آموزشی، بلکه به‌عنوان یک نمونه‌ی واقعی از پیاده‌سازی سیستم‌های فروشگاهی ساده نیز قابل استفاده باشد.
					</p>
					<div class="mb-4">
						<h5 class="fw-semibold text-secondary mb-3">
							فناوری‌های مورد استفاده:
						</h5>
						<ul class="list-group list-group-flush" style="direction: ltr;">
							<li class="list-group-item border-0">
								<strong>Front-End:</strong>
								<ul class="list-group">
									<li>HTML</li>
									<li>CSS</li>
									<li>JavaScript</li>
									<li>Bootstrap 5.3 (RTL)</li>
									<li>jQuery 3.7.1</li>
								</ul>
							</li>
							<li class="list-group-item border-0">
								<strong>Back-End:</strong>
								<ul class="list-group">
									<li>PHP (Vanilla)</li>
								</ul>
							</li>
							<li class="list-group-item border-0">
								<strong>Database:</strong>
								<ul class="list-group">
									<li>MySQL (With PhpMyAdmin)</li>
								</ul>
							</li>
						</ul>
					</div>
					<div class="text-center mt-4">
						<p class="fw-bold mb-1 text-dark">توسعه‌دهنده پروژه:</p>
						<p class="text-muted mb-0">آریا فردمنش</p>
						<span class="badge bg-light text-secondary border mt-2 px-3 py-2">
						مخزن گیت هاب: <a href="https://github.com/AryaFardmanesh/Dibassories/">GitHub</a>
						</span>
						<span class="badge bg-light text-secondary border mt-2 px-3 py-2">
						مجوز پروژه: MIT License
						</span>
					</div>
				</div>
			</div>
		</section>
	</main>

	<?php include __DIR__ . "/../assets/components/footer.php"; ?>
</body>
</html>
