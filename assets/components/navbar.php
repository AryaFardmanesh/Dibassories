<?php

include_once __DIR__ . "/../../src/services/accounts.php";
$account = AccountService::getAccountFromCookie();
$isLogin = false;

if ($account !== null) {
	$isLogin = true;
}

?>

<nav class="navbar navbar-expand-md navbar-light bg-white navbar-custom shadow-sm">
	<div class="container">
		<a class="navbar-brand" href="<?= BASE_URL ?>"><?= PROJ_NAME ?></a>

		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarContent">
			<ul class="navbar-nav me-auto mb-2 mb-md-0">
				<li class="nav-item">
					<a class="nav-link" href="<?= BASE_URL ?>/">خانه</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="<?= BASE_URL ?>/products/">محصولات</a>
				</li>
				<?php if ($isLogin) { ?>
				<li>
					<a class="nav-link" href="<?= BASE_URL ?>/logout/">خروج</a>
				</li>
				<?php } ?>
			</ul>

			<ul class="navbar-nav ms-auto mb-2 mb-md-0">
				<?php if ($isLogin) { ?>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle btn btn-info rounded" role="button" data-bs-toggle="dropdown">
							خوش آمدی <?= $account->fname ?>
						</a>
						<ul class="dropdown-menu dropdown-menu-end">
							<li><a class="dropdown-item" href="<?= BASE_URL ?>/profile/">پروفایل</a></li>
							<?php if ($account->role === ROLE_ADMIN) { ?>
								<li><hr class="dropdown-divider"></li>
							<li><a class="dropdown-item" href="<?= BASE_URL ?>/panel/">پنل</a></li>
							<li><a class="dropdown-item" href="<?= BASE_URL ?>/dashboard/">داشبورد</a></li>
							<?php }elseif ($account->role === ROLE_SELLER) { ?>
								<li><hr class="dropdown-divider"></li>
							<li><a class="dropdown-item" href="<?= BASE_URL ?>/panel/">پنل</a></li>
							<?php } ?>
						</ul>
					</li>
				<?php }else { ?>
					<li class="nav-item">
						<a class="nav-link btn btn-outline-primary me-2 right-custom-link d-inline-block" href="<?= BASE_URL ?>/login/">ورود</a>
					</li>
					<li class="nav-item">
						<a class="nav-link btn btn-outline-primary right-custom-link d-inline-block" href="<?= BASE_URL ?>/signup/">ثبت نام</a>
					</li>
				<?php } ?>
			</ul>
	</div>
	</div>
</nav>
