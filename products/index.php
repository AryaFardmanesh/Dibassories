<?php

include __DIR__ . "/../src/config.php";
include __DIR__ . "/../src/utils/convert.php";
include __DIR__ . "/../src/repositories/products.php";
include __DIR__ . "/../src/controllers/controller.php";
include __DIR__ . "/../assets/components/pagination.php";

$page = Controller::getRequest("page");
$sort = Controller::getRequest("sort");
$name = Controller::getRequest("name");
$type = Controller::getRequest("type");
$minPrice = Controller::getRequest("min-price");
$maxPrice = Controller::getRequest("max-price");

$page = ($page !== null && $page !== "") ? (int)$page : 1;
$sort = ($sort !== null && $sort !== "") ? (int)$sort : SORT_NEWEST;
$name = ($name !== null && $name !== "") ? $name : null;
$type = ($type !== null && $type !== "") ? (int)$type : null;
$minPrice = ($minPrice !== null && $minPrice !== "") ? (int)$minPrice : null;
$maxPrice = ($maxPrice !== null && $maxPrice !== "") ? (int)$maxPrice : null;

$products = ProductRepository::filter($page, PAGINATION_LIMIT, $sort, $name, $type, $minPrice, $maxPrice);

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
		<form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="GET" class="card shadow-sm p-4 border-0 rounded-4 bg-light">
			<div class="row g-3 align-items-end">

				<div class="col-12 col-md-4 col-lg-3">
					<label for="name" class="form-label fw-semibold">جست‌وجوی محصول</label>
					<input type="text" class="form-control" id="name" name="name" value="<?= $name ?>" placeholder="نام محصول را وارد کنید...">
				</div>

				<div class="col-12 col-md-4 col-lg-3">
					<label for="type" class="form-label fw-semibold">نوع محصول</label>
					<select class="form-select" id="type" name="type">
						<option <?= $type === null ? "selected" : null ?> value="">همه</option>
						<option <?= $type === PRODUCT_TYPE_RING ? "selected" : null ?> value="<?= PRODUCT_TYPE_RING ?>">انگشتر</option>
						<option <?= $type === PRODUCT_TYPE_NECKLACE ? "selected" : null ?> value="<?= PRODUCT_TYPE_NECKLACE ?>">گردنبند</option>
						<option <?= $type === PRODUCT_TYPE_EARRING ? "selected" : null ?> value="<?= PRODUCT_TYPE_EARRING ?>">گوشواره</option>
					</select>
				</div>

				<div class="col-6 col-md-2 col-lg-2">
					<label for="min-price" class="form-label fw-semibold">حداقل قیمت</label>
					<input type="number" class="form-control" id="min-price" name="min-price" value="<?= $minPrice ?>" placeholder="مثلاً 100000">
				</div>
				<div class="col-6 col-md-2 col-lg-2">
					<label for="max-price" class="form-label fw-semibold">حداکثر قیمت</label>
					<input type="number" class="form-control" id="max-price" name="max-price" value="<?= $maxPrice ?>" placeholder="مثلاً 500000">
				</div>

				<div class="col-12 col-md-4 col-lg-2">
					<label for="sort" class="form-label fw-semibold">مرتب‌سازی بر اساس</label>
					<select class="form-select" id="sort" name="sort">
						<option <?= $sort === SORT_NEWEST ? "selected" : null ?> value="<?= SORT_NEWEST ?>">جدیدترین</option>
						<option <?= $sort === SORT_CHEAPEST ? "selected" : null ?> value="<?= SORT_CHEAPEST ?>">ارزان‌ترین</option>
						<option <?= $sort === SORT_EXPENSIVE ? "selected" : null ?> value="<?= SORT_EXPENSIVE ?>">گران‌ترین</option>
						<option <?= $sort === SORT_MOST_OFFER ? "selected" : null ?> value="<?= SORT_MOST_OFFER ?>">بیشترین تخفیف</option>
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

			<?php
				foreach ($products as $product) {
			?>
			<div class="col-12 col-sm-6 col-md-4 col-lg-3">
				<a href="<?= BASE_URL . "/product/" . urlencode($product->name) ?>" class="text-decoration-none text-dark">
					<div class="card border-0 shadow-sm h-100 product-card">
						<img src="<?= ASSETS_DIR ?>/img/products/<?= $product->image[0] ?>" class="card-img-top p-3" alt="<?= $product->name ?>">
						<div class="card-body pt-0">
							<div class="d-flex justify-content-between align-items-center mb-2">
								<h6 class="fw-bold mb-0 text-truncate" title="<?= $product->name ?>"><?= $product->name ?></h6>
								<span class="badge bg-light text-secondary border"><?= convertProductTypesToString($product->type) ?></span>
							</div>
							<div class="d-flex justify-content-between align-items-center">
								<?php if ($product->offer !== 0) { ?>
								<div>
									<span class="text-muted text-decoration-line-through small"><?= number_format((float)$product->price) ?></span>
									<span class="text-danger fw-bold ms-1"><?= number_format((float)$product->price - ($product->price * $product->offer / 100)) ?></span>
								</div>
								<div class="text-end">
									<span class="badge bg-danger text-white">٪<?= $product->offer ?> تخفیف</span>
									<span class="badge bg-light text-dark border ms-1">تومان</span>
								</div>
								<?php }else { ?>
								<div>
									<span class="text-muted"><?= number_format((float)$product->price) ?></span>
								</div>
								<div class="text-end">
									<span class="badge bg-light text-dark border ms-1">تومان</span>
								</div>
								<?php } ?>
							</div>
						</div>
					</div>
				</a>
			</div>
			<?php
				}
			?>

		</div>
	</section>

	<section class="container my-5">
		<?php
			$pageCount = $pageCount = ProductRepository::getPageCount(PAGINATION_LIMIT, STATUS_OK, $name, $type, $minPrice, $maxPrice);
			echo createPagination($pageCount, $page);
		?>
	</section>

	<?php include __DIR__ . "/../assets/components/footer.php"; ?>
</body>
</html>
