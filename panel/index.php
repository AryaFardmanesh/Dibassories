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
								<button type="submit" class="btn btn-primary px-4">افزودن محصول</button>
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
						<div class="d-flex align-items-center border rounded-pill px-2 py-1 dbas-prod-colors">
							<input type="hidden" name="color-${ colorCount }" value="${ name },${ color }" />
							<span class="me-2" style="width:20px;height:20px;background:${ color };border-radius:50%;display:inline-block;"></span>
							<small>${ name }</small>
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
						<input type="hidden" name="mat-${ matCount }" value="${ mat }" />
						<span class="badge bg-success px-3 py-2 dbas-prod-mat">${ mat }</span>
					` );
					$( '#materialName' ).val( '' );
				}
			});

			$( '#addSize' ).on( 'click', function() {
				const size = $( '#sizeValue' ).val().trim();
				const sizeCount = $( '.dbas-prod-mat' ).length;

				if ( size !== '' ) {
					$( '#sizePreview' ).append( `
						<input type="hidden" name="size-${ sizeCount }" value="${ size }" />
						<span class="badge bg-warning text-dark px-3 py-2 dbas-prod-size">${ size }</span>
					` );
					$( '#sizeValue' ).val( '' );
				}
			});
		} );
	</script>

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
