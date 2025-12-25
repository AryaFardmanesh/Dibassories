<?php

include __DIR__ . "/../../src/config.php";
include __DIR__ . "/../../assets/components/pagination.php";
include __DIR__ . "/../../src/utils/convert.php";
include __DIR__ . "/../../src/controllers/controller.php";
include __DIR__ . "/../../src/repositories/products.php";
include __DIR__ . "/../../src/repositories/orders.php";
include __DIR__ . "/../../src/services/accounts.php";

$account = AccountService::getAccountFromCookie();
$page = Controller::getRequest("page");

if ($page === null) {
	$page = 1;
}

if ($account === null || $account->role !== ROLE_ADMIN) {
	Controller::redirect(null);
}

$users = AccountRepository::filter(1, PHP_INT_MAX);
$usersCount = 0;
$sellersCount = 0;
$customersCount = 0;
foreach ($users as $user) {
	$usersCount++;
	if ($user->role === ROLE_SELLER) $sellersCount++;
	if ($user->role === ROLE_CUSTOMER) $customersCount++;
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
	<title><?= PROJ_NAME ?> - داشبورد - حساب کاربری</title>
</head>
<body>
	<?php include __DIR__ . "/../../assets/components/navbar.php"; ?>
	<?php
		$setActiveLinkForSidebar = 'accounts_confirm';
		include __DIR__ . "/../../assets/components/sidebar.php";
	?>

	<main class="app-content" id="mainContent">
		<div class="d-flex justify-content-between align-items-center mb-4">
			<div class="d-flex align-items-center gap-2">
				<button class="btn btn-outline-primary d-lg-none p-0" aria-controls="appSidebar" aria-expanded="false">
					<img id="mobileSidebarBtn" src="<?= ASSETS_DIR ?>/img/icons/hamburger-button.png" alt="دکمه نوار کناری" width="25" />
				</button>
				<h4 class="mb-0">داشبورد مدیر - تایید حساب فروشندگان</h4>
			</div>
			<div class="text-muted small">سلام، <?= $account->fname ?> — امروز <span class="show-time"></span></div>
		</div>

		<div class="row g-4">
			<div class="col-md-4">
				<div class="card shadow-sm">
					<div class="card-body">
						<h6 class="mb-1 fw-bold">تعداد فروشندگان</h6>
						<p class="h4 text-success mb-0"><?= number_format((float)$sellersCount) ?></p>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card shadow-sm">
					<div class="card-body">
						<h6 class="mb-1 fw-bold">تعداد خریداران</h6>
						<p class="h4 text-warning mb-0"><?= number_format((float)$customersCount) ?></p>
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
									<th>ایمیل</th>
									<th>شماره تلفن</th>
									<th>کد ملی</th>
									<th>شماره حساب</th>
									<th>شبکه های اجتماعی</th>
									<th>اغدام ها</th>
								</tr>
							</thead>
							<tbody>

								<?php
									$i = ($page * PAGINATION_LIMIT) - PAGINATION_LIMIT;
									$users = AccountRepository::filterConfirmRequest($page, PAGINATION_LIMIT);
									foreach ($users as $user) {
										$user = AccountRepository::findById($user->user);
										$i++;
								?>
								<tr>
									<td><?= $i ?></td>
									<td><?= $user->fname . " " . $user->lname ?></td>
									<td><?= $user->email ?></td>
									<td><?= $user->phone ?></td>
									<td><?= $user->pangirno ?></td>
									<td><?= join("-", str_split($user->card_number, 4)) ?></td>
									<td>
										<a href="<?= $user->telegram ?>" class="text-decoration-none">
											<img src="<?= ASSETS_DIR ?>/img/icons/telegram.png" width="25" alt="Telegram Icon">
										</a>
										<a href="<?= $user->instagram ?>" class="text-decoration-none">
											<img src="<?= ASSETS_DIR ?>/img/icons/instagram.png" width="25" alt="Instagram Icon">
										</a>
									</td>
									<td>
										<?php
											$acceptUserLink = Controller::makeControllerUrl("accounts", CONTROLLER_ACCOUNT_SELLER_ACCEPT, [
												"user" => $user->id,
												"redirect" => dirname($_SERVER["PHP_SELF"])
											]);
											$rejectUserLink = Controller::makeControllerUrl("accounts", CONTROLLER_ACCOUNT_SELLER_REJECT, [
												"user" => $user->id,
												"redirect" => dirname($_SERVER["PHP_SELF"])
											]);
										?>
										<a href="<?= $acceptUserLink ?>" class="btn btn-sm btn-success w-100 mb-1">تایید</a>
										<a href="<?= $rejectUserLink ?>" class="btn btn-sm btn-danger w-100">رد</a>
									</td>
								</tr>
								<?php } ?>

							</tbody>
						</table>
					</div>

					<div class="container-fluid">
						<?= createPagination(AccountRepository::getPageCountForRequest(PAGINATION_LIMIT), $page) ?>
					</div>
				</div>
			</div>
		</section>
	</main>

	<?php include __DIR__ . "/../../assets/components/footer.php"; ?>
</body>
</html>
