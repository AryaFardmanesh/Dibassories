<?php

include __DIR__ . "/../src/config.php";
include __DIR__ . "/../src/utils/convert.php";
include __DIR__ . "/../src/services/accounts.php";
include __DIR__ . "/../src/repositories/orders.php";
include __DIR__ . "/../src/repositories/products.php";
include __DIR__ . "/../src/controllers/controller.php";

$account = AccountService::getAccountFromCookie();

if ($account === null) {
	Controller::redirect(BASE_URL . "/login/");
}elseif ($account->role === ROLE_CUSTOMER) {
	Controller::redirect(null);
}

$error = Controller::getRequest("error");
$viewMode = Controller::getRequest("view");

$editProductModel = null;

if ($viewMode === 'edit-product') {
	$editProductModel = ProductRepository::findById(Controller::getRequest("product", true));

	if (ProductRepository::hasError()) {
		$error = ProductRepository::getError();
	}
}

$orders = OrderRepository::findForProvider($account->id);

if (OrderRepository::hasError()) {
	$error = OrderRepository::getError();
}

$products = ProductRepository::findForOwner($account->id);

if (ProductRepository::hasError()) {
	$error = ProductRepository::getError();
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

	<?php if ($error !== null) echo "<div class='alert alert-danger mx-3 mt-4'>$error</div>"; ?>

	<section class="container-fluid my-5">
		<div class="accordion" id="addProductAccordion">

			<!-- Add/Edit Product -->
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
					<?= $viewMode === "edit-product" ? "ویرایش محصول" : "افزودن محصول جدید" ?>
					</button>
				</h2>
				<div
					id="collapseAddProduct"
					class="accordion-collapse <?= $viewMode === null ? "collapse" : null ?>"
					aria-labelledby="headingAddProduct"
					data-bs-parent="#addProductAccordion"
				>
					<div class="accordion-body bg-light">
						<form action="<?= BASE_URL . "/src/controllers/products.php" ?>" method="POST" id="addProductForm" class="p-3 rounded bg-white shadow-sm needs-validation" novalidate enctype="multipart/form-data">
							<input type="hidden" name="req" value="<?= $viewMode === null ? CONTROLLER_PRODUCT_ADD : CONTROLLER_PRODUCT_UPDATE ?>" />
							<input type="hidden" name="user" value="<?= $account->id ?>" />
							<input type="hidden" name="redirect" value="<?= dirname($_SERVER["PHP_SELF"]) ?>" />

							<?php
							$productId = $editProductModel !== null ? $editProductModel->id : null;
							$inputForEditProduct = $viewMode === 'edit-product' ? "<input type='hidden' name='product' value='$productId' />" : null;
							echo $inputForEditProduct;
							?>

							<div class="mb-3">
								<label for="productType" class="form-label fw-bold">نوع محصول</label>
								<select id="productType" name="type" class="form-select" required>
									<option disabled selected>انتخاب نوع محصول...</option>
									<option value="<?= PRODUCT_TYPE_RING ?>" <?= $editProductModel !== null ? ($editProductModel->type === PRODUCT_TYPE_RING ? "selected" : null) : null ?>>انگشتر</option>
									<option value="<?= PRODUCT_TYPE_NECKLACE ?>" <?= $editProductModel !== null ? ($editProductModel->type === PRODUCT_TYPE_NECKLACE ? "selected" : null) : null ?>>گردنبند</option>
									<option value="<?= PRODUCT_TYPE_EARRING ?>" <?= $editProductModel !== null ? ($editProductModel->type === PRODUCT_TYPE_EARRING ? "selected" : null) : null ?>>گوشواره</option>
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
									value="<?= $editProductModel !== null ? $editProductModel->name : null ?>"
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
								><?= $editProductModel !== null ? $editProductModel->description : null ?></textarea>
							</div>

							<div class="mb-3">
								<label for="image_main" class="form-label fw-bold">تصاویر محصول</label>
								<div class="row g-2">
									<div class="col-md-3">
										<input type="file" id="image_main" name="image_main" class="form-control" <?= $viewMode !== 'edit-product' ? "required" : null ?> />
										<?= $viewMode !== 'edit-product' ? "<small class='text-muted'>تصویر شاخص (اجباری)</small>" : null ?>
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
								<div class="col-md-4">
									<label for="productPrice" class="form-label fw-bold">قیمت</label>
									<input
										type="number"
										id="productPrice"
										name="price"
										class="form-control"
										value="<?= $editProductModel !== null ? $editProductModel->price : null ?>"
										autocomplete="off"
										min="1"
										required
									/>
								</div>
								<div class="col-md-4">
									<label for="productCount" class="form-label fw-bold">تعداد موجودی</label>
									<input
										type="number"
										id="productCount"
										name="count"
										class="form-control"
										value="<?= $editProductModel !== null ? $editProductModel->count : null ?>"
										autocomplete="off"
										min="1"
										required
									/>
								</div>
								<div class="col-md-4">
									<label for="productOffer" class="form-label fw-bold">تخفیف (%)</label>
									<input
										type="number"
										id="productOffer"
										name="offer"
										class="form-control"
										value="<?= $editProductModel !== null ? $editProductModel->offer : 0 ?>"
										autocomplete="off"
										min="0"
										max="100"
										required
									/>
								</div>
							</div>

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
								<div id="colorPreview" class="d-flex flex-wrap gap-2">
									<?php
										if ($editProductModel === null) goto skip_edit_color;
										$editProductColorModel = ProductRepository::findColors($editProductModel->id);
										$i = -1;
										foreach ($editProductColorModel as $color) {
											$i++;
									?>
									<div class="d-flex align-items-center border rounded-pill px-2 py-1 gap-2 dbas-prod-colors" id="__color_label_<?= $i ?>">
										<input type="hidden" name="color-<?= $i ?>" value="<?= $color->name ?>,<?= $color->hex ?>" />
										<span class="me-2" style="width:20px;height:20px;background:#<?= $color->hex ?>;border-radius:50%;display:inline-block;"></span>
										<small><?= $color->name ?></small>
										<small class="text-danger d-block" style="cursor: pointer;" onclick="$( '#__color_label_<?= $i ?>' ).remove()">x</small>
									</div>
									<?php } ?>

									<?php skip_edit_color: ?>
								</div>
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
								<div id="materialPreview" class="d-flex flex-wrap gap-2">
									<?php
										if ($editProductModel === null) goto skip_edit_material;
										$editProductMaterialModel = ProductRepository::findMaterials($editProductModel->id);
										$i = -1;
										foreach ($editProductMaterialModel as $material) {
											$i++;
									?>
									<div class="d-flex align-items-center border rounded-pill px-2 py-1 gap-2 dbas-prod-mat" id="__mat_label_<?= $i ?>">
										<input type="hidden" name="material-<?= $i ?>" value="<?= $material->material ?>" />
										<span><?= $material->material ?></span>
										<small class="text-danger d-block" style="cursor: pointer;" onclick="$( '#__mat_label_<?= $i ?>' ).remove()">x</small>
									</div>
									<?php } ?>

									<?php skip_edit_material: ?>
								</div>
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
								<div id="sizePreview" class="d-flex flex-wrap gap-2">
									<?php
										if ($editProductModel === null) goto skip_edit_size;
										$editProductSizeModel = ProductRepository::findSizes($editProductModel->id);
										$i = -1;
										foreach ($editProductSizeModel as $size) {
											$i++;
									?>
									<div class="d-flex align-items-center border rounded-pill px-2 py-1 gap-2 dbas-prod-size" id="__size_label_<?= $i ?>">
										<input type="hidden" name="size-<?= $i ?>" value="<?= $size->size ?>" />
										<span><?= $size->size ?></span>
										<small class="text-danger d-block" style="cursor: pointer;" onclick="$( '#__size_label_<?= $i ?>' ).remove()">x</small>
									</div>
									<?php } ?>

									<?php skip_edit_size: ?>
								</div>
							</div>

							<div class="text-center mt-4">
								<button type="submit" class="btn btn-primary px-4 w-100">
									<?= $viewMode === 'edit-product' ? "ویرایش محصول" : "افزودن محصول" ?>
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>

			<!-- Orders History -->
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

									<?php
										$i = 0;
										foreach ($orders as $order) {
											if ($order->status !== STATUS_CLOSED) continue;
											$i++;
											$product = ProductRepository::findById($order->product);
											$material = ProductRepository::findMaterial($order->product_material);
											$size = ProductRepository::findSize($order->product_size);
											$color = ProductRepository::findColor($order->product_color);
											if ($product === null) continue;
											if ($material === null) continue;
											if ($size === null) continue;
											if ($color === null) continue;
									?>
									<tr>
										<th scope="row"><?= $i ?></th>
										<td>
											<img src="<?= ASSETS_DIR ?>/img/products/<?= $product->image[0] ?>" alt="<?= $product->image[0] ?>" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
										</td>
										<td class="fw-semibold"><?= $product->name ?></td>
										<td><?= $product->count ?></td>
										<td><?= $material->material ?></td>
										<td><?= $size->size ?></td>
										<td>
											<span class="badge" style="background-color: #<?= $color->hex ?>;"><?= $color->name ?></span>
										</td>
										<td class="fw-bold text-success"><?= number_format((float)$order->total) ?></td>
										<td>
											<?php
												$openOrderLink = Controller::makeControllerUrl("orders", CONTROLLER_ORDER_STATUS_OPEN, [
													"user" => $account->id,
													"order" => $order->id,
													"redirect" => dirname($_SERVER["PHP_SELF"])
												]);
												$removeOrderLink = Controller::makeControllerUrl("orders", CONTROLLER_ORDER_STATUS_REMOVE, [
													"user" => $account->id,
													"order" => $order->id,
													"redirect" => dirname($_SERVER["PHP_SELF"])
												]);
											?>
											<a href="<?= $openOrderLink ?>" class="btn btn-sm btn-success">باز کردن سفارش</a>
											<a href="<?= $removeOrderLink ?>" class="btn btn-sm btn-danger">حذف سفارش</a>
										</td>
									</tr>
									<?php } ?>

								</tbody>
							</table>
						</div>
					</section>
				</div>
			</div>

			<!-- Removed Products -->
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

									<?php
										$i = 0;
										foreach ($products as $product) {
											if ($product->status !== STATUS_REMOVED) continue;
											$i++;
									?>
									<tr>
										<th scope="row"><?= $i ?></th>
										<td>
											<img src="<?= ASSETS_DIR ?>/img/products/<?= $product->image[0] ?>" alt="<?= $product->name ?>" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
										</td>
										<td class="fw-semibold"><?= $product->name ?></td>
										<td>
											<?php
												$productRestoreLink = Controller::makeControllerUrl("products", CONTROLLER_PRODUCT_RESTORE, [
													"user" => $account->id,
													"product" => $product->id,
													"redirect" => dirname($_SERVER["PHP_SELF"])
												]);
												$productRemoveLink = Controller::makeControllerUrl("products", CONTROLLER_PRODUCT_REMOVE, [
													"user" => $account->id,
													"product" => $product->id,
													"redirect" => dirname($_SERVER["PHP_SELF"])
												]);
											?>
											<a href="<?= $productRestoreLink ?>" class="btn btn-sm btn-success">باز گرداندن</a>
											<a href="<?= $productRemoveLink ?>" class="btn btn-sm btn-danger">حذف</a>
										</td>
									</tr>
									<?php } ?>

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
							<input type="hidden" name="color-${ colorCount }" value="${ name },${ color.slice(1) }" />
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
							<input type="hidden" name="material-${ matCount }" value="${ mat }" />
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

				<?php
					foreach ($orders as $order) {
						if ($order->status === STATUS_CLOSED) continue;
						$product = ProductRepository::findById($order->product);
						$material = ProductRepository::findMaterial($order->product_material);
						$size = ProductRepository::findSize($order->product_size);
						$color = ProductRepository::findColor($order->product_color);
						if ($product === null) continue;
						if ($material === null) continue;
						if ($size === null) continue;
						if ($color === null) continue;
				?>
				<div class="card mb-3 border-0 shadow-sm">
					<div class="row g-0 align-items-center p-3">
						<div class="col-md-2 text-center">
							<img src="<?= ASSETS_DIR ?>/img/products/<?= $product->image[0] ?>" class="img-fluid rounded" alt="<?= $product->name ?>" style="max-height: 100px; object-fit: cover;">
						</div>

						<div class="col-md-7">
							<h6 class="fw-bold mb-1"><?= $product->name ?></h6>
							<p class="text-muted small mb-1">تعداد درخواستی: <strong><?= $order->count ?> عدد</strong></p>
							<p class="text-muted small mb-1">رنگ: <strong><?= $color->name ?></strong></p>
							<p class="text-muted small mb-1">جنس: <strong><?= $material->material ?></strong></p>
							<p class="text-muted small mb-1">سایز: <strong><?= $size->size ?></strong></p>
							<p class="text-muted small mb-1">قیمت نهایی: <strong><?= number_format((float)$order->total) ?> تومان</strong></p>
							<p class="text-muted small mb-1">آدرس: <strong><?= $order->address ?></strong></p>
							<p class="text-muted small mb-1">کد پستی: <strong><?= $order->zipcode ?></strong></p>
							<p class="text-muted small mb-1">شماره تماس: <strong><?= $order->phone ?></strong></p>
							<a href="<?= BASE_URL . "/product/" . urlencode($product->name) ?>" class="text-decoration-none text-primary small fw-bold">
							مشاهده محصول
							</a>
						</div>

						<div class="col-md-3">
							<form action="<?= BASE_URL . "/src/controllers/orders.php" ?>" method="GET" class="d-flex flex-column gap-2">
								<input type="hidden" name="req" value="<?= CONTROLLER_ORDER_STATUS_UPDATE ?>" />
								<input type="hidden" name="user" value="<?= $account->id ?>" />
								<input type="hidden" name="order" value="<?= $order->id ?>" />
								<input type="hidden" name="redirect" value="<?= dirname($_SERVER["PHP_SELF"]) ?>" />

								<select name="status" class="form-select form-select-sm">
									<option value="<?= STATUS_OPENED ?>" <?= $order->status === STATUS_OPENED ? "selected" : null ?>>باز</option>
									<option value="<?= STATUS_CONFIRM ?>" <?= $order->status === STATUS_CONFIRM ? "selected" : null ?>>تایید</option>
									<option value="<?= STATUS_SEND ?>" <?= $order->status === STATUS_SEND ? "selected" : null ?>>در حال ارسال</option>
									<option value="<?= STATUS_CLOSED ?>" <?= $order->status === STATUS_CLOSED ? "selected" : null ?>>بسته</option>
								</select>
								<button type="submit" class="btn btn-sm btn-success">اعمال وضعیت</button>
							</form>
						</div>
					</div>
				</div>
				<?php } ?>

			</div>
		</div>
	</section>

	<hr />

	<section class="container my-5">
		<h4 class="mb-4 fw-bold text-center">محصولات من</h4>
		<div class="row g-4">

			<?php
				foreach ($products as $product) {
					if ($product->status !== STATUS_OK) continue;
					$description = strlen($product->description) > 35 ? substr($product->description, 0, 35) . "..." : $product->description;
			?>
			<div class="col-12 col-sm-6 col-lg-4">
				<div class="card h-100 shadow-sm border-0">
					<a href="<?= BASE_URL . "/product/" . urlencode($product->name) ?>" class="text-decoration-none text-dark">
						<img src="<?= ASSETS_DIR ?>/img/products/<?= $product->image[0] ?>" class="card-img-top rounded-top" alt="<?= $product->name ?>" style="height: 220px; object-fit: cover;">
					</a>
					<div class="card-body">
						<div class="d-flex justify-content-between align-items-center mb-2">
							<h6 class="card-title mb-0 fw-bold"><?= $product->name ?></h6>
							<span class="badge bg-primary"><?= convertProductTypesToString($product->type) ?></span>
						</div>
						<p class="card-text text-muted small mb-2"><?= $description ?></p>
						<?php if ($product->offer === 0) { ?>
						<div class="d-flex justify-content-between align-items-center">
							<span class="fw-bold text-muted"><?= number_format((float)$product->price) ?> تومان</span>
						</div>
						<?php }else { ?>
						<div class="d-flex justify-content-between align-items-center">
							<span class="fw-bold text-success"><?= $product->price - ($product->price * $product->offer / 100) ?> تومان</span>
							<div>
								<span class="text-decoration-line-through text-muted small"><?= number_format((float)$product->price) ?></span>
								<span class="badge bg-danger ms-1">-<?= $product->offer ?>%</span>
							</div>
						</div>
						<?php } ?>
					</div>
					<div class="card-footer bg-white border-0 d-flex justify-content-between align-items-center">
						<a href="<?= BASE_URL . "/product/" . urlencode($product->name) ?>" class="btn btn-outline-primary btn-sm">مشاهده</a>
						<div class="d-flex gap-2">
							<?php
							$removeProductLink = Controller::makeControllerUrl("products", CONTROLLER_PRODUCT_REMOVE, [
								"user" => $account->id,
								"product" => $product->id,
								"redirect" => dirname($_SERVER["PHP_SELF"])
							]);
							?>
							<a href="<?= dirname($_SERVER["PHP_SELF"]) . "/?view=edit-product&product=" . $product->id ?>" class="btn btn-warning btn-sm text-white">ویرایش</a>
							<a href="<?= $removeProductLink ?>" class="btn btn-danger btn-sm">حذف</a>
						</div>
					</div>
					<div class="card-footer bg-white border-0 d-flex justify-content-between align-items-center gap-2">
						<?php
							$incProductCountLink = Controller::makeControllerUrl("products", CONTROLLER_PRODUCT_INC, [
								"user" => $account->id,
								"product" => $product->id,
								"redirect" => dirname($_SERVER["PHP_SELF"])
							]);
							$decProductCountLink = Controller::makeControllerUrl("products", CONTROLLER_PRODUCT_DEC, [
								"user" => $account->id,
								"product" => $product->id,
								"redirect" => dirname($_SERVER["PHP_SELF"])
							]);
						?>
						<a href="<?= $incProductCountLink ?>" class="btn btn-warning btn-sm text-white w-100">+</a>
						<span class="btn btn-dark btn-sm w-100 pe-none">تعداد: <?= $product->count ?></span>
						<a href="<?= $decProductCountLink ?>" class="btn btn-danger btn-sm w-100">-</a>
					</div>
				</div>
			</div>
			<?php } ?>

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
