<?php

function createPagination(int $pageCount, int $currentPage): string {
	$previousDisabled = $currentPage === 1 ? "disabled" : "";
	$nextDisabled = $currentPage === $pageCount ? "disabled" : "";
	$currentUrl = dirname($_SERVER["PHP_SELF"]);

	if (!str_contains($currentUrl, "?")) {
		$currentUrl .= "?";
	}
	if (str_contains($currentPage, "page=")) {
		$currentUrl = str_replace("page=$currentPage", "", $currentUrl);
	}

	$nextLink = $currentUrl . ("page=" . ($currentPage + 1));
	$prevLink = $currentUrl . ("page=" . ($currentPage - 1));

	$partOneLinks = "";

	for ($i = $currentPage; $i < ($currentPage + 3); $i++) {
		$link = $currentUrl . ("page=" . $i);
		$isActive = $currentPage === $i ? "active" : null;
		$isDisabled = $i > $pageCount ? "disabled" : null;

		$partOneLinks .= "
		<li class='page-item $isActive $isDisabled'>
				<a class='page-link rounded-3' href='$link'>$i</a>
		</li>
		";
	}

	$partTwoLinks = "";

	if ($pageCount > 4) {
		for ($i = ($pageCount - 2); $i <= $pageCount; $i++) {
			$link = $currentUrl . ("page=" . $i);
			$isActive = $currentPage === $i ? "active" : null;
			$isDisabled = $i > $pageCount ? "disabled" : null;

			$partTwoLinks .= "
			<li class='page-item $isActive $isDisabled'>
				<a class='page-link rounded-3' href='$link'>$i</a>
			</li>
			";
		}
	}

	return "
	<section class='container my-5'>
		<nav>
			<ul class='pagination justify-content-center flex-wrap gap-2'>
				<li class='page-item $previousDisabled'>
					<a class='page-link rounded-3' href='$prevLink'>قبلی</a>
				</li>

				$partOneLinks

				<li class='page-item'>
					<span class='page-link border-0 bg-transparent text-muted'>...</span>
				</li>

				$partTwoLinks

				<li class='page-item $nextDisabled'>
					<a class='page-link rounded-3' href='$nextLink'>بعدی</a>
				</li>
			</ul>
		</nav>
	</section>
	";
}

?>
