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
				<form action="#" method="POST" class="border rounded-4 p-4 shadow-sm bg-white">

					<div class="d-flex align-items-center gap-2 mb-3">
						<span class="fw-block d-block mb-2">انگشتر</span>
						<span class="fw-block d-block mb-2">/</span>
						<h2 class="fw-bold fs-6">انگشتر نقره طرح کلاسیک</h2>
					</div>

					<p class="text-muted mb-4">این انگشتر زیبا از نقره با عیار بالا ساخته شده و مناسب استفاده روزمره و مجلسی است.</p>

					<div class="d-flex flex-wrap gap-3 mb-3">
						<span class="badge bg-primary px-3 py-2">نوع: انگشتر</span>
						<span class="badge bg-success px-3 py-2">موجودی: ۱۲ عدد</span>
					</div>

					<div class="mb-4">
						<span class="text-decoration-line-through text-muted fs-5">۲۵۰,۰۰۰ تومان</span>
						<span class="fs-3 fw-bold text-danger ms-3">۱۹۵,۰۰۰ تومان</span>
						<span class="badge bg-danger">٪۲۲ تخفیف</span>
					</div>

					<div class="mb-4">
						<label class="fw-semibold mb-2 d-block">انتخاب رنگ:</label>
						<div class="d-flex gap-2">
							<input type="radio" class="btn-check" name="color" id="color1" autocomplete="off" checked>
							<label class="btn border rounded-circle p-3" for="color1" style="background-color: #000;"></label>
							<input type="radio" class="btn-check" name="color" id="color2" autocomplete="off">
							<label class="btn border rounded-circle p-3" for="color2" style="background-color: #d4af37;"></label>
							<input type="radio" class="btn-check" name="color" id="color3" autocomplete="off">
							<label class="btn border rounded-circle p-3" for="color3" style="background-color: #8b4513;"></label>
						</div>
					</div>

					<div class="mb-4">
						<label class="fw-semibold mb-2 d-block">انتخاب جنس:</label>
						<div class="d-flex flex-wrap gap-2">
							<input type="radio" class="btn-check" name="material" id="mat1" autocomplete="off" checked>
							<label class="btn btn-outline-secondary px-4 py-2" for="mat1">نقره</label>
							<input type="radio" class="btn-check" name="material" id="mat2" autocomplete="off">
							<label class="btn btn-outline-secondary px-4 py-2" for="mat2">طلا</label>
							<input type="radio" class="btn-check" name="material" id="mat3" autocomplete="off">
							<label class="btn btn-outline-secondary px-4 py-2" for="mat3">استیل</label>
						</div>
					</div>

					<div class="mb-4">
						<label class="fw-semibold mb-2 d-block">انتخاب سایز:</label>
						<div class="d-flex flex-wrap gap-2">
							<input type="radio" class="btn-check" name="size" id="size1" autocomplete="off" checked>
							<label class="btn btn-outline-secondary px-3 py-2" for="size1">16</label>
							<input type="radio" class="btn-check" name="size" id="size2" autocomplete="off">
							<label class="btn btn-outline-secondary px-3 py-2" for="size2">17</label>
							<input type="radio" class="btn-check" name="size" id="size3" autocomplete="off">
							<label class="btn btn-outline-secondary px-3 py-2" for="size3">18</label>
							<input type="radio" class="btn-check" name="size" id="size4" autocomplete="off">
							<label class="btn btn-outline-secondary px-3 py-2" for="size4">19</label>
						</div>
					</div>

					<div class="mt-4">
						<button type="submit" class="btn btn-sm btn-primary w-100 py-3 fw-bold">افزودن به سبد خرید 🛒</button>

						<!-- <div class="mb-3">
							<span>تعداد در سبد خرید:</span>
							<span class="badge text-bg-success">10</span>
						</div>
						<div class="d-flex gap-1">
							<button type="submit" class="btn btn-sm btn-outline-success w-25 py-3 fw-bold">+</button>
							<button type="submit" class="btn btn-sm btn-danger w-100 py-3 fw-bold">حذف 🗑️</button>
							<button type="submit" class="btn btn-sm btn-outline-success w-25 py-3 fw-bold">-</button>
						</div> -->
					</div>
				</form>
			</div>
		</div>
	</section>

	<section class="container my-5">
		<h3 class="fw-bold mb-4 text-center">تصاویر محصول</h3>
	
		<div class="row g-3 justify-content-center">

			<div class="col-12 text-center">
				<img id="mainImage" src="<?= ASSETS_DIR ?>/img/products/1.jpg" class="img-fluid rounded-4 shadow-sm" style="max-height: 450px; object-fit: contain; cursor: zoom-in;" alt="تصویر اصلی محصول" data-bs-toggle="modal" data-bs-target="#imageModal">
			</div>

			<div class="col-12 d-flex justify-content-center gap-3 flex-wrap mt-3">
				<img src="<?= ASSETS_DIR ?>/img/products/1.jpg" class="thumb-img rounded-3 border border-2 border-primary" alt="تصویر ۱" style="width: 90px; height: 90px; object-fit: cover; cursor: pointer;">
				<img src="<?= ASSETS_DIR ?>/img/products/2.jpg" class="thumb-img rounded-3 border border-2 border-transparent" alt="تصویر ۲" style="width: 90px; height: 90px; object-fit: cover; cursor: pointer;">
				<img src="<?= ASSETS_DIR ?>/img/products/3.jpg" class="thumb-img rounded-3 border border-2 border-transparent" alt="تصویر ۳" style="width: 90px; height: 90px; object-fit: cover; cursor: pointer;">
				<img src="<?= ASSETS_DIR ?>/img/products/3.jpg" class="thumb-img rounded-3 border border-2 border-transparent" alt="تصویر ۴" style="width: 90px; height: 90px; object-fit: cover; cursor: pointer;">
			</div>

		</div>

		<div class="modal fade" id="imageModal" tabindex="-1">
			<div class="modal-dialog modal-dialog-centered modal-lg">
				<div class="modal-content bg-transparent border-0">
					<div class="modal-body text-center">
						<img id="modalImage" src="<?= ASSETS_DIR ?>/img/products/1.jpg" class="img-fluid rounded-3 shadow-lg" alt="تصویر محصول بزرگ">
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
