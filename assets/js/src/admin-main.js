(
	function ( $ ) {
		var $tabsList = $( '.js-wpbr-tabs' );
		var $subtabsList = $( '.js-wpbr-subtabs' );
		var $tabs = $( '.js-wpbr-tab' );
		var $subtabs = $( '.js-wpbr-subtab' );
		var $panels = $( '.js-wpbr-panel' );
		var $sections = $( '.js-wpbr-section' );

		/**
		 * @summary Initialize tabs based on location hash.
		 *
		 * If the location hash contains either a panel or section ID, the
		 * relevant panel or section will be displayed by default. If no hash
		 * is set, the first tab is activated by default.
		 *
		 * @since 1.0.0
		 */
		function initializeTabs() {
			var hash = location.hash;
			var tabID = '';
			var subtabID = '';
			var $tab = {};
			var $subtab = {};

			if ( 1 === hash.indexOf( 'wpbr-panel' ) ) {
				tabID = hash.slice( 12 );
				$tab = $( '#wpbr-tab-' + tabID );

				activateTab( $tab );
			} else if ( 1 === hash.indexOf( 'wpbr-section' ) ) {
				subtabID = hash.slice( 14 );
				$subtab = $( '#wpbr-subtab-' + subtabID );
				tabID = $subtab.closest( '.js-wpbr-panel' ).data( 'tab-id' );
				$tab = $( '#wpbr-tab-' + tabID );

				activateTab( $tab );
				activateSubtab( $subtab );
			} else {
				// Activate first tab by default.
				activateTab( $tabs.first() );
			}
		}

		/**
		 * @summary Sets active tab component when selected.
		 *
		 * @since 1.0.0
		 */
		function activateTab( $tab ) {
			var tabID = $tab.data( 'tab-id' );
			var $panel = $( '#wpbr-panel-' + tabID );
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
			var subtabID = $subtab.data( 'subtab-id' );
			var $section = $( '#wpbr-section-' + subtabID );

			// Clear all active classes.
			$subtabs.removeClass( 'wpbr-subtabs__link--active' );
			$sections.removeClass( 'wpbr-panel__section--active' );

			// Add new active classes.
			$subtab.addClass( 'wpbr-subtabs__link--active' );
			$section.addClass( 'wpbr-panel__section--active' );
		}

		/**
		 * @summary Update hash based on tab and type of tab.
		 *
		 * @param {jQuery} $tab jQuery tab object.
		 * @param {string} type Type of tab, 'tab' or 'subtab'.
		 * @since 1.0.0
		 */
		function updateHash( $tab, type ) {
			var slug = $tab.data( type + '-id' );
			var container = 'tab' === type ? 'panel' : 'section';

			if ( history.pushState ) {
				history.pushState( null, null, '#wpbr-' + container + '-' + slug );
			}
			else {
				location.hash = '#wpbr-panel-' + slug;
			}
		}

		/**
		 * @summary Attaches click events to tabs and subtabs.
		 *
		 * @since 1.0.0
		 */
		function attachClickEvents() {
			$tabsList.on( 'click', '.js-wpbr-tab', function ( event ) {
				event.preventDefault();
				$this = $( this );
				activateTab( $this );
				updateHash( $this, 'tab' );
			} );

			$subtabsList.on( 'click', '.js-wpbr-subtab', function ( event ) {
				event.preventDefault();
				$this = $( this );
				activateSubtab( $( this ) );
				updateHash( $this, 'subtab' );
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
			// Add modifier classes on mousedown.
			$tabsList.on( 'mousedown', '.js-wpbr-tab', function ( event ) {
				$( this ).addClass( 'wpbr-tabs__link--mousedown' );
			} );

			$subtabsList.on( 'mousedown', '.js-wpbr-subtab', function ( event ) {
				$( this ).addClass( 'wpbr-subtabs__link--mousedown' );
			} );

			// Remove modifier classes on focusout.
			$tabsList.on( 'focusout', '.js-wpbr-tab', function ( event ) {
				$( this ).removeClass( 'wpbr-tabs__link--mousedown' );
			} );

			$subtabsList.on( 'focusout', '.js-wpbr-subtab', function ( event ) {
				$( this ).removeClass( 'wpbr-subtabs__link--mousedown' );
			} );
		}

		$( window ).on( "hashchange", function( e ) {
			e.preventDefault();
			console.log('changed');
			initializeTabs();
		});

		initializeTabs();
		attachClickEvents();
		attachMousedownEvents();
	}
)( jQuery );
