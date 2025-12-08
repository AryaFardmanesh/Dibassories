<?php

include_once __DIR__ . "/service.php";
include_once __DIR__ . "/../repositories/products.php";
include_once __DIR__ . "/../config.php";

class ProductService extends BaseService {
	private static function find(string $field, string $id): ProductDetailModel|null {
		$productModel = null;

		if ($field === "id") {
			$productModel = ProductRepository::findById($id);
		}elseif ($field === "slug") {
			$productModel = ProductRepository::findBySlug($id);
		}else {
			ProductService::setError("فیلد $field معتبر نیست.");
			return null;
		}

		if (ProductRepository::hasError()) {
			ProductService::setError(ProductRepository::getError());
			return null;
		}

		if ($productModel === null) {
			ProductService::setError("این شناسه محصول وجود ندارد.");
			return null;
		}

		$colorModel = ProductRepository::findColors($id);
		$materialModel = ProductRepository::findMaterials($id);
		$sizeModel = ProductRepository::findSizes($id);

		if (ProductRepository::hasError()) {
			ProductService::setError(ProductRepository::getError());
			return null;
		}

		if ($colorModel === null || $materialModel === null || $sizeModel === null) {
			ProductService::setError("وابستگی های مصحول یافت نشد.");
			return null;
		}

		$model = new ProductDetailModel(
			$productModel,
			$colorModel,
			$materialModel,
			$sizeModel
		);

		return $model;
	}

	final public static function findById(string $id): ProductDetailModel|null {
		return ProductService::find("id", $id);
	}

	final public static function findBySlug(string $slug): ProductDetailModel|null {
		return ProductService::find("slug", $slug);
	}

	final public static function findAll(
		int $page = 1,
		int $sort = SORT_NEWEST,
		string|null $name = null,
		int|null $type = null,
		int|null $minPrice = null,
		int|null $maxPrice = null
	): array {
		$models = ProductRepository::filter(
			$page,
			PAGINATION_LIMIT,
			$sort,
			$name,
			$type,
			$minPrice,
			$maxPrice
		);

		if (ProductRepository::hasError()) {
			ProductService::setError(ProductRepository::getError());
			return [];
		}

		$result = [];
		foreach ($models as $model) {
			$colorModel = ProductRepository::findColors($model->id);
			$materialModel = ProductRepository::findMaterials($model->id);
			$sizeModel = ProductRepository::findSizes($model->id);

			if (ProductRepository::hasError()) {
				ProductService::setError(ProductRepository::getError());
				return [];
			}

			if ($colorModel === null || $materialModel === null || $sizeModel === null) {
				ProductService::setError("وابستگی های مصحول یافت نشد.");
				return [];
			}

			$product = new ProductDetailModel(
				$model,
				$colorModel,
				$materialModel,
				$sizeModel
			);

			array_push($result, $product);
		}

		return $result;
	}
}

?>
