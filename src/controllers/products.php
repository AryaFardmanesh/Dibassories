<?php

use function PHPSTORM_META\type;

include_once __DIR__ . "/controller.php";
include_once __DIR__ . "/../repositories/products.php";
include_once __DIR__ . "/../repositories/accounts.php";
include_once __DIR__ . "/../utils/upload.php";

$req = (int)Controller::getRequest(CONTROLLER_REQ_NAME, true);
$owner = Controller::getRequest("owner", true);
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
	$sizes = Controller::fetchSerialized("material", CONTROLLER_PRODUCT_LIMIT_SIZE_COUNT);

	$imageMain = uploadFile("image_main", PRODUCT_IMAGE_DIR);
	$image2 = uploadFile("image_2", PRODUCT_IMAGE_DIR);
	$image3 = uploadFile("image_3", PRODUCT_IMAGE_DIR);
	$image4 = uploadFile("image_4", PRODUCT_IMAGE_DIR);

	$images = [];

	if (gettype($imageMain) === "string") {
		array_push($images, $imageMain);
	}elseif ($imageMain !== FILE_STATUS_NOT_FOUND) {
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
	$sizes = Controller::fetchSerialized("material", CONTROLLER_PRODUCT_LIMIT_SIZE_COUNT);

	$imageMain = uploadFile("image_main", PRODUCT_IMAGE_DIR, true, $product->image[0]);
	$image2 = uploadFile("image_2", PRODUCT_IMAGE_DIR, true, $product->image[1]);
	$image3 = uploadFile("image_3", PRODUCT_IMAGE_DIR, true, $product->image[2]);
	$image4 = uploadFile("image_4", PRODUCT_IMAGE_DIR, true, $product->image[3]);

	$images = [];

	if (gettype($imageMain) === "string") {
		array_push($images, $imageMain);
	}elseif ($imageMain !== FILE_STATUS_NOT_FOUND) {
		Controller::setError(convertUploadErrorToString($imageMain));
		goto out;
	}
	if (gettype($image2) === "string") {
		array_push($images, $image2);
	}elseif ($image2 !== FILE_STATUS_NOT_FOUND) {
		Controller::setError(convertUploadErrorToString($imageMain));
		goto out;
	}
	if (gettype($image3) === "string") {
		array_push($images, $image3);
	}elseif ($image3 !== FILE_STATUS_NOT_FOUND) {
		Controller::setError(convertUploadErrorToString($imageMain));
		goto out;
	}
	if (gettype($image4) === "string") {
		array_push($images, $image4);
	}elseif ($image4 !== FILE_STATUS_NOT_FOUND) {
		Controller::setError(convertUploadErrorToString($imageMain));
		goto out;
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

	foreach ($colors as $color) {
		$name = $color[0];
		$hex = $color[1];

		ProductRepository::updateColor($productId, $name, $hex);
		checkError();
	}

	foreach ($materials as $material) {
		ProductRepository::updateMaterial($productId, $material);
		checkError();
	}

	foreach ($sizes as $size) {
		ProductRepository::updateSize($productId, $size);
		checkError();
	}
}elseif ($req === CONTROLLER_PRODUCT_SUSPEND) {
	$product = getProduct($productId);
	hasPermission($product->owner, $account->id, $account->role);

	ProductRepository::updateStatus($productId, STATUS_SUSPENDED);
	checkError();
}elseif ($req === CONTROLLER_PRODUCT_REMOVE) {
	// ...
}elseif ($req === CONTROLLER_PRODUCT_RESTORE) {
	// ...
}elseif ($req === CONTROLLER_PRODUCT_ACCEPT) {
	// ...
}elseif ($req === CONTROLLER_PRODUCT_REJECT) {
	// ...
}elseif ($req === CONTROLLER_PRODUCT_INC) {
	// ...
}elseif ($req === CONTROLLER_PRODUCT_DEC) {
	// ...
}

out:
Controller::redirect(Controller::getRequest("redirect"));

function getProduct(string $id): ProductModel {
	$product = ProductRepository::findById($id);

	if (ProductRepository::hasError()) {
		Controller::setError(ProductRepository::getError());
		goto out;
	}

	if ($product === null) {
		Controller::setError("محصول یافت نشد.");
		goto out;
	}

	return $product;
}

function hasPermission(string $productOwner, string $requestOwner, int $accountRole): void {
	if ($productOwner !== $requestOwner || $accountRole !== ROLE_ADMIN) {
		Controller::setError("شما مجوز ایجاد تغییر در این محصول را ندارید.");
		goto out;
	}
}

function checkError(): void {
	if (ProductRepository::hasError()) {
		Controller::setError(ProductRepository::getError());
		goto out;
	}
}

?>
