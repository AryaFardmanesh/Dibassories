<?php

include __DIR__ . "/../src/config.php";
include __DIR__ . "/../src/utils/convert.php";
include __DIR__ . "/../src/services/accounts.php";
include __DIR__ . "/../src/services/products.php";
include __DIR__ . "/../src/repositories/carts.php";
include __DIR__ . "/../src/controllers/controller.php";

$slug = Controller::getRequest("slug", true);
$error = Controller::getRequest("error");

$account = AccountService::getAccountFromCookie();
if (AccountRepository::hasError()) {
	$error = AccountRepository::getError();
}

$product = ProductService::findBySlug($slug);
if (ProductRepository::hasError()) {
	$error = ProductRepository::getError();
}

if ($product === null) {
	Controller::redirect(BASE_URL . "/products/");
}

$cart = [];
$prodCart = null;
$inCart = false;
$inCartColor = null;
$inCartMaterial = null;
$inCartSize = null;

if ($account !== null) {
	$cart = ShoppingCartRepository::find($account->id);
	if (ShoppingCartRepository::hasError()) {
		$error = ProductRepository::getError();
	}
}

foreach ($cart as $prod) {
	if ($prod->product === $product->product->id) {
		$prodCart = $prod;
		$inCart = true;
		$inCartColor = $prod->product_color;
		$inCartMaterial = $prod->product_material;
		$inCartSize = $prod->product_size;
		break;
	}
}

$shoppingLink = BASE_URL . "/login/";

