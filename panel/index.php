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
	<title>دیبا اکسسوری - پنل</title>
	<style>
	.card-body::-webkit-scrollbar {
		width: 8px;
	}
	.card-body::-webkit-scrollbar-thumb {
		background-color: #ccc;
		border-radius: 4px;
	}
	.card-body::-webkit-scrollbar-thumb:hover {
		background-color: #999;
	}
	</style>
</head>
<body>
	<?php include __DIR__ . "/../assets/components/navbar.php"; ?>

	<section class="container-fluid my-5">
		<div class="accordion" id="addProductAccordion">
			<div class="accordion-item shadow-sm">
				<h2 class="accordion-header" id="headingAddProduct">
					<button
						class="accordion-button collapsed bg-primary text-white"
						type="button"
						data-bs-toggle="collapse"
						data-bs-target="#collapseAddProduct"
						aria-expanded="false"
						aria-controls="collapseAddProduct"
					>
					افزودن محصول جدید
					</button>
				</h2>
				<div
					id="collapseAddProduct"
					class="accordion-collapse collapse"
					aria-labelledby="headingAddProduct"
					data-bs-parent="#addProductAccordion"
				>
					<div class="accordion-body bg-light">
						<form action="" method="POST" id="addProductForm" class="p-3 rounded bg-white shadow-sm needs-validation" novalidate enctype="multipart/form-data">
							<div class="mb-3">
								<label for="productType" class="form-label fw-bold">نوع محصول</label>
								<select id="productType" name="type" class="form-select" required>
									<option value="" disabled selected>انتخاب نوع محصول...</option>
									<option value="0">انگشتر</option>
									<option value="1">گردنبند</option>
									<option value="2">گوشواره</option>
								</select>
							</div>

							<div class="mb-3">
								<label for="productName" class="form-label fw-bold">نام محصول</label>
								<input
									type="text"
									id="productName"
									name="name"
									class="form-control"
									placeholder="مثلاً گردنبند طلایی"
									autocomplete="off"
									min="8"
									max="128"
									required
								/>
							</div>

							<div class="mb-3">
								<label for="productDescription" class="form-label fw-bold">توضیحات محصول</label>
								<textarea
									id="productDescription"
									name="description"
									rows="3"
									class="form-control"
									placeholder="توضیحات کوتاهی درباره محصول..."
									autocomplete="off"
									min="12"
									max="512"
									required
								></textarea>
							</div>

							<div class="mb-3">
								<label for="image_main" class="form-label fw-bold">تصاویر محصول</label>
								<div class="row g-2">
									<div class="col-md-3">
										<input type="file" id="image_main" name="image_main" class="form-control" required />
										<small class="text-muted">تصویر شاخص (اجباری)</small>
									</div>
									<div class="col-md-3">
										<input type="file" id="image_2" name="image_2" class="form-control" />
									</div>
									<div class="col-md-3">
										<input type="file" id="image_3" name="image_3" class="form-control" />
									</div>
									<div class="col-md-3">
										<input type="file" id="image_4" name="image_4" class="form-control" />
									</div>
								</div>
							</div>

							<div class="row g-3 mb-3">
								<div class="col-md-6">
									<label for="productCount" class="form-label fw-bold">تعداد موجودی</label>
									<input
										type="number"
										id="productCount"
										name="count"
										class="form-control"
										autocomplete="off"
										min="1"
										required
									/>
								</div>
								<div class="col-md-6">
									<label for="productOffer" class="form-label fw-bold">تخفیف (%)</label>
									<input
										type="number"
										id="productOffer"
										name="offer"
										class="form-control"
										value="0"
										autocomplete="off"
										min="0"
										max="100"
										required
									/>
								</div>
							</div>
							<!-- رنگ بندی -->
							<div class="mb-3">
								<label for="colorName" class="form-label fw-bold">رنگ‌بندی محصول</label>
								<div class="d-flex align-items-center gap-2 mb-2">
									<input
										type="text"
										id="colorName"
										class="form-control w-25"
										autocomplete="off"
										min="1"
										max="32"
										placeholder="نام رنگ"
									/>
									<input
										type="color"
										id="colorCode"
										class="form-control form-control-color w-auto"
									/>
									<button type="button" id="addColor" class="btn btn-outline-primary btn-sm">افزودن رنگ</button>
								</div>
								<div id="colorPreview" class="d-flex flex-wrap gap-2"></div>
							</div>

							<div class="mb-3">
								<label for="materialName" class="form-label fw-bold">جنس محصول</label>
								<div class="d-flex align-items-center gap-2 mb-2">
									<input
										type="text"
										id="materialName"
										class="form-control w-50"
										placeholder="مثلاً طلا، نقره..."
										autocomplete="off"
										min="1"
										max="32"
									/>
									<button type="button" id="addMaterial" class="btn btn-outline-success btn-sm">افزودن جنس</button>
								</div>
								<div id="materialPreview" class="d-flex flex-wrap gap-2"></div>
							</div>

							<div class="mb-3">
								<label for="sizeValue" class="form-label fw-bold">سایز محصول</label>
								<div class="d-flex align-items-center gap-2 mb-2">
									<input
										type="text"
										id="sizeValue"
										class="form-control w-50"
										placeholder="مثلاً S، M، L..."
										autocomplete="off"
										min="1"
										max="32"
									/>
									<button type="button" id="addSize" class="btn btn-outline-warning btn-sm">افزودن سایز</button>
								</div>
								<div id="sizePreview" class="d-flex flex-wrap gap-2"></div>
							</div>

							<div class="text-center mt-4">
								<button type="submit" class="btn btn-primary px-4 w-100">افزودن محصول</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>

	<script>
		$( function() {
			$( '#addColor' ).on( 'click', function() {
				const name = $( '#colorName' ).val().trim();
				const color = $( '#colorCode' ).val();
				const colorCount = $( '.dbas-prod-colors' ).length;

				if ( name !== '' ) {
					$( '#colorPreview' ).append( `
						<div class="d-flex align-items-center border rounded-pill px-2 py-1 gap-2 dbas-prod-colors" id="__color_label_${ colorCount }">
							<input type="hidden" name="color-${ colorCount }" value="${ name },${ color }" />
							<span class="me-2" style="width:20px;height:20px;background:${ color };border-radius:50%;display:inline-block;"></span>
							<small>${ name }</small>
							<small class="text-danger d-block" style="cursor: pointer;" onclick="$( '#__color_label_${ colorCount }' ).remove()">x</small>
						</div>
					` );
					$( '#colorName' ).val( '' );
				}
			} );

			$( '#addMaterial' ).on( 'click', function() {
				const mat = $( '#materialName' ).val().trim();
				const matCount = $( '.dbas-prod-mat' ).length;

				if ( mat !== '' ) {
					$( '#materialPreview' ).append( `
						<div class="d-flex align-items-center border rounded-pill px-2 py-1 gap-2 dbas-prod-mat" id="__mat_label_${ matCount }">
							<input type="hidden" name="mat-${ matCount }" value="${ mat }" />
							<span>${ mat }</span>
							<small class="text-danger d-block" style="cursor: pointer;" onclick="$( '#__mat_label_${ matCount }' ).remove()">x</small>
						</div>
					` );
					$( '#materialName' ).val( '' );
				}
			});

			$( '#addSize' ).on( 'click', function() {
				const size = $( '#sizeValue' ).val().trim();
				const sizeCount = $( '.dbas-prod-size' ).length;

				if ( size !== '' ) {
					$( '#sizePreview' ).append( `
						<div class="d-flex align-items-center border rounded-pill px-2 py-1 gap-2 dbas-prod-size" id="__size_label_${ sizeCount }">
							<input type="hidden" name="size-${ sizeCount }" value="${ size }" />
							<span>${ size }</span>
							<small class="text-danger d-block" style="cursor: pointer;" onclick="$( '#__size_label_${ sizeCount }' ).remove()">x</small>
						</div>
					` );
					$( '#sizeValue' ).val( '' );
				}
			});
		} );
	</script>

	<section class="container-fluid my-5">
		<div class="card shadow-sm">
			<div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
				<h5 class="mb-0">سفارش‌های ثبت شده</h5>
				<small class="text-light">مدیریت وضعیت سفارش‌ها</small>
			</div>
			<div class="card-body bg-light" style="max-height: 500px; overflow-y: auto;">

				<div class="card mb-3 border-0 shadow-sm">
					<div class="row g-0 align-items-center p-3">
						<div class="col-md-2 text-center">
							<img src="<?= ASSETS_DIR ?>/img/products/1.jpg" class="img-fluid rounded" alt="محصول" style="max-height: 100px; object-fit: cover;">
						</div>

						<div class="col-md-7">
							<h6 class="fw-bold mb-1">گردنبند طلایی</h6>
							<p class="text-muted small mb-1">تعداد درخواستی: <strong>2 عدد</strong></p>
							<p class="text-muted small mb-1">قیمت نهایی: <strong>1,200,000 تومان</strong></p>
							<a href="product/گردنبند-طلایی" class="text-decoration-none text-primary small fw-bold">
							مشاهده محصول
							</a>
						</div>

						<div class="col-md-3">
							<form method="post" class="d-flex flex-column gap-2">
								<select name="status" class="form-select form-select-sm">
									<option value="open">باز</option>
									<option value="confirmed" selected>تایید</option>
									<option value="shipping">در حال ارسال</option>
									<option value="closed">بسته</option>
								</select>
								<button type="submit" class="btn btn-sm btn-success">اعمال وضعیت</button>
							</form>
						</div>
					</div>
				</div>

				<div class="card mb-3 border-0 shadow-sm">
					<div class="row g-0 align-items-center p-3">
						<div class="col-md-2 text-center">
							<img src="<?= ASSETS_DIR ?>/img/products/2.jpg" class="img-fluid rounded" alt="محصول" style="max-height: 100px; object-fit: cover;">
						</div>
						<div class="col-md-7">
							<h6 class="fw-bold mb-1">انگشتر نقره‌ای</h6>
							<p class="text-muted small mb-1">تعداد درخواستی: <strong>1 عدد</strong></p>
							<p class="text-muted small mb-1">قیمت نهایی: <strong>850,000 تومان</strong></p>
							<a href="product/انگشتر-نقره‌ای" class="text-decoration-none text-primary small fw-bold">
							مشاهده محصول
							</a>
						</div>
						<div class="col-md-3">
							<form method="post" class="d-flex flex-column gap-2">
								<select name="status" class="form-select form-select-sm">
									<option value="open" selected>باز</option>
									<option value="confirmed">تایید</option>
									<option value="shipping">در حال ارسال</option>
									<option value="closed">بسته</option>
								</select>
								<button type="submit" class="btn btn-sm btn-success">اعمال وضعیت</button>
							</form>
						</div>
					</div>
				</div>

			</div>
		</div>
	</section>

	<!-- Validating forms -->
	<script>
		( function () {
			'use strict'

			const forms = document.querySelectorAll( '.needs-validation' );

			Array.from( forms ).forEach( function ( form ) {
				form.addEventListener( 'submit', function ( event ) {
					if ( !form.checkValidity() ) {
						event.preventDefault();
						event.stopPropagation();
					}

					form.classList.add( 'was-validated' );
				}, false );
			})
		} )()
	</script>

	<?php include __DIR__ . "/../assets/components/footer.php"; ?>
</body>
</html>
