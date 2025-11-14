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
