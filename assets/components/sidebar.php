<?php

$activeLink = null;

if (isset($setActiveLinkForSidebar)) {
	$activeLink = $setActiveLinkForSidebar;
	unset($setActiveLinkForSidebar);
}

?>

<aside class="app-sidebar" id="appSidebar" aria-label="Main Sidebar">
	<div class="sidebar-brand d-flex align-items-center justify-content-center px-2">
		<div class="d-flex align-items-center">
			<span class="brand-title ms-2 nav-text">Dibassories Admin</span>
		</div>
	</div>

	<nav class="sidebar-nav" role="navigation" aria-label="Dashboard Navigation">
		<a class="nav-link <?= $activeLink == "docs" ? "active" : null ?>" href="/admin/docs.php">
			<span class="nav-text">مستندات</span>
		</a>
		<a class="nav-link <?= $activeLink == "accounts" ? "active" : null ?>" href="/admin/accounts.php">
			<span class="nav-text">حساب‌های کاربری</span>
		</a>
		<a class="nav-link <?= $activeLink == "accounts_confirm" ? "active" : null ?>" href="/admin/accounts_confirm.php">
			<span class="nav-text">تأیید حساب‌ها</span>
		</a>
		<a class="nav-link <?= $activeLink == "products" ? "active" : null ?>" href="/admin/products.php">
			<span class="nav-text">محصولات</span>
		</a>
		<a class="nav-link <?= $activeLink == "products_confirm" ? "active" : null ?>" href="/admin/products_confirm.php">
			<span class="nav-text">تأیید محصولات</span>
		</a>
		<a class="nav-link <?= $activeLink == "orders" ? "active" : null ?>" href="/admin/orders.php">
			<span class="nav-text">سفارشات</span>
		</a>
		<a class="nav-link <?= $activeLink == "transactions" ? "active" : null ?>" href="/admin/transactions.php">
			<span class="nav-text">تراکنش‌ها</span>
		</a>
	</nav>
</aside>

<?php

unset($activeLink);

?>
