<?php include __DIR__ . "/../src/config.php"; ?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="<?= ASSETS_DIR ?>/img/logo/logo-nobg.png" type="image/x-icon" />
	<link rel="stylesheet" href="<?= ASSETS_DIR ?>/libs/bootstrap.rtl.min.css" />
	<link rel="stylesheet" href="<?= ASSETS_DIR ?>/fonts/font.patch.css" />
	<script src="<?= ASSETS_DIR ?>/libs/jquery.min.js"></script>
	<script src="<?= ASSETS_DIR ?>/libs/bootstrap.bundle.min.js"></script>
	<title>دیبا اکسسوری - داشبورد</title>
	<style>
	:root{
		--sidebar-width: 260px;
		--sidebar-collapsed: 72px;
		--sidebar-bg: #ffffff;
		--sidebar-border: #e9ecef;
		--accent: #0d6efd;
	}
	body {
		font-family: "Vazir", system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
		background: #f6f7fb;
		color: #222;
	}
	.app-sidebar {
		position: fixed;
		top: 0;
		left: 0;
		height: 100vh;
		width: var(--sidebar-width);
		background: var(--sidebar-bg);
		border-right: 1px solid var(--sidebar-border);
		padding: 1rem 0.6rem;
		transition: width .28s ease, box-shadow .28s ease;
		z-index: 1030;
		overflow: hidden;
	}
	.app-sidebar.collapsed {
		width: var(--sidebar-collapsed);
	}
	.sidebar-brand {
		display: flex;
		align-items: center;
		gap: .8rem;
		padding: .4rem .6rem;
		margin-bottom: .6rem;
	}
	.sidebar-brand .brand-title {
		font-weight: 700;
		color: var(--accent);
		font-size: 1.05rem;
	}
	.sidebar-nav {
		margin-top: .5rem;
		display: flex;
		flex-direction: column;
		gap: .25rem;
		padding: 0 .4rem;
	}
	.sidebar-nav .nav-item {
		--pad: .6rem;
		display:flex;
	}
	.sidebar-nav .nav-link {
		display: flex;
		align-items: center;
		gap: .75rem;
		width: 100%;
		border-radius: .6rem;
		padding: .6rem .6rem;
		color: #495057;
		text-decoration: none;
		transition: background .18s, color .18s, transform .18s;
	}
	.sidebar-nav .nav-link:hover {
		background: rgba(13,110,253,0.08);
		color: var(--accent);
		transform: translateX(-4px);
	}
	.sidebar-nav .nav-link i {
		font-size: 1.15rem;
		width: 28px;
		text-align: center;
		color: #6c757d;
	}
	.sidebar-nav .nav-link .nav-text {
		white-space: nowrap;
		overflow: hidden;
		text-overflow: ellipsis;
		font-weight: 600;
		font-size: .95rem;
	}
	.app-sidebar.collapsed .nav-text { 
		display: none;
	}
	.app-sidebar.collapsed .nav-link { 
		justify-content: center;
		padding: .6rem 0;
	}
	.sidebar-nav .nav-link.active {
		background: linear-gradient(90deg, rgba(13,110,253,0.08), rgba(13,110,253,0.03));
		color: var(--accent) !important;
		box-shadow: inset 0 0 0 1px rgba(13,110,253,0.06);
	}
	.sidebar-footer {
		margin-top: auto;
		padding: .6rem;
	}
	.app-content {
		margin-left: var(--sidebar-width);
		transition: margin-left .28s ease;
		padding: 1.5rem;
	}
	.app-sidebar.collapsed ~ .app-content {
		margin-left: var(--sidebar-collapsed);
	}
	@media (max-width: 991.98px) {
		.app-sidebar {
			transform: translateX(-110%);
			left: 0;
			box-shadow: none;
		}
		.app-sidebar.show {
			transform: translateX(0);
			box-shadow: 0 .5rem 1.25rem rgba(9,30,66,0.08);
		}
		.app-content {
			margin-left: 0;
		}
	}
	.badge-sidebar {
		font-size: .72rem;
		padding: .25rem .45rem;
		border-radius: .5rem;
	}
	</style>
</head>
<body>
	<?php include __DIR__ . "/../assets/components/navbar.php"; ?>
	<?php
		$setActiveLinkForSidebar = 'docs';
		include __DIR__ . "/../assets/components/sidebar.php";
	?>

	<main class="app-content" id="mainContent">
		<div class="d-flex justify-content-between align-items-center mb-4">
			<div class="d-flex align-items-center gap-2">
				<button class="btn btn-outline-primary d-lg-none p-0" aria-controls="appSidebar" aria-expanded="false">
					<img id="mobileSidebarBtn" src="<?= ASSETS_DIR ?>/img/icons/hamburger-button.png" alt="دکمه نوار کناری" width="25" />
				</button>
				<h4 class="mb-0">داشبورد مدیر</h4>
			</div>
			<div class="text-muted small">سلام، آریا — امروز <span class="show-time">۱۴۰۳/۰۸/۲۵</span></div>
		</div>

		<div class="row g-4">
			<div class="col-md-4">
				<div class="card shadow-sm">
					<div class="card-body">
						<h6 class="mb-1 fw-bold">تعداد کاربران</h6>
						<p class="h4 text-primary mb-0">1,234</p>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card shadow-sm">
					<div class="card-body">
						<h6 class="mb-1 fw-bold">محصولات</h6>
						<p class="h4 text-success mb-0">356</p>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card shadow-sm">
					<div class="card-body">
						<h6 class="mb-1 fw-bold">سفارش‌های در انتظار</h6>
						<p class="h4 text-warning mb-0">12</p>
					</div>
				</div>
			</div>
		</div>
	</main>

	<script>
		$( function() {
			const $sidebar = $( '#appSidebar' );
			const $toggle = $( '#sidebarToggle' );
			const $mobileBtn = $( '#mobileSidebarBtn' );
			const $times = $( '.show-time' );

			$toggle.on( 'click', function() {
				$sidebar.toggleClass( 'collapsed' );
				const $icon = $( this ).find( 'i' );

				if ( $sidebar.hasClass( 'collapsed' ) ) {
					$icon.removeClass( 'bi-chevron-left' ).addClass( 'bi-chevron-right' );
				} else {
					$icon.removeClass( 'bi-chevron-right' ).addClass( 'bi-chevron-left' );
				}

				$sidebar.find( '.collapse.show' ).collapse( 'hide' );
			} );

			$mobileBtn.on( 'click', function() {
				$sidebar.toggleClass( 'show' );
			} );

			const now = new Date();
			$times.text( `${ now.getFullYear() }/${ now.getMonth() }/${ now.getDay() }` );

			$( document ).on( 'click touchstart', function( e ) {
				if ( $( window ).width() < 992 ) {
					if (
							!$sidebar.is( e.target ) &&
							$sidebar.has( e.target ).length === 0 &&
							!$mobileBtn.is( e.target ) &&
							$sidebar.hasClass( 'show' )
						) {
						$sidebar.removeClass( 'show' );
					}
				}
			} );
		} );
	</script>

	<?php include __DIR__ . "/../assets/components/footer.php"; ?>
</body>
</html>
