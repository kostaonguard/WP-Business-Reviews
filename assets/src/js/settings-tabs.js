import queryString from 'query-string';

class SettingsTabs {
	constructor( element ) {
		this.root = element;

		// Define CSS class that denotes active element.
		this.activeClass = 'is-active';

		// Define CSS classes used to select groups of elements.
		this.tabSelector     = '.js-wpbr-tab';
		this.panelSelector   = '.js-wpbr-panel';
		this.subtabSelector  = '.js-wpbr-subtab';
		this.sectionSelector = '.js-wpbr-section';

		// Define ID prefixes used to select individual elements.
		this.tabIdPrefix    = 'wpbr-tab-';
		this.subtabIdPrefix = 'wpbr-subtab-';
		this.panelPrefix    = 'wpbr-panel-';
		this.sectionPrefix  = 'wpbr-section-';

		// Define URL query parameters.
		this.tabQueryParam    = 'wpbr_tab';
		this.subtabQueryParam = 'wpbr_subtab';
	}

	init() {

		// Group collections of elements that make up tabbed UI.
		this.tabs     = this.root.querySelectorAll( '.js-wpbr-tab' );
		this.panels   = this.root.querySelectorAll( '.js-wpbr-panel' );
		this.subtabs  = this.root.querySelectorAll( '.js-wpbr-subtab' );
		this.sections = this.root.querySelectorAll( '.js-wpbr-section' );

		// Define default active elements.
		this.activeTab     = this.tabs[0];
		this.activePanel   = this.panels[0];
		this.activeSubtab  = this.subtabs[0];
		this.activeSection = this.sections[0];

		// Parse the query string into key-value pairs.
		this.queryStringObject = queryString.parse( location.search );

		// Register event handlers required to navigate settings tabs.
		this.registerTabEventHandlers();
		this.registerSubtabEventHandlers();
		this.registerWindowEventHandlers();

		// Check query string for tab parameter.
		if ( this.tabQueryParam in this.queryStringObject ) {

			// Get tab ID from query string.
			const tabId      = this.queryStringObject[ this.tabQueryParam ];
			const tab        = document.getElementById( this.tabIdPrefix + tabId );

			// Set active tab and panel.
			this.activeTab   = tab;
			this.activePanel = document.getElementById( this.panelPrefix + tabId );

			// Check query string for subtab parameter.
			if ( this.subtabQueryParam in this.queryStringObject ) {
				const subtabId     = this.queryStringObject[ this.subtabQueryParam ];
				const subtab       = document.getElementById( this.subtabIdPrefix + subtabId );

				this.activeSubtab  = subtab;
				this.activeSection = document.getElementById( this.sectionPrefix + subtabId );
			} else {

				// There are no subtabs, so default to first section in active panel.
				this.activeSection = this.activePanel.querySelector( this.sectionSelector );
			}

			// Add active class to new elements.
			this.addClass( this.activeClass, ...[ this.activeTab, this.activePanel, this.activeSubtab, this.activeSection ]);
		} else {
			this.activateTab();
		}
	}

	activateTab( tab = this.tabs[0]) {
		const tabId = this.removePrefix( tab.id, this.tabIdPrefix );

		// Update active tab elements.
		this.activeTab     = tab;
		this.activePanel   = document.getElementById( this.panelPrefix + tabId );
		this.activeSubtab  = this.activePanel.querySelector( this.subtabSelector );
		this.activeSection = this.activePanel.querySelector( this.sectionSelector );

		// Add active class to new elements.
		this.addClass( this.activeClass, ...[ this.activeTab, this.activePanel, this.activeSubtab, this.activeSection ]);

		// Set tab in query string.
		this.queryStringObject[ this.tabQueryParam ] = tabId;
		delete this.queryStringObject[ this.subtabQueryParam ];
	}

	activateSubtab( subtab = this.subtabs[0]) {
		const subtabId = this.removePrefix( subtab.id, this.subtabIdPrefix );

		// Update active subtab elements.
		this.activeSubtab  = subtab;
		this.activeSection = document.getElementById( this.sectionPrefix + subtabId );

		// Add class to new elements.
		this.addClass( this.activeClass, ...[ this.activeSubtab, this.activeSection ]);

		// Set subtab in query string.
		this.queryStringObject[ this.subtabQueryParam ] = subtabId;
	}

	deactivateTab() {
		this.removeClass( this.activeClass, ...[ this.activeTab, this.activePanel, this.activeSubtab, this.activeSection ]);
	}

	deactivateSubtab() {
		this.removeClass( this.activeClass, ...[ this.activeSubtab, this.activeSection ]);
	}

	addClass( className, ...elements ) {
		elements
			.filter( element => ( null !== element ) ) // Skip empty elements.
			.map( element => element.classList.add( this.activeClass ) );
	}

	removeClass( className, ...elements ) {
		elements
			.filter( element => ( null !== element ) ) // Skip empty elements.
			.map( element => element.classList.remove( this.activeClass ) );
	}

	removePrefix( string, prefix ) {
		return string.slice( prefix.length );
	}

	updateQueryString() {
		history.pushState( null, null, `?${queryString.stringify( this.queryStringObject )}` );
	}

	registerTabEventHandlers() {
		this.tabs.forEach( ( tab ) => {
			tab.addEventListener( 'click', ( event ) => {
				event.preventDefault();

				// Only activate tab if it's different from the current tab.
				if ( this.activeTab !== event.currentTarget ) {
					this.deactivateTab();
					this.activateTab( event.currentTarget );
					this.updateQueryString();
				}
			});
		}, this );
	}

	registerSubtabEventHandlers() {
		this.subtabs.forEach( ( subtab ) => {
			subtab.addEventListener( 'click', ( event ) => {
				event.preventDefault();

				// Only activate subtab if it's different from the current subtab.
				if ( this.activeSubtab !== event.currentTarget ) {
					this.deactivateSubtab();
					this.activateSubtab( event.currentTarget );
					this.updateQueryString();
				}
			});
		}, this );
	}

	registerWindowEventHandlers() {
		window.addEventListener( 'popstate', ( event ) => {
			this.queryStringObject = queryString.parse( location.search );
			this.deactivateTab();
			this.init();
		}, this );
	}
}

export default SettingsTabs;
