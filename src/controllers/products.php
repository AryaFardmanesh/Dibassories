<?php

include_once __DIR__ . "/controller.php";
include_once __DIR__ . "/../repositories/products.php";
include_once __DIR__ . "/../repositories/accounts.php";
include_once __DIR__ . "/../utils/upload.php";

$req = (int)Controller::getRequest(CONTROLLER_REQ_NAME, true);
$owner = Controller::getRequest("user", true);
$productId = Controller::getRequest("product");

$account = AccountRepository::findById($owner);

if (AccountRepository::hasError()) {
	Controller::setError(AccountRepository::getError());
	goto out;
}

if ($account === null) {
	Controller::setError("کاربر یافت نشد.");
	goto out;
}

if ($req === CONTROLLER_PRODUCT_ADD) {
	if ($account->role === ROLE_CUSTOMER) {
		Controller::setError("کاربر مجاز به ایجاد محصول نیست.");
		goto out;
	}

	$type = (int)Controller::getRequest("type", true);
	$name = Controller::getRequest("name", true);
	$description = Controller::getRequest("description", true);
	$count = (int)Controller::getRequest("count", true);
	$price = (int)Controller::getRequest("price", true);
	$offer = (int)Controller::getRequest("offer", true);
	$colors = Controller::fetchSerialized("color", CONTROLLER_PRODUCT_LIMIT_COLOR_COUNT, true, ",");
	$materials = Controller::fetchSerialized("material", CONTROLLER_PRODUCT_LIMIT_MATERIAL_COUNT);
	$sizes = Controller::fetchSerialized("size", CONTROLLER_PRODUCT_LIMIT_SIZE_COUNT);

	$imageMain = uploadFile("image_main", PRODUCT_IMAGE_DIR);
	$image2 = uploadFile("image_2", PRODUCT_IMAGE_DIR);
	$image3 = uploadFile("image_3", PRODUCT_IMAGE_DIR);
	$image4 = uploadFile("image_4", PRODUCT_IMAGE_DIR);

	$images = [];

	if (gettype($imageMain) === "string") {
		array_push($images, $imageMain);
	}elseif ($imageMain !== FILE_STATUS_NOT_FOUND) {
		echo "OK";
		die;
		Controller::setError("تصویر شاخص با موفقیت آپلود نشد.");
		goto out;
	}
	if (gettype($image2) === "string") {
		array_push($images, $image2);
	}elseif ($image2 !== FILE_STATUS_NOT_FOUND) {
		Controller::setError("تصویر دوم با موفقیت آپلود نشد.");
		goto out;
	}
	if (gettype($image3) === "string") {
		array_push($images, $image3);
	}elseif ($image3 !== FILE_STATUS_NOT_FOUND) {
		Controller::setError("تصویر سوم با موفقیت آپلود نشد.");
		goto out;
	}
	if (gettype($image4) === "string") {
		array_push($images, $image4);
	}elseif ($image4 !== FILE_STATUS_NOT_FOUND) {
		Controller::setError("تصویر چهارم با موفقیت آپلود نشد.");
		goto out;
	}

	ProductRepository::create(
		$owner,
		$type,
		$colors,
		$materials,
		$sizes,
		$name,
		$description,
		$images,
		$count,
		$price,
		$offer
	);

	checkError();
}elseif ($req === CONTROLLER_PRODUCT_UPDATE) {
	$product = getProduct($productId);
	hasPermission($product->owner, $account->id, $account->role);

	$type = (int)Controller::getRequest("type");
	$name = Controller::getRequest("name");
	$description = Controller::getRequest("description");
	$price = (int)Controller::getRequest("price");
	$count = (int)Controller::getRequest("count");
	$offer = (int)Controller::getRequest("offer");
	$colors = Controller::fetchSerialized("color", CONTROLLER_PRODUCT_LIMIT_COLOR_COUNT, true, ",");
	$materials = Controller::fetchSerialized("material", CONTROLLER_PRODUCT_LIMIT_MATERIAL_COUNT);
	$sizes = Controller::fetchSerialized("size", CONTROLLER_PRODUCT_LIMIT_SIZE_COUNT);

	$imageMain = uploadFile("image_main", PRODUCT_IMAGE_DIR, true, $product->image[0]);

	$image2 = null;
	if (isset($product->image[1])) $image2 = uploadFile("image_2", PRODUCT_IMAGE_DIR, true, $product->image[1]);
	else $image2 = uploadFile("image_2", PRODUCT_IMAGE_DIR);

	$image3 = null;
	if (isset($product->image[2])) $image3 = uploadFile("image_3", PRODUCT_IMAGE_DIR, true, $product->image[2]);
	else $image3 = uploadFile("image_3", PRODUCT_IMAGE_DIR);

	$image4 = null;
	if (isset($product->image[3])) $image4 = uploadFile("image_4", PRODUCT_IMAGE_DIR, true, $product->image[3]);
	else $image4 = uploadFile("image_3", PRODUCT_IMAGE_DIR);

	$images = [];

	if (gettype($imageMain) === "string") {
		array_push($images, $imageMain);
	}elseif ($imageMain !== FILE_STATUS_NOT_FOUND) {
		Controller::setError(convertUploadErrorToString($imageMain));
		goto out;
	}else {
		if (isset($product->image[0])) array_push($images, $product->image[0]);
	}
	if (gettype($image2) === "string") {
		array_push($images, $image2);
	}elseif ($image2 !== FILE_STATUS_NOT_FOUND) {
		Controller::setError(convertUploadErrorToString($imageMain));
		goto out;
	}else {
		if (isset($product->image[1])) array_push($images, $product->image[1]);
	}
	if (gettype($image3) === "string") {
		array_push($images, $image3);
	}elseif ($image3 !== FILE_STATUS_NOT_FOUND) {
		Controller::setError(convertUploadErrorToString($imageMain));
		goto out;
	}else {
		if (isset($product->image[2])) array_push($images, $product->image[2]);
	}
	if (gettype($image4) === "string") {
		array_push($images, $image4);
	}elseif ($image4 !== FILE_STATUS_NOT_FOUND) {
		Controller::setError(convertUploadErrorToString($imageMain));
		goto out;
	}else {
		if (isset($product->image[3])) array_push($images, $product->image[3]);
	}

	if ($type !== null) $product->type = $type;
	if ($name) $product->name = $name;
	if ($description) $product->description = $description;
	if ($images) $product->image = $images;
	if ($price !== null) $product->price = $price;
	if ($count !== null) $product->count = $count;
	if ($offer !== null) $product->offer = $offer;

	ProductRepository::update($product);
	checkError();

	// Remove old colors
	$oldColors = ProductRepository::findColors($productId);
	checkError();

	foreach ($oldColors as $color) {
		ProductRepository::removeColor($color->id);
		checkError();
	}

	ProductRepository::addColors($productId, $colors);
	checkError();

	// Remove old materials
	$oldMaterials = ProductRepository::findMaterials($productId);
	checkError();

	foreach ($oldMaterials as $material) {
		ProductRepository::removeMaterial($material->id);
		checkError();
	}

	ProductRepository::addMaterials($productId, $materials);
	checkError();

	// Remove old sizes
	$oldSizes = ProductRepository::findSizes($productId);
	checkError();

	foreach ($oldSizes as $size) {
		ProductRepository::removeSize($size->id);
		checkError();
	}

	ProductRepository::addSizes($productId, $sizes);
	checkError();
}elseif ($req === CONTROLLER_PRODUCT_SUSPEND) {
	$product = getProduct($productId);
	hasPermission($product->owner, $account->id, $account->role);

	ProductRepository::updateStatus($productId, STATUS_SUSPENDED);
	checkError();
}elseif ($req === CONTROLLER_PRODUCT_REMOVE) {
	$product = getProduct($productId);
	hasPermission($product->owner, $account->id, $account->role);

	ProductRepository::remove($productId);
	checkError();
}elseif ($req === CONTROLLER_PRODUCT_RESTORE) {
	$product = getProduct($productId);
	hasPermission($product->owner, $account->id, $account->role);

	ProductRepository::updateStatus($productId, STATUS_OK);
	checkError();
}elseif ($req === CONTROLLER_PRODUCT_ACCEPT) {
	$product = getProduct($productId);
	hasPermission($product->owner, $account->id, $account->role);

	ProductRepository::updateStatus($productId, STATUS_OK);
	checkError();
}elseif ($req === CONTROLLER_PRODUCT_REJECT) {
	$product = getProduct($productId);
	hasPermission($product->owner, $account->id, $account->role);

	ProductRepository::remove($productId);
	checkError();
	ProductRepository::remove($productId);
	checkError();
}elseif ($req === CONTROLLER_PRODUCT_INC) {
	$product = getProduct($productId);
	hasPermission($product->owner, $account->id, $account->role);

	ProductRepository::updateCount($productId, $product->count + 1);
	checkError();
}elseif ($req === CONTROLLER_PRODUCT_DEC) {
	$product = getProduct($productId);
	hasPermission($product->owner, $account->id, $account->role);

	if ($product->count === 0) {
		goto out;
	}

	ProductRepository::updateCount($productId, $product->count - 1);
	checkError();
}

out:
Controller::redirect(Controller::getRequest("redirect"));

function getProduct(string|null $id): ProductModel {
	if ($id === null) {
		Controller::setError("شناسه محصول تنظیم نشده است.");
		Controller::redirect(Controller::getRequest("redirect"));
	}

	$product = ProductRepository::findById($id);

	if (ProductRepository::hasError()) {
		Controller::setError(ProductRepository::getError());
		Controller::redirect(Controller::getRequest("redirect"));
	}

	if ($product === null) {
		Controller::setError("محصول یافت نشد.");
		Controller::redirect(Controller::getRequest("redirect"));
	}

	return $product;
}

function hasPermission(string $productOwner, string $requestOwner, int $accountRole): void {
	if ($productOwner !== $requestOwner && $accountRole !== ROLE_ADMIN) {
		Controller::setError("شما مجوز ایجاد تغییر در این محصول را ندارید.");
		Controller::redirect(Controller::getRequest("redirect"));
	}
}

function checkError(): void {
	if (ProductRepository::hasError()) {
		Controller::setError(ProductRepository::getError());
		Controller::redirect(Controller::getRequest("redirect"));
	}
}

?>
