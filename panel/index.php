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
	.table img {
		transition: transform 0.2s ease-in-out;
	}
	.table img:hover {
		transform: scale(1.05);
	}
	.card-header a.btn:hover {
		background-color: #f8f9fa;
		color: #198754;
	}
	.card {
		transition: transform 0.2s ease, box-shadow 0.2s ease;
	}
	.card:hover {
		transform: translateY(-5px);
		box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
	}
	.card-footer a.btn {
		transition: all 0.2s ease;
	}
	.card-footer a.btn:hover {
		opacity: 0.85;
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

			<div class="accordion-item shadow-sm">
				<h2 class="accordion-header" id="headingAddProduct">
					<button
						class="accordion-button collapsed bg-primary text-white"
						type="button"
						data-bs-toggle="collapse"
						data-bs-target="#collapseOrderHistory"
						aria-expanded="false"
						aria-controls="collapseOrderHistory"
					>
					تاریخچه سفارش‌های بسته‌شده
					</button>
				</h2>
				<div
					id="collapseOrderHistory"
					class="accordion-collapse collapse"
					aria-labelledby="headingAddProduct"
					data-bs-parent="#addProductAccordion"
				>
					<section class="container-fluid my-5">
						<div class="table-responsive">
							<table class="table table-striped table-hover align-middle text-center">
								<thead class="table-success">
									<tr>
										<th scope="col">#</th>
										<th scope="col">تصویر</th>
										<th scope="col">نام محصول</th>
										<th scope="col">تعداد</th>
										<th scope="col">جنس</th>
										<th scope="col">سایز</th>
										<th scope="col">رنگ</th>
										<th scope="col">مبلغ نهایی (تومان)</th>
										<th scope="col">اغدامات</th>
									</tr>
								</thead>
								<tbody>
									<!-- ردیف نمونه -->
									<tr>
										<th scope="row">1</th>
										<td>
											<img src="<?= ASSETS_DIR ?>/img/products/1.jpg" alt="محصول" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
										</td>
										<td class="fw-semibold">گردنبند طلایی</td>
										<td>2</td>
										<td>استیل</td>
										<td>متوسط</td>
										<td>
											<span class="badge" style="background-color: gold;">طلایی</span>
										</td>
										<td class="fw-bold text-success">1,200,000</td>
										<td>
											<a href="#" class="btn btn-sm btn-success">باز کردن سفارش</a>
											<a href="#" class="btn btn-sm btn-danger">حذف سفارش</a>
										</td>
									</tr>
									<tr>
										<th scope="row">2</th>
										<td>
											<img src="<?= ASSETS_DIR ?>/img/products/2.jpg" alt="محصول" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
										</td>
										<td class="fw-semibold">انگشتر نقره‌ای</td>
										<td>1</td>
										<td>نقره</td>
										<td>کوچک</td>
										<td>
											<span class="badge" style="background-color: silver;">نقره‌ای</span>
										</td>
										<td class="fw-bold text-success">850,000</td>
										<td>
											<a href="#" class="btn btn-sm btn-success">باز کردن سفارش</a>
											<a href="#" class="btn btn-sm btn-danger">حذف سفارش</a>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</section>
				</div>
			</div>

			<div class="accordion-item shadow-sm">
				<h2 class="accordion-header" id="headingAddProduct">
					<button
						class="accordion-button collapsed bg-primary text-white"
						type="button"
						data-bs-toggle="collapse"
						data-bs-target="#collapseRemovedProdcuts"
						aria-expanded="false"
						aria-controls="collapseRemovedProdcuts"
					>
					محصولات حذف شده
					</button>
				</h2>
				<div
					id="collapseRemovedProdcuts"
					class="accordion-collapse collapse"
					aria-labelledby="headingAddProduct"
					data-bs-parent="#addProductAccordion"
				>
					<section class="container-fluid my-5">
						<div class="table-responsive">
							<table class="table table-striped table-hover align-middle text-center">
								<thead class="table-success">
									<tr>
										<th scope="col">#</th>
										<th scope="col">تصویر</th>
										<th scope="col">نام محصول</th>
										<th scope="col">اغدامات</th>
									</tr>
								</thead>
								<tbody>
									<!-- ردیف نمونه -->
									<tr>
										<th scope="row">1</th>
										<td>
											<img src="<?= ASSETS_DIR ?>/img/products/1.jpg" alt="محصول" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
										</td>
										<td class="fw-semibold">گردنبند طلایی</td>
										<td>
											<a href="#" class="btn btn-sm btn-success">باز گرداندن</a>
											<a href="#" class="btn btn-sm btn-danger">حذف</a>
										</td>
									</tr>
									<tr>
										<th scope="row">2</th>
										<td>
											<img src="<?= ASSETS_DIR ?>/img/products/2.jpg" alt="محصول" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
										</td>
										<td class="fw-semibold">گردنبند طلایی</td>
										<td>
											<a href="#" class="btn btn-sm btn-success">باز گرداندن</a>
											<a href="#" class="btn btn-sm btn-danger">حذف</a>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</section>
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
							<p class="text-muted small mb-1">رنگ: <strong>طلایی</strong></p>
							<p class="text-muted small mb-1">جنس: <strong>استیل</strong></p>
							<p class="text-muted small mb-1">سایز: <strong>M</strong></p>
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
							<p class="text-muted small mb-1">رنگ: <strong>طلایی</strong></p>
							<p class="text-muted small mb-1">جنس: <strong>استیل</strong></p>
							<p class="text-muted small mb-1">سایز: <strong>M</strong></p>
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

	<hr />

	<section class="container my-5">
		<h4 class="mb-4 fw-bold text-center">محصولات من</h4>
		<div class="row g-4">
			<!-- کارت محصول -->
			<div class="col-12 col-sm-6 col-lg-4 col-xl-3">
				<div class="card h-100 shadow-sm border-0">
					<a href="product.php?id=1" class="text-decoration-none text-dark">
						<img src="<?= ASSETS_DIR ?>/img/products/1.jpg" class="card-img-top rounded-top" alt="محصول" style="height: 220px; object-fit: cover;">
					</a>
					<div class="card-body">
						<div class="d-flex justify-content-between align-items-center mb-2">
							<h6 class="card-title mb-0 fw-bold">گردنبند طلایی</h6>
							<span class="badge bg-primary">گردنبند</span>
						</div>
						<p class="card-text text-muted small mb-2">توضیح کوتاه درباره محصول...</p>
						<div class="d-flex justify-content-between align-items-center">
							<span class="fw-bold text-success">960,000 تومان</span>
							<div>
								<span class="text-decoration-line-through text-muted small">1,200,000</span>
								<span class="badge bg-danger ms-1">-20%</span>
							</div>
						</div>
					</div>
					<div class="card-footer bg-white border-0 d-flex justify-content-between align-items-center">
						<a href="product.php?id=1" class="btn btn-outline-primary btn-sm">مشاهده</a>
						<div class="d-flex gap-2">
							<a href="edit_product.php?id=1" class="btn btn-warning btn-sm text-white">ویرایش</a>
							<a href="delete_product.php?id=1" class="btn btn-danger btn-sm">حذف</a>
						</div>
					</div>
					<div class="card-footer bg-white border-0 d-flex justify-content-between align-items-center gap-2">
						<a href="#" class="btn btn-warning btn-sm text-white w-100">+</a>
						<span class="btn btn-dark btn-sm w-100 pe-none">تعداد: 2</span>
						<a href="#" class="btn btn-danger btn-sm w-100">-</a>
					</div>
				</div>
			</div>

			<div class="col-12 col-sm-6 col-lg-4 col-xl-3">
				<div class="card h-100 shadow-sm border-0">
					<a href="product.php?id=2" class="text-decoration-none text-dark">
						<img src="<?= ASSETS_DIR ?>/img/products/2.jpg" class="card-img-top rounded-top" alt="محصول" style="height: 220px; object-fit: cover;">
					</a>
					<div class="card-body">
						<div class="d-flex justify-content-between align-items-center mb-2">
							<h6 class="card-title mb-0 fw-bold">انگشتر نقره‌ای</h6>
							<span class="badge bg-primary">انگشتر</span>
						</div>
						<p class="card-text text-muted small mb-2">طرح خاص و زیبا مناسب هدیه.</p>
						<div class="d-flex justify-content-between align-items-center">
							<span class="fw-bold text-success">850,000 تومان</span>
						</div>
					</div>
					<div class="card-footer bg-white border-0 d-flex justify-content-between align-items-center">
						<a href="product.php?id=2" class="btn btn-outline-primary btn-sm">مشاهده</a>
						<div class="d-flex gap-2">
							<a href="edit_product.php?id=2" class="btn btn-warning btn-sm text-white">ویرایش</a>
							<a href="delete_product.php?id=2" class="btn btn-danger btn-sm">حذف</a>
						</div>
					</div>
					<div class="card-footer bg-white border-0 d-flex justify-content-between align-items-center gap-2">
						<a href="#" class="btn btn-warning btn-sm text-white w-100">+</a>
						<span class="btn btn-dark btn-sm w-100 pe-none">تعداد: 2</span>
						<a href="#" class="btn btn-danger btn-sm w-100">-</a>
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
