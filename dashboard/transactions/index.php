<?php

include __DIR__ . "/../../src/config.php";
include __DIR__ . "/../../assets/components/pagination.php";
include __DIR__ . "/../../src/utils/convert.php";
include __DIR__ . "/../../src/controllers/controller.php";
include __DIR__ . "/../../src/repositories/transactions.php";
include __DIR__ . "/../../src/services/accounts.php";

$account = AccountService::getAccountFromCookie();
$page = Controller::getRequest("page");

if ($page === null) {
	$page = 1;
}

if ($account === null || $account->role !== ROLE_ADMIN) {
	Controller::redirect(null);
}

$transactions = TransactionRepository::findAll(1, PHP_INT_MAX);
$transactionsCount = 0;
$transactionsTotalAmount = 0;
$transactionTotalAmountToday = 0;
foreach ($transactions as $transaction) {
	$transactionsCount++;
	if ($transaction->type === TRANSACTION_TYPE_EXCHANGE) {
		$transactionsTotalAmount -= $transaction->amount;
	}else {
		$transactionsTotalAmount += $transaction->amount;
	}
	if ($transaction->created_at->format("Y/m/d") === date("Y/m/d")) {
		if ($transaction->type === TRANSACTION_TYPE_EXCHANGE) {
			$transactionTotalAmountToday -= $transaction->amount;
		}else {
			$transactionTotalAmountToday += $transaction->amount;
		} 
	}
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
	<link rel="stylesheet" href="<?= ASSETS_DIR ?>/css/slidebar.css" />
	<script src="<?= ASSETS_DIR ?>/libs/jquery.min.js"></script>
	<script src="<?= ASSETS_DIR ?>/libs/bootstrap.bundle.min.js"></script>
	<script src="<?= ASSETS_DIR ?>/scripts/slidebar.js"></script>
	<title>دیبا اکسسوری - داشبورد - تراکنش ها</title>
</head>
<body>
	<?php include __DIR__ . "/../../assets/components/navbar.php"; ?>
	<?php
		$setActiveLinkForSidebar = 'transactions';
		include __DIR__ . "/../../assets/components/sidebar.php";
	?>

	<main class="app-content" id="mainContent">
		<div class="d-flex justify-content-between align-items-center mb-4">
			<div class="d-flex align-items-center gap-2">
				<button class="btn btn-outline-primary d-lg-none p-0" aria-controls="appSidebar" aria-expanded="false">
					<img id="mobileSidebarBtn" src="<?= ASSETS_DIR ?>/img/icons/hamburger-button.png" alt="دکمه نوار کناری" width="25" />
				</button>
				<h4 class="mb-0">داشبورد مدیر - تراکنش ها</h4>
			</div>
			<div class="text-muted small">سلام، <?= $account->fname ?> — امروز <span class="show-time"></span></div>
		</div>

		<div class="row g-4">
			<div class="col-md-4">
				<div class="card shadow-sm">
					<div class="card-body">
						<h6 class="mb-1 fw-bold">تعداد تراکنش ها</h6>
						<p class="h4 text-primary mb-0"><?= number_format((float)$transactionsCount) ?></p>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card shadow-sm">
					<div class="card-body">
						<h6 class="mb-1 fw-bold">جمع تراکنش ها</h6>
						<p class="h4 text-<?= $transactionsTotalAmount >= 0 ? "success" : "danger" ?> mb-0"><?= number_format((float)$transactionsTotalAmount) ?></p>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card shadow-sm">
					<div class="card-body">
						<h6 class="mb-1 fw-bold">جمع تراکنش های امروز</h6>
						<p class="h4 text-warning mb-0"><?= $transactionTotalAmountToday ?></p>
					</div>
				</div>
			</div>
		</div>

		<hr />

		<section class="container-fluid my-5">
			<div class="card shadow-sm border-0 rounded-4">
				<div class="card-body p-4 p-md-5">
					<div class="table-responsive">
						<table class="table align-middle text-center">
							<thead class="table-light">
								<tr>
									<th>#</th>
									<th>نام</th>
									<th>شماره کارت</th>
									<th>شماره شبا</th>
									<th>مبلغ</th>
									<th>نوع تراکنش</th>
									<th>وضعیت</th>
									<th>تاریخ</th>
									<th>اغدام ها</th>
								</tr>
							</thead>
							<tbody>

								<?php
									$i = ($page * PAGINATION_LIMIT) - PAGINATION_LIMIT;
									foreach ($transactions as $transaction) {
										$i++;
										$owner = AccountRepository::findById($transaction->wallet);
								?>
								<tr>
									<td><?= $i ?></td>
									<td><?= $owner->fname . " " . $owner->lname ?></td>
									<td><?= join("-", str_split($owner->card_number, 4)) ?></td>
									<td>IR-<?= $owner->card_terminal ?></td>
									<td><?= number_format((float)$transaction->amount) ?></td>
									<td><span class="badge text-bg-success"><?= convertTransactionTypeToString($transaction->type) ?></span></td>
									<td><span class="badge text-bg-<?= convertStatusToColor($transaction->status) ?>"><?= convertStatusToString($transaction->status) ?></span></td>
									<td><?= $transaction->created_at->format("Y/m/d") ?></td>
									<td>
										<?php
											$payBtnText = "پرداخت شده";
											$payBtnReqCode = CONTROLLER_TRANSACTION_STATUS_PAID;
											$openBtnDisabled = "";
											$blockBtnDisabled = "";

											if ($transaction->status === STATUS_PAID) {
												$payBtnText = "پرداخت نشده";
												$payBtnReqCode = CONTROLLER_TRANSACTION_STATUS_NOT_PAID;
											}elseif ($transaction->status === STATUS_OPENED) {
												$openBtnDisabled = "disabled";
											}elseif ($transaction->status === STATUS_SUSPENDED) {
												$blockBtnDisabled = "disabled";
											}

											$removeLink = Controller::makeControllerUrl("transactions", CONTROLLER_TRANSACTION_REMOVE, [
												"user" => $account->id,
												"transaction" => $transaction->id,
												"redirect" => dirname($_SERVER["PHP_SELF"])
											]);
											$payLink = Controller::makeControllerUrl("transactions", $payBtnReqCode, [
												"user" => $account->id,
												"transaction" => $transaction->id,
												"redirect" => dirname($_SERVER["PHP_SELF"])
											]);
											$openLink = Controller::makeControllerUrl("transactions", CONTROLLER_TRANSACTION_OPEN, [
												"user" => $account->id,
												"transaction" => $transaction->id,
												"redirect" => dirname($_SERVER["PHP_SELF"])
											]);
											$blockLink = Controller::makeControllerUrl("transactions", CONTROLLER_TRANSACTION_STATUS_SUSPENDED, [
												"user" => $account->id,
												"transaction" => $transaction->id,
												"redirect" => dirname($_SERVER["PHP_SELF"])
											]);
										?>
										<a href="<?= $removeLink ?>" class="btn btn-sm btn-danger w-100 mb-1">حذف</a>
										<a href="<?= $payLink ?>" class="btn btn-sm btn-danger w-100 mb-1"><?= $payBtnText ?></a>
										<a href="<?= $openLink ?>" class="btn btn-sm btn-danger w-100 mb-1 <?= $openBtnDisabled ?>">باز</a>
										<a href="<?= $blockLink ?>" class="btn btn-sm btn-danger w-100 mb-1 <?= $blockBtnDisabled ?>">معلق</a>
									</td>
								</tr>
								<?php } ?>

							</tbody>
						</table>
					</div>

					<div class="container-fluid">
						<?= createPagination(TransactionRepository::getPageCount(), $page) ?>
					</div>
				</div>
			</div>
		</section>
	</main>

	<?php include __DIR__ . "/../../assets/components/footer.php"; ?>
</body>
</html>
