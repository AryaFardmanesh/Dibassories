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
	<title>دیبا اکسسوری - پرداخت</title>
	<style>
	.product-card {
		border-radius: 1rem;
		transition: all 0.3s ease;
	}
	.product-card:hover {
		transform: translateY(-5px);
		box-shadow: 0 0.8rem 1.5rem rgba(0, 0, 0, 0.1);
	}
	.product-card img {
		height: 180px;
		object-fit: cover;
		border-top-left-radius: 1rem;
		border-top-right-radius: 1rem;
	}
	::-webkit-scrollbar {
		height: 8px;
	}
	::-webkit-scrollbar-thumb {
		background-color: #ccc;
		border-radius: 10px;
	}
	</style>
</head>
<body>
	<?php include __DIR__ . "/../assets/components/navbar.php"; ?>

	<!-- Validating forms -->
	<script>
		( function () {
			'use strict'

			const forms = document.querySelectorAll( '.needs-validation' );

			Array.from( forms ).forEach( function ( form ) {
				form.addEventListener( 'submit', function ( event ) {
					if ( !form.checkValidity() ) {
						event.preventDefault();
						event.stopPropagation();
					}

					form.classList.add( 'was-validated' );
				}, false );
			})
		} )()
	</script>

	<?php include __DIR__ . "/../assets/components/footer.php"; ?>
</body>
</html>
