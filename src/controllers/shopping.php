<?php

include_once __DIR__ . "/controller.php";
include_once __DIR__ . "/../repositories/accounts.php";
include_once __DIR__ . "/../repositories/carts.php";
include_once __DIR__ . "/../repositories/products.php";
include_once __DIR__ . "/../repositories/orders.php";
include_once __DIR__ . "/../repositories/sessions.php";

$req = (int)Controller::getRequest(CONTROLLER_REQ_NAME, true);
$user = Controller::getRequest("user", true);

$account = AccountRepository::findById($user);

if (AccountRepository::hasError()) {
	Controller::setError(AccountRepository::getError());
	goto out;
}

if ($account === null) {
	Controller::setError("کاربر یافت نشد.");
	goto out;
}

if ($req === CONTROLLER_ORDER_PURCHE) {
	$paymentMethod = (int)Controller::getRequest("payment-method", true);
	$address = Controller::getRequest("address", true);
	$zipcode = Controller::getRequest("zipcode", true);
	$phone = Controller::getRequest("phone", true);

	if ($paymentMethod === PAYMENT_METHOD_WALLET) {
		$cart = ShoppingCartRepository::find($user);

		if (ShoppingCartRepository::hasError()) {
			Controller::setError(ShoppingCartRepository::getError());
			goto out;
		}

		$total = 0;

		foreach ($cart as $row) {
			$product = ProductRepository::findById($row->product);

			if (ProductRepository::hasError()) {
				Controller::setError(ProductRepository::getError());
				goto out;
			}

			if ($product->count < $row->count) {
				Controller::setError("تعداد یکی از محصولات در انبار کمتر از تعداد سفارش شما است.");
				goto out;
			}

			$price = $product->price - ($product->price * $product->offer / 100);
			$total += ($price * $row->count);
		}

		if ($account->wallet_balance < $total) {
			Controller::setError("موجودی کیف پول شما کمتر از مبلغ نهایی است.");
			goto out;
		}

		foreach ($cart as $row) {
			$product = ProductRepository::findById($row->product);

			if (ProductRepository::hasError()) {
				Controller::setError(ProductRepository::getError());
				goto out;
			}

			$price = $product->price - ($product->price * $product->offer / 100);
			$price *= $row->count;

			OrderRepository::create(
				$user,
				$product->owner,
				$product->id,
				$row->product_color,
				$row->product_material,
				$row->product_size,
				$row->count,
				$price,
				$phone,
				$address,
				$zipcode
			);

			if (OrderRepository::hasError()) {
				Controller::setError(OrderRepository::getError());
				goto out;
			}

			ProductRepository::updateCount($product->id, $product->count - $row->count);

			if (ProductRepository::hasError()) {
				Controller::setError(ProductRepository::getError());
				goto out;
			}

			ShoppingCartRepository::remove($user, $product->id);

			if (ShoppingCartRepository::hasError()) {
				Controller::setError(ShoppingCartRepository::getError());
				goto out;
			}

			$account->wallet_balance -= $price;
			AccountRepository::update($account);

			if (AccountRepository::hasError()) {
				Controller::setError(AccountRepository::getError());
				goto out;
			}
		}
	}elseif ($paymentMethod === PAYMENT_METHOD_ONLINE) {
		// Should be connect to ZarinPal gateway.
		Controller::setError("سرور هنوز به درگاه پرداخت متصل نیست.");
		goto out;
	}else {
		Controller::setError("روش پرداخت شما نامعبتر است.");
		goto out;
	}
}

out:
Controller::redirect(Controller::getRequest("redirect"));

?>
