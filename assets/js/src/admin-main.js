(
	function ( $ ) {
		var $tabs = $( '.js-wpbr-tab' );
		var $subtabs = $( '.js-wpbr-subtab' );
		var $panels = $( '.js-wpbr-panel' );
		var $sections = $( '.js-wpbr-section' );

		// Initialize first tab by default.
		initializeTab( $tabs.first() );

		$tabs.click( function ( event ) {
			event.preventDefault();

			// Remove active classes from old tab.
			$tabs.removeClass( 'wpbr-tabs__link--active' );
			$panels.removeClass( 'wpbr-panel--active' );
			$subtabs.removeClass( 'wpbr-subtabs__link--active' );
			$sections.removeClass( 'wpbr-panel__section--active' );

			// Initialize new tab.
			initializeTab( $( this ) );
		} );

		$subtabs.click( function ( event ) {
			event.preventDefault();

			// Remove active classes from old subtab.
			$subtabs.removeClass( 'wpbr-subtabs__link--active' );
			$sections.removeClass( 'wpbr-panel__section--active' );

			// Initialize new subtab.
			initializeSubtab( $( this ) );
		} );

		function initializeTab( $tab ) {
			var $panel = $( '#wpbr-panel-' + $tab.data( 'tab-id' ) );
			var $subtab = $panel.find( '.js-wpbr-subtab:first' );
			var $section = $panel.find( '.js-wpbr-section:first' );

			$tab.addClass( 'wpbr-tabs__link--active' );
			$panel.addClass( 'wpbr-panel--active' );
			$subtab.addClass( 'wpbr-subtabs__link--active' );
			$section.addClass( 'wpbr-panel__section--active' );
		}

		function initializeSubtab( $subtab ) {
			var $section = $( '#wpbr-section-' + $subtab.data( 'subtab-id' ) );

			$subtab.addClass( 'wpbr-subtabs__link--active' );
			$section.addClass( 'wpbr-panel__section--active' );
		}
	}
)( jQuery );
