<?php include __DIR__ . "/../src/config.php"; ?>
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
	<title>دیبا اکسسوری - محصولات</title>
	<style>
	/* Products Filters */
	form.card {
		border-radius: 1rem;
	}

	form label {
		color: #333;
		font-size: 0.9rem;
	}

	form input,
	form select {
		border-radius: 0.6rem;
		border: 1px solid #ccc;
	}

	form input:focus,
	form select:focus {
		border-color: #0d6efd;
		box-shadow: 0 0 0 0.15rem rgba(13, 110, 253, 0.15);
	}

	button.btn-dark {
		border-radius: 0.6rem;
		transition: all 0.2s ease-in-out;
	}

	button.btn-dark:hover {
		background-color: #212529;
		transform: translateY(-2px);
	}

	/* Products card */
	.product-card {
		transition: all 0.2s ease-in-out;
		border-radius: 0.75rem;
	}
	.product-card:hover {
		transform: translateY(-5px);
		box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
	}
	.card-img-top {
		height: 180px;
		object-fit: contain;
	}

	/* Pagination */
	.pagination .page-link {
		color: #212529;
		border: 1px solid #dee2e6;
		transition: all 0.2s ease-in-out;
		padding: 0.55rem 0.95rem;
		font-weight: 500;
	}

	.pagination .page-link:hover {
		color: #fff;
		background-color: #0d6efd;
		border-color: #0d6efd;
	}

	.pagination .page-item.active .page-link {
		background-color: #0d6efd;
		border-color: #0d6efd;
		color: #fff;
	}

	.pagination .page-item.disabled .page-link {
		color: #adb5bd;
		background-color: #f8f9fa;
		border-color: #dee2e6;
	}

	.pagination .page-link:focus {
		box-shadow: 0 0 0 0.15rem rgba(13, 110, 253, 0.25);
	}
	</style>
</head>
<body>
	<?php include __DIR__ . "/../assets/components/navbar.php"; ?>

	<section class="container-fluid my-5">
		<form action="<?= BASE_URL ?>/products/" method="GET" class="card shadow-sm p-4 border-0 rounded-4 bg-light">
			<div class="row g-3 align-items-end">

				<div class="col-12 col-md-4 col-lg-3">
					<label for="search" class="form-label fw-semibold">جست‌وجوی محصول</label>
					<input type="text" class="form-control" id="search" name="search" placeholder="نام محصول را وارد کنید...">
				</div>

				<div class="col-12 col-md-4 col-lg-3">
					<label for="category" class="form-label fw-semibold">نوع محصول</label>
					<select class="form-select" id="category" name="category">
						<option value="all">همه</option>
						<option value="necklace">گردنبند</option>
						<option value="ring">انگشتر</option>
						<option value="earring">گوشواره</option>
					</select>
				</div>

				<div class="col-6 col-md-2 col-lg-2">
					<label for="price_min" class="form-label fw-semibold">حداقل قیمت</label>
					<input type="number" class="form-control" id="price_min" name="price_min" placeholder="مثلاً 100000">
				</div>
				<div class="col-6 col-md-2 col-lg-2">
					<label for="price_max" class="form-label fw-semibold">حداکثر قیمت</label>
					<input type="number" class="form-control" id="price_max" name="price_max" placeholder="مثلاً 500000">
				</div>

				<div class="col-12 col-md-4 col-lg-2">
					<label for="sort" class="form-label fw-semibold">مرتب‌سازی بر اساس</label>
					<select class="form-select" id="sort" name="sort">
						<option value="newest">جدیدترین</option>
						<option value="cheapest">ارزان‌ترین</option>
						<option value="expensive">گران‌ترین</option>
						<option value="discount">بیشترین تخفیف</option>
					</select>
				</div>

				<div class="col-12 col-md-3 col-lg-2 text-center mt-3 mt-md-2">
					<button type="submit" class="btn btn-dark w-100 py-2 fw-semibold">فیلتر کن</button>
				</div>
			</div>
		</form>
	</section>

	<section class="container-fluid my-5 px-3">
		<div class="row g-3">

			<div class="col-12 col-sm-6 col-md-4 col-lg-3">
				<a href="#" class="text-decoration-none text-dark">
					<div class="card border-0 shadow-sm h-100 product-card">
						<img src="<?= ASSETS_DIR ?>/img/products/1.jpg" class="card-img-top p-3" alt="گردنبند نقره">
						<div class="card-body pt-0">
							<div class="d-flex justify-content-between align-items-center mb-2">
								<h6 class="fw-bold mb-0 text-truncate" title="گردنبند نقره زنانه">گردنبند نقره زنانه</h6>
								<span class="badge bg-light text-secondary border">گردنبند</span>
							</div>
							<div class="d-flex justify-content-between align-items-center">
								<div>
									<span class="text-muted text-decoration-line-through small">۴۵۰,۰۰۰</span>
									<span class="text-danger fw-bold ms-1">۳۵۰,۰۰۰</span>
								</div>
								<div class="text-end">
									<span class="badge bg-danger text-white">٪۲۲ تخفیف</span>
									<span class="badge bg-light text-dark border ms-1">تومان</span>
								</div>
							</div>
						</div>
					</div>
				</a>
			</div>

			<div class="col-12 col-sm-6 col-md-4 col-lg-3">
				<a href="#" class="text-decoration-none text-dark">
					<div class="card border-0 shadow-sm h-100 product-card">
						<img src="<?= ASSETS_DIR ?>/img/products/2.jpg" class="card-img-top p-3" alt="انگشتر استیل">
						<div class="card-body pt-0">
							<div class="d-flex justify-content-between align-items-center mb-2">
								<h6 class="fw-bold mb-0 text-truncate" title="انگشتر استیل مردانه">انگشتر استیل مردانه</h6>
								<span class="badge bg-light text-secondary border">انگشتر</span>
							</div>
							<div class="d-flex justify-content-between align-items-center">
								<div>
									<span class="fw-bold text-dark">۱۸۰,۰۰۰</span>
								</div>
								<div>
									<span class="badge bg-light text-dark border">تومان</span>
								</div>
							</div>
						</div>
					</div>
				</a>
			</div>

			<div class="col-12 col-sm-6 col-md-4 col-lg-3">
				<a href="#" class="text-decoration-none text-dark">
					<div class="card border-0 shadow-sm h-100 product-card">
						<img src="<?= ASSETS_DIR ?>/img/products/3.jpg" class="card-img-top p-3" alt="گوشواره طلایی">
						<div class="card-body pt-0">
							<div class="d-flex justify-content-between align-items-center mb-2">
								<h6 class="fw-bold mb-0 text-truncate" title="گوشواره طلایی مدل کلاسیک">گوشواره طلایی مدل کلاسیک</h6>
								<span class="badge bg-light text-secondary border">گوشواره</span>
							</div>
							<div class="d-flex justify-content-between align-items-center">
								<div>
									<span class="text-muted text-decoration-line-through small">۲۷۰,۰۰۰</span>
									<span class="text-danger fw-bold ms-1">۲۲۰,۰۰۰</span>
								</div>
								<div class="text-end">
									<span class="badge bg-danger text-white">٪۱۸ تخفیف</span>
									<span class="badge bg-light text-dark border ms-1">تومان</span>
								</div>
							</div>
						</div>
					</div>
				</a>
			</div>

		</div>
	</section>

	<section class="container my-5">
		<nav aria-label="صفحه‌بندی محصولات">
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
	</section>

	<?php include __DIR__ . "/../assets/components/footer.php"; ?>
</body>
</html>
