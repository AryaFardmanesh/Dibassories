<?php include_once __DIR__ . "/../../src/config.php"; ?>
<footer class="bg-light pt-5 pb-3 mt-5 border-top">
	<div class="container">
		<div class="row gy-4">

		<div class="col-md-4">
			<h5 class="fw-bold mb-3 text-primary">فروشگاه اکسسوری</h5>
			<p class="small text-light-emphasis">
				این وبسایت صرفا یک پروژه دانشگاهی است و هدف ارئه خدمات واقعی را ندارد.
			</p>
		</div>

		<div class="col-md-4">
			<h6 class="fw-bold mb-3 text-primary">لینک‌های مفید</h6>
			<ul class="list-unstyled small">
				<li><a href="<?= BASE_URL ?>/" class="text-dark text-decoration-none">خانه</a></li>
				<li><a href="<?= BASE_URL ?>/#aboutus" class="text-dark text-decoration-none">درباره ما</a></li>
				<li><a href="<?= BASE_URL ?>/products/" class="text-dark text-decoration-none">محصولات</a></li>
				<li><a href="<?= BASE_URL ?>/login/" class="text-dark text-decoration-none">ورود</a></li>
			</ul>
		</div>

		<div class="col-md-4">
			<h6 class="fw-bold mb-3 text-primary">شبکه‌های اجتماعی</h6>
			<ul class="list-inline">
				<li class="list-inline-item">
					<a href="https://github.com" target="_blank" class="btn btn-outline-light btn-sm rounded-circle">
						<img src="<?= ASSETS_DIR ?>/img/icons/github.png" width="30" height="30" alt="GitHub Logo">
					</a>
				</li>
				<li class="list-inline-item">
					<a href="https://t.me/Ali1383z" target="_blank" class="btn btn-outline-light btn-sm rounded-circle">
						<img src="<?= ASSETS_DIR ?>/img/icons/telegram.png" width="38" height="38" alt="Telegram Logo">
					</a>
				</li>
			</ul>
		</div>

		</div>

		<hr class="border-secondary my-4">

		<div class="text-center small">
			<span>© 2025 - طراحی و توسعه توسط <strong>علی محجوب</strong></span>
			<br>
			<span class="text-secondary">مجوز: MIT</span>
		</div>
	</div>
</footer>
