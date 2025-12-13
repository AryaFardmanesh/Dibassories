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
	<title>دیبا اکسسوری - داشبورد - حساب کاربری</title>
</head>
<body>
	<?php include __DIR__ . "/../../assets/components/navbar.php"; ?>
	<?php
		$setActiveLinkForSidebar = 'accounts';
		include __DIR__ . "/../../assets/components/sidebar.php";
	?>

	<main class="app-content" id="mainContent">
		<div class="d-flex justify-content-between align-items-center mb-4">
			<div class="d-flex align-items-center gap-2">
				<button class="btn btn-outline-primary d-lg-none p-0" aria-controls="appSidebar" aria-expanded="false">
					<img id="mobileSidebarBtn" src="<?= ASSETS_DIR ?>/img/icons/hamburger-button.png" alt="دکمه نوار کناری" width="25" />
				</button>
				<h4 class="mb-0">داشبورد مدیر - حساب کاربران</h4>
			</div>
			<div class="text-muted small">سلام، <?= $account->fname ?> — امروز <span class="show-time"></span></div>
		</div>

		<div class="row g-4">
			<div class="col-md-4">
				<div class="card shadow-sm">
					<div class="card-body">
						<h6 class="mb-1 fw-bold">تعداد کاربران</h6>
						<p class="h4 text-primary mb-0"><?= number_format((float)$usersCount) ?></p>
					</div>
				</div>
			</div>
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
									<th>موجودی کیف پول (تومان)</th>
									<th>نقش</th>
									<th>وضعیت</th>
									<th>اغدام ها</th>
								</tr>
							</thead>
							<tbody>

								<?php
									$i = ($page * PAGINATION_LIMIT) - PAGINATION_LIMIT;
									$users = AccountRepository::filter($page);
									foreach ($users as $users) {
										$roleColor = "success";
										if ($user->role === ROLE_ADMIN) $roleColor = "danger";
										elseif ($user->role !== ROLE_CUSTOMER) $roleColor = "warning";
										$i++;
								?>
								<tr>
									<td><?= $i ?></td>
									<td><?= $user->fname . " " . $user->lname ?></td>
									<td><?= $user->email ?></td>
									<td><?= $user->phone ?></td>
									<td><?= number_format((float)$user->wallet_balance) ?></td>
									<td><span class="badge bg-<?= $roleColor  ?>"><?= convertRolesToString($user->role) ?></span></td>
									<td><span class="badge bg-<?= convertStatusToColor($user->status) ?>"><?= convertStatusToString($user->status) ?></span></td>
									<td>
										<?php
											$blockOrUnblock = "مسدود";
											$blockOrUnblockReqCode = CONTROLLER_ACCOUNT_BLOCK;
											if ($user->status === STATUS_SUSPENDED) {
												$blockOrUnblock = "رفع مسدود";
												$blockOrUnblockReqCode = CONTROLLER_ACCOUNT_UNBLOCK;
											}

											$upgradeRoleDisabled = "";
											$downgradeRoleDisabled = "";
											if ($user->role == ROLE_ADMIN) $upgradeRoleDisabled = "disabled";
											elseif ($user->role == ROLE_CUSTOMER) $downgradeRoleDisabled = "disabled";

											$blockOrUnblockLink = Controller::makeControllerUrl("accounts", $blockOrUnblockReqCode, [
												"user" => $user->id,
												"redirect" => dirname($_SERVER["PHP_SELF"])
											]);
											$upgradeRoleLink = Controller::makeControllerUrl("accounts", CONTROLLER_ACCOUNT_UPGRADE, [
												"user" => $user->id,
												"redirect" => dirname($_SERVER["PHP_SELF"])
											]);
											$downgradeRoleLink = Controller::makeControllerUrl("accounts", CONTROLLER_ACCOUNT_DOWNGRADE, [
												"user" => $user->id,
												"redirect" => dirname($_SERVER["PHP_SELF"])
											]);
										?>
										<a href="<?= $blockOrUnblockLink ?>" class="btn btn-sm btn-danger w-100 mb-1"><?= $blockOrUnblock ?></a>
										<a href="<?= $upgradeRoleLink ?>" class="btn btn-sm btn-danger w-100 mb-1 <?= $upgradeRoleDisabled ?>">ارتقای نقش</a>
										<a href="<?= $downgradeRoleLink ?>" class="btn btn-sm btn-danger w-100 <?= $downgradeRoleDisabled ?>">تنزل نقش</a>
									</td>
								</tr>
								<?php } ?>

							</tbody>
						</table>
					</div>

					<div class="container-fluid">
						<?php echo createPagination(AccountRepository::getPageCount(), $page); ?>
					</div>
				</div>
			</div>
		</section>
	</main>

	<?php include __DIR__ . "/../../assets/components/footer.php"; ?>
</body>
</html>
