(
	function ( $ ) {
		var $tabsList = $( '.js-wpbr-tabs' );
		var $subtabsList = $( '.js-wpbr-subtabs' );
		var $tabs = $( '.js-wpbr-tab' );
		var $subtabs = $( '.js-wpbr-subtab' );
		var $panels = $( '.js-wpbr-panel' );
		var $sections = $( '.js-wpbr-section' );

		/**
		 * @summary Sets active tab component when selected.
		 *
		 * @since 1.0.0
		 */
		function activateTab( $tab ) {
			var $panel = $( '#wpbr-panel-' + $tab.data( 'tab-id' ) );
			var $subtab = $panel.find( '.js-wpbr-subtab:first' );
			var $section = $panel.find( '.js-wpbr-section:first' );

			// Clear all active classes.
			$tabs.removeClass( 'wpbr-tabs__link--active' );
			$panels.removeClass( 'wpbr-panel--active' );
			$subtabs.removeClass( 'wpbr-subtabs__link--active' );
			$sections.removeClass( 'wpbr-panel__section--active' );

			// Add new active classes.
			$tab.addClass( 'wpbr-tabs__link--active' );
			$panel.addClass( 'wpbr-panel--active' );
			$subtab.addClass( 'wpbr-subtabs__link--active' );
			$section.addClass( 'wpbr-panel__section--active' );
		}

		/**
		 * @summary Sets active subtab component when selected.
		 *
		 * @since 1.0.0
		 */
		function activateSubtab( $subtab ) {
			var $section = $( '#wpbr-section-' + $subtab.data( 'subtab-id' ) );

			// Clear all active classes.
			$subtabs.removeClass( 'wpbr-subtabs__link--active' );
			$sections.removeClass( 'wpbr-panel__section--active' );

			// Add new active classes.
			$subtab.addClass( 'wpbr-subtabs__link--active' );
			$section.addClass( 'wpbr-panel__section--active' );
		}

		/**
		 * @summary Attaches click events to tabs and subtabs.
		 *
		 * @since 1.0.0
		 */
		function attachClickEvents() {
			$tabsList.on( 'click', '.js-wpbr-tab', function ( event ) {
				event.preventDefault();
				activateTab( $( this ) );
			} );

			$subtabsList.on( 'click', '.js-wpbr-subtab', function ( event ) {
				event.preventDefault();
				activateSubtab( $( this ) );
			} );
		}

		/**
		 * @summary Attaches mousedown events to tabs and subtabs.
		 *
		 * Special styling may be applied to tabs on mousedown versus when
		 * selected via keyboard navigation. For example, it may be desirable
		 * to remove tab outlines on mousedown, but those outlines should remain
		 * visible for accessibility when navigating by keyboard. The mousedown
		 * modifier class makes such styling possible.
		 *
		 * @since 1.0.0
		 */
		function attachMousedownEvents() {
			$tabsList.on( 'mousedown', '.js-wpbr-tab', function ( event ) {
				$( this ).addClass( 'wpbr-tabs__link--mousedown' );
			} );

			$tabsList.on( 'focusout', '.js-wpbr-tab', function ( event ) {
				$( this ).removeClass( 'wpbr-tabs__link--mousedown' );
			} );

			$subtabsList.on( 'mousedown', '.js-wpbr-subtab', function ( event ) {
				$( this ).addClass( 'wpbr-subtabs__link--mousedown' );
			} );

			$subtabsList.on( 'focusout', '.js-wpbr-subtab', function ( event ) {
				$( this ).removeClass( 'wpbr-subtabs__link--mousedown' );
			} );
		}

		// Initialize first tab by default.
		activateTab( $tabs.first() );

		// Attach events handlers.
		attachClickEvents();
		attachMousedownEvents();
	}
)( jQuery );
