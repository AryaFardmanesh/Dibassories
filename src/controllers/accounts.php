<?php

include_once __DIR__ . "/controller.php";
include_once __DIR__ . "/../repositories/accounts.php";

$req = (int)Controller::getRequest(CONTROLLER_REQ_NAME);
$user = Controller::getRequest("user");

if ($req === CONTROLLER_ACCOUNT_UPDATE) {
	$username = Controller::getRequest("username");
	$email = Controller::getRequest("email");
	$fname = Controller::getRequest("fname");
	$lname = Controller::getRequest("lname");
	$phone = Controller::getRequest("phone");
	$zipcode = Controller::getRequest("zipcode");
	$address = Controller::getRequest("address");
	$card_number = Controller::getRequest("card_number");
	$card_terminal = Controller::getRequest("card_terminal");
	$instagram = Controller::getRequest("instagram");
	$telegram = Controller::getRequest("telegram");

	$account = AccountRepository::findById($user);

	if (AccountRepository::hasError()) {
		Controller::setError(AccountRepository::getError());
		goto out;
	}

	if ($account === null) {
		Controller::setError("کاربر یافت نشد.");
		goto out;
	}

	if ($username) $account->username = $username;
	if ($email) $account->email = $email;
	if ($fname) $account->fname = $fname;
	if ($lname) $account->lname = $lname;
	if ($phone) $account->phone = $phone;
	if ($zipcode) $account->zipcode = $zipcode;
	if ($address) $account->address = $address;
	if ($card_number) $account->card_number = $card_number;
	if ($card_terminal) $account->card_terminal = $card_terminal;
	if ($instagram) $account->instagram = $instagram;
	if ($telegram) $account->telegram = $telegram;

	AccountRepository::update($account);

	if (AccountRepository::hasError()) {
		Controller::setError(AccountRepository::getError());
		goto out;
	}
}elseif ($req === CONTROLLER_ACCOUNT_BLOCK) {
	AccountRepository::updateStatus($user, STATUS_SUSPENDED);

	if (AccountRepository::hasError()) {
		Controller::setError(AccountRepository::getError());
		goto out;
	}
}elseif ($req === CONTROLLER_ACCOUNT_UPGRADE) {
	// ...
}elseif ($req === CONTROLLER_ACCOUNT_DOWNGRADE) {
	// ...
}elseif ($req === CONTROLLER_ACCOUNT_SELLER_REQUEST) {
	// ...
}elseif ($req === CONTROLLER_ACCOUNT_SELLER_ACCEPT) {
	// ...
}elseif ($req === CONTROLLER_ACCOUNT_SELLER_REJECT) {
	// ...
}

out:
Controller::redirect(Controller::getRequest("redirect"));

?>
