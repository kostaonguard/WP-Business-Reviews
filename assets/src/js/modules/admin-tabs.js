class AdminTabs {
	constructor() {
		this.hash = location.hash;

		// Group collections of elements that make up tabbed UI.
		this.tabs = document.querySelectorAll( '.js-wpbr-tab' );
		this.panels = document.querySelectorAll( '.js-wpbr-panel' );
		this.subtabs = document.querySelectorAll( '.js-wpbr-subtab' );
		this.sections = document.querySelectorAll( '.js-wpbr-section' );

		// Set default active elements.
		this.activeTab = this.tabs[0];
		this.activePanel = this.panels[0];
		this.activeSubtab = this.subtabs[0];
		this.activeSection = this.sections[0];

		// Register event handlers required to navigate settings tabs.
		this.registerEventHandlers();
	}

	init() {
		this.activateTab( this.activeTab );
	}

	activateTab( tab ) {
		this.removeClass( 'is-active', ...[ this.activeTab, this.activePanel, this.activeSubtab, this.activeSection ]);
		this.updateActiveTabElements( tab );
		this.addClass( 'is-active', ...[ this.activeTab, this.activePanel, this.activeSubtab, this.activeSection ]);
	}

	activateSubtab( subtab ) {
		this.removeClass( 'is-active', ...[ this.activeSubtab, this.activeSection ]);
		this.updateActiveSubtabElements( subtab );
		this.addClass( 'is-active', ...[ this.activeSubtab, this.activeSection ]);
	}

	updateActiveTabElements( tab ) {
		const tabId = tab.dataset.tabId;
		this.activeTab = tab;
		this.activePanel = document.getElementById( `wpbr-panel-${tabId}` );
		this.activeSubtab = this.activePanel.querySelector( '.js-wpbr-subtab' );
		this.activeSection = this.activePanel.querySelector( '.js-wpbr-section' );
	}

	updateActiveSubtabElements( subtab ) {
		const subtabId = subtab.dataset.subtabId;
		this.activeSubtab = document.getElementById( `wpbr-subtab-${subtabId}` );
		this.activeSection = document.getElementById( `wpbr-section-${subtabId}` );
	}

	removeClass( className, ...elements ) {
		elements
			.filter( element => ( null !== element ) ) // Skip empty elements.
			.map( element => element.classList.remove( 'is-active' ) );
	}

	addClass( className, ...elements ) {
		elements
			.filter( element => ( null !== element ) ) // Skip empty elements.
			.map( element => element.classList.add( 'is-active' ) );
	}

	registerEventHandlers() {

		// Register event handler for tabs.
		this.tabs.forEach( ( tab ) => {
			tab.addEventListener( 'click', ( event ) => {
				event.preventDefault();

				// Only activate tab if it's different from the current tab.
				if ( this.activeTab !== event.currentTarget ) {
					this.activateTab( event.currentTarget );
				}
			});
		}, this );

		// Register event handler for subtabs.
		this.subtabs.forEach( ( subtab ) => {
			subtab.addEventListener( 'click', ( event ) => {
				event.preventDefault();

				// Only activate subtab if it's different from the current subtab.
				if ( this.activeSubtab !== event.currentTarget ) {
					this.activateSubtab( event.currentTarget );
				}
			});
		}, this );
	}
}

export default AdminTabs;
