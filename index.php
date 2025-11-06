<?php include __DIR__ . "/src/config.php"; ?>
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
	<title>Homepage</title>
	<style>
	.carousel-caption h3 {
		font-size: 1.75rem;
	}

	.carousel-caption p {
		font-size: 1rem;
	}

	@media (max-width: 768px) {
		.carousel-caption {
			font-size: 0.9rem;
			padding: 1rem;
		}
		.carousel-caption h3 {
			font-size: 1.25rem;
		}
		.carousel-caption p {
			display: none;
		}
	}
	</style>
</head>
<body>
	<?php include __DIR__ . "/assets/components/navbar.php"; ?>

	<div id="mainCarousel" class="carousel slide" data-bs-ride="carousel">
		<!-- Dots control -->
		<div class="carousel-indicators">
			<button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="اسلاید ۱"></button>
			<button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="1" aria-label="اسلاید ۲"></button>
			<button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="2" aria-label="اسلاید ۳"></button>
		</div>

		<!-- Sliders -->
		<div class="carousel-inner shadow-lg">
			<div class="carousel-item active">
				<img src="<?= ASSETS_DIR ?>/img/sliders/1.jpg" class="d-block w-100" alt="اکسسوری‌های جدید" style="object-fit: cover; height: 550px;">
				<div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded-3 p-3">
					<h3 class="fw-bold">مجموعه جدید اکسسوری‌ها</h3>
					<p>جدیدترین مدل‌های گردنبند و دستبند با طراحی خاص و منحصربه‌فرد</p>
				</div>
			</div>

			<div class="carousel-item">
				<img src="<?= ASSETS_DIR ?>/img/sliders/2.jpg" class="d-block w-100" alt="تخفیف ویژه" style="object-fit: cover; height: 550px;">
				<div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded-3 p-3">
					<h3 class="fw-bold">تخفیف‌های ویژه این هفته</h3>
					<p>تا ۵۰٪ تخفیف برای خرید‌های آنلاین</p>
				</div>
			</div>

			<div class="carousel-item">
				<img src="<?= ASSETS_DIR ?>/img/sliders/3.jpg" class="d-block w-100" alt="جواهرات خاص" style="object-fit: cover; height: 550px;">
				<div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded-3 p-3">
					<h3 class="fw-bold">زیبایی در جزئیات</h3>
					<p>اکسسوری‌هایی برای هر استایل و سلیقه</p>
				</div>
			</div>
		</div>

		<!-- Control buttons -->
		<button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
			<span class="carousel-control-prev-icon bg-dark rounded-circle p-2" aria-hidden="true"></span>
			<span class="visually-hidden">قبلی</span>
		</button>
		<button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
			<span class="carousel-control-next-icon bg-dark rounded-circle p-2" aria-hidden="true"></span>
			<span class="visually-hidden">بعدی</span>
		</button>
	</div>

	<?php include __DIR__ . "/assets/components/footer.php"; ?>
</body>
</html>
