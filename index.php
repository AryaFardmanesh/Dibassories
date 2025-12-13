<?php

include __DIR__ . "/src/config.php";
include __DIR__ . "/src/repositories/products.php";

$newestProducts = ProductRepository::filter(1, PAGINATION_LIMIT, SORT_NEWEST);
$mostOfferProducts = ProductRepository::filter(1, PAGINATION_LIMIT, SORT_MOST_OFFER);

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
	<title>Homepage</title>
	<style>
	/* Header Slider */
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

	/* Products slider */
	.product-slider::-webkit-scrollbar {
		height: 8px;
	}

	.product-slider::-webkit-scrollbar-thumb {
		background-color: rgba(0, 0, 0, 0.2);
		border-radius: 4px;
	}

	.product-card img {
		height: 180px;
		object-fit: cover;
		border-top-left-radius: 0.5rem;
		border-top-right-radius: 0.5rem;
	}

	.product-card:hover {
		transform: translateY(-5px);
		transition: all 0.3s ease;
		box-shadow: 0 4px 12px rgba(0,0,0,0.15);
	}
	</style>
</head>
<body>
	<?php include __DIR__ . "/assets/components/navbar.php"; ?>

	<!-- Header Slider -->
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

	<!-- Homepage Contents -->
	<section class="text-center mt-5 mb-5 container">
		<div class="mb-5">
			<h2 class="fw-bold mb-3">محصولات ما</h2>
			<p class="text-muted mb-0">
				برای دیدن محصولات بیشتر به <a href="#" class="text-decoration-none fw-semibold">بخش محصولات</a> بروید.
			</p>
		</div>

		<div id="aboutus" class="mt-5">
			<h2 class="fw-bold mb-3">درباره ما</h2>
			<p class="text-muted px-md-3">
				این وب‌سایت به عنوان یک پروژه دانشگاهی طراحی شده است و هدف آن پیاده‌سازی یک پلتفرم ساده برای خرید و فروش اکسسوری‌ها است. در این پروژه تلاش شده تا با استفاده از فناوری‌های پایه وب مانند <strong>HTML</strong>، <strong>CSS</strong>، <strong>JavaScript</strong>، <strong>PHP</strong> و <strong>MySQL</strong>، یک سیستم کاربرپسند و کاربردی ایجاد شود که مفاهیم طراحی رابط کاربری، پایگاه داده و تعامل کاربر با سیستم را به‌صورت عملی نشان دهد.
			</p>
		</div>
	</section>

	<!-- Cards -->
	<section class="container my-5 text-center">
		<h2 class="fw-bold mb-4">چرا ما را انتخاب کنید؟</h2>

		<div class="row g-4">

			<div class="col-md-4">
				<div class="card h-100 shadow-sm border-0">
					<div class="card-body">
						<div class="mb-3">
							<i class="bi bi-bag-check fs-1 text-primary"></i>
						</div>
						<h5 class="card-title fw-bold mb-3">خرید آسان و سریع</h5>
						<p class="card-text text-muted">
							با رابط کاربری ساده و روان، کاربران می‌توانند به راحتی محصولات مورد نظر خود را پیدا کرده و خریداری کنند.
						</p>
					</div>
				</div>
			</div>

			<div class="col-md-4">
				<div class="card h-100 shadow-sm border-0">
					<div class="card-body">
						<div class="mb-3">
							<i class="bi bi-gem fs-1 text-success"></i>
						</div>
						<h5 class="card-title fw-bold mb-3">محصولات با کیفیت</h5>
						<p class="card-text text-muted">
							تمامی اکسسوری‌ها با کیفیت بالا و از فروشندگان معتبر ارائه می‌شوند تا رضایت شما تضمین شود.
						</p>
					</div>
				</div>
			</div>

			<!-- Feature 3 -->
			<div class="col-md-4">
				<div class="card h-100 shadow-sm border-0">
					<div class="card-body">
						<div class="mb-3">
							<i class="bi bi-shield-check fs-1 text-danger"></i>
						</div>
						<h5 class="card-title fw-bold mb-3">امنیت و اعتماد</h5>
						<p class="card-text text-muted">
							اطلاعات کاربران با دقت محافظت می‌شود و تمامی تراکنش‌ها در بستری امن انجام می‌گردد.
						</p>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Products Slider -->
	<section class="container my-5">
		<div class="d-flex justify-content-between align-items-center mb-3">
			<h4 class="fw-bold mb-0">محصولات جدید</h4>
			<a href="#" class="text-decoration-none text-primary small">مشاهده همه</a>
		</div>

		<div class="product-slider d-flex flex-row flex-nowrap overflow-auto pb-3">

			<?php
				foreach ($newestProducts as $product) {
			?>
			<div class="card product-card me-3 shadow-sm border-0" style="min-width: 220px;">
				<img src="<?= ASSETS_DIR ?>/img/products/<?= $product->image[0] ?>" class="card-img-top" alt="<?= $product->name ?>">
				<div class="card-body text-center">
					<h6 class="card-title fw-semibold text-truncate"><?= $product->name ?></h6>
					<p class="text-muted mb-2"><?= number_format((float)$product->price) ?> تومان</p>
					<a href="<?= BASE_URL ?>/product/<?= urlencode($product->name) ?>/" class="btn btn-outline-primary btn-sm">مشاهده محصول</a>
				</div>
			</div>
			<?php
				}
			?>

		</div>
	</section>

	<!-- Products Slider (Offers) -->
	<section class="container my-5">
		<div class="d-flex justify-content-between align-items-center mb-3">
			<h4 class="fw-bold mb-0">بیشترین تخفیف ها</h4>
			<a href="#" class="text-decoration-none text-primary small">مشاهده همه</a>
		</div>

		<div class="product-slider d-flex flex-row flex-nowrap overflow-auto pb-3">

			<?php
				foreach ($mostOfferProducts as $product) {
			?>
			<div class="card product-card me-3 shadow-sm border-0" style="min-width: 220px;">
				<img src="<?= ASSETS_DIR ?>/img/products/<?= $product->image[0] ?>" class="card-img-top" alt="محصول ۱">
				<span class="badge bg-danger position-absolute" style="top: 10px; left: 10px;"><?= $product->offer ?>%</span>
				<div class="card-body text-center">
					<h6 class="card-title fw-semibold text-truncate"><?= $product->name ?></h6>
					<p class="text-muted"><?= number_format((float)$product->price) ?> تومان</p>
					<a href="<?= BASE_URL ?>/product/<?= urlencode($product->name) ?>/" class="btn btn-outline-primary btn-sm">مشاهده محصول</a>
				</div>
			</div>
			<?php
				}
			?>

		</div>
	</section>

	<?php include __DIR__ . "/assets/components/footer.php"; ?>
</body>
</html>
