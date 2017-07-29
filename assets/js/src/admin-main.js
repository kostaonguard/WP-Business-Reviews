(
	function ( $ ) {
		var tabs = $( '.js-wpbr-tab' );
		var panels = $( '.js-wpbr-panel' );

		$( '.js-wpbr-panel:first-child' ).addClass( 'wpbr-panel--active' );

		tabs.click( function ( event ) {
			event.preventDefault();

			var tabID = $( this ).data( 'tab-id' );

			// Set active tab.
			tabs.removeClass( 'wpbr-tabs__link--active' );
			$( this ).addClass( 'wpbr-tabs__link--active' );

			// Set active panel.
			panels.removeClass( 'wpbr-panel--active' );
			$( '.js-wpbr-panel[data-panel-id="' + tabID + '"]' ).addClass( 'wpbr-panel--active' );
		} );
	}
)( jQuery );