if ($account !== null) {
	$shoppingLink = SRC_DIR . "/controllers/carts.php";
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
	<title>دیبا اکسسوری - محصول</title>
	<style>
	.btn-check:checked + .btn {
		border-color: #0d6efd !important;
		background-color: #e7f1ff;
		color: #0d6efd !important;
	}

	label[for^="color"] {
		cursor: pointer;
		transition: transform 0.2s ease-in-out;
	}

	label[for^="color"]:hover {
		transform: scale(1.1);
	}

	.btn-outline-secondary:hover {
		background-color: #0d6efd;
		color: #fff !important;
		border-color: #0d6efd;
	}

	.thumb-img {
		transition: all 0.3s ease;
	}

	.thumb-img:hover {
		transform: scale(1.08);
		border-color: #0d6efd !important;
	}

	.thumb-img.active {
		border-color: #0d6efd !important;
		box-shadow: 0 0 8px rgba(13, 110, 253, 0.4);
	}
	</style>
</head>
<body>
	<?php include __DIR__ . "/../assets/components/navbar.php"; ?>

	<section class="container my-5">
		<div class="row align-items-start">

			<div class="col-lg-5 col-md-6 text-center">
				<div class="border rounded-4 p-3 shadow-sm bg-white">
					<img src="<?= ASSETS_DIR ?>/img/products/1.jpg" alt="تصویر محصول" class="img-fluid rounded-3" style="max-height: 400px; object-fit: contain;">
				</div>
			</div>

			<div class="col-lg-7 col-md-6">
				<form action="<?= $shoppingLink ?>" method="GET" class="border rounded-4 p-4 shadow-sm bg-white">
					<?php if ($error !== null) echo "<div class='alert alert-danger'>$error</div>" ?>

					<input type="hidden" name="req" value="<?= CONTROLLER_CART_ADD_CART ?>" />
					<input type="hidden" name="user" value="<?= $account !== null ? $account->id : null ?>" />
					<input type="hidden" name="product" value="<?= $product->product->id ?>" />
					<input type="hidden" name="count" value="1" />
					<input type="hidden" name="redirect" value="<?= BASE_URL . "/product/" . urlencode($slug) ?>" />

					<div class="d-flex align-items-center gap-2 mb-3">
						<span class="fw-block d-block mb-2"><?= convertProductTypesToString($product->product->type) ?></span>
						<span class="fw-block d-block mb-2">/</span>
						<h2 class="fw-bold fs-6"><?= $product->product->name ?></h2>
					</div>

					<p class="text-muted mb-4"><?= $product->product->description ?></p>

					<div class="d-flex flex-wrap gap-3 mb-3">
						<span class="badge bg-primary px-3 py-2">نوع: <?= convertProductTypesToString($product->product->type) ?></span>
						<span class="badge bg-success px-3 py-2">موجودی: <?= $product->product->count ?> عدد</span>
					</div>

					<div class="mb-4">
						<?php if ($product->product->offer === 0) { ?>
							<span class="text-muted fs-3"><?= $product->product->price ?> تومان</span>
						<?php }else { ?>
							<span class="text-decoration-line-through text-muted fs-5"><?= $product->product->price ?> تومان</span>
							<span class="fs-3 fw-bold text-danger ms-3"><?= $product->product->price - ($product->product->price * $product->product->offer / 100); ?> تومان</span>
							<span class="badge bg-danger">٪<?= $product->product->offer ?> تخفیف</span>
						<?php } ?>
						</div>

					<div class="mb-4">
						<label class="fw-semibold mb-2 d-block">انتخاب رنگ:</label>
						<div class="d-flex gap-2">
							<?php
								$i = 0;
								foreach ($product->colors as $color) {
									$i++;
							?>
							<input type="radio" class="btn-check" name="color" value="<?= $color->id ?>" id="color-<?= $i ?>" autocomplete="off" <?= $inCartColor === $color->id || $i === 1 ? "checked" : null ?>>
							<label class="btn border rounded-circle p-3" for="color-<?= $i ?>" style="background-color: #<?= $color->hex ?>;"></label>
							<?php } ?>
						</div>
					</div>

					<div class="mb-4">
						<label class="fw-semibold mb-2 d-block">انتخاب جنس:</label>
						<div class="d-flex flex-wrap gap-2">
							<?php
								$i = 0;
								foreach ($product->materials as $material) {
									$i++;
							?>
							<input type="radio" class="btn-check" name="material" value="<?= $material->id ?>" id="mat-<?= $i ?>" autocomplete="off" <?= $inCartMaterial === $material->id || $i === 1 ? "checked" : null ?>>
							<label class="btn btn-outline-secondary px-4 py-2" for="mat-<?= $i ?>"><?= $material->material ?></label>
							<?php } ?>
						</div>
					</div>

					<div class="mb-4">
						<label class="fw-semibold mb-2 d-block">انتخاب سایز:</label>
						<div class="d-flex flex-wrap gap-2">
							<?php
								$i = 0;
								foreach ($product->sizes as $size) {
									$i++;
							?>
							<input type="radio" class="btn-check" name="size" value="<?= $size->id ?>" id="size-<?= $i ?>" autocomplete="off" <?= $inCartSize === $size->id || $i === 1 ? "checked" : null ?>>
							<label class="btn btn-outline-secondary px-3 py-2" for="size-<?= $i ?>"><?= $size->size ?></label>
							<?php } ?>
						</div>
					</div>

					<div class="mt-4">
						<?php
						if ($inCart) {
						?>
							<div class="mb-3">
								<span>تعداد در سبد خرید:</span>
								<span class="badge text-bg-success"><?= $prodCart->count ?></span>
							</div>
							<div class="d-flex gap-1">
								<?php
								$incLink = Controller::makeControllerUrl("carts", CONTROLLER_CART_INC_PRODUCT_COUNT, [
									"user" => $account->id,
									"cart" => $prodCart->id,
									"product" => $product->product->id,
									"redirect" => BASE_URL . "/product/" . urlencode($slug)
								]);
								$decLink = Controller::makeControllerUrl("carts", CONTROLLER_CART_DEC_PRODUCT_COUNT, [
									"user" => $account->id,
									"cart" => $prodCart->id,
									"product" => $product->product->id,
									"redirect" => BASE_URL . "/product/" . urlencode($slug)
								]);
								$delLink = Controller::makeControllerUrl("carts", CONTROLLER_CART_REMOVE_CART, [
									"user" => $account->id,
									"product" => $product->product->id,
									"redirect" => BASE_URL . "/product/" . urlencode($slug)
								]);
								?>
								<a href="<?= $incLink ?>" class="btn btn-sm btn-outline-success w-25 py-3 fw-bold">+</a>
								<a href="<?= $delLink ?>" class="btn btn-sm btn-danger w-100 py-3 fw-bold">حذف 🗑️</a>
								<a href="<?= $decLink ?>" class="btn btn-sm btn-outline-success w-25 py-3 fw-bold">-</a>
							</div>
						<?php }else { ?>
							<button type="submit" class="btn btn-sm btn-primary w-100 py-3 fw-bold">افزودن به سبد خرید 🛒</button>
						<?php } ?>
					</div>
				</form>
			</div>
		</div>
	</section>

	<section class="container my-5">
		<h3 class="fw-bold mb-4 text-center">تصاویر محصول</h3>
	
		<div class="row g-3 justify-content-center">

			<div class="col-12 text-center">
				<img id="mainImage" src="<?= ASSETS_DIR ?>/img/products/<?= $product->product->image[0] ?>" class="img-fluid rounded-4 shadow-sm" style="max-height: 450px; object-fit: contain; cursor: zoom-in;" alt="تصویر اصلی محصول" data-bs-toggle="modal" data-bs-target="#imageModal">
			</div>

			<div class="col-12 d-flex justify-content-center gap-3 flex-wrap mt-3">
				<?php foreach ($product->product->image as $img) { ?>
					<img src="<?= ASSETS_DIR ?>/img/products/<?= $img ?>" class="thumb-img rounded-3 border border-2 border-primary" style="width: 90px; height: 90px; object-fit: cover; cursor: pointer;">
				<?php } ?>
			</div>

		</div>

		<div class="modal fade" id="imageModal" tabindex="-1">
			<div class="modal-dialog modal-dialog-centered modal-lg">
				<div class="modal-content bg-transparent border-0">
					<div class="modal-body text-center">
						<img id="modalImage" src="<?= ASSETS_DIR ?>/img/products/<?= $product->product->image[0] ?>" class="img-fluid rounded-3 shadow-lg" alt="تصویر محصول بزرگ">
					</div>
				</div>
			</div>
		</div>

	</section>

	<script>
		$( document ).ready( function() {
			const mainImage = $( '#mainImage' );
			const modalImage = $( '#modalImage' );
			const thumbs = $( '.thumb-img' );

			thumbs.on( 'click' , function() {
				const newSrc = $( this ).attr( 'src' );

				mainImage.attr( 'src' , newSrc );
				modalImage.attr( 'src' , newSrc );

				thumbs.removeClass( 'active border-primary' );
				$(this).addClass( 'active border-primary' );
			});

			mainImage.on( 'click' , function() {
				modalImage.attr( 'src' , $( this ).attr( 'src' ) );
			} );
		} );
	</script>

	<?php include __DIR__ . "/../assets/components/footer.php"; ?>
</body>
</html>
