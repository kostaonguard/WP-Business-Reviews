class AdminSettings {
	constructor() {
		this.tabsList = document.querySelectorAll( '.js-wpbr-tabs' );
		this.subtabsList = document.querySelectorAll( '.js-wpbr-subtabs' );
		this.tabs = document.querySelectorAll( '.js-wpbr-tab' );
		this.subtabs = document.querySelectorAll( '.js-wpbr-subtab' );
		this.panels = document.querySelectorAll( '.js-wpbr-panel' );
		this.sections = document.querySelectorAll( '.js-wpbr-section' );
		this.hash = location.hash;

		// Set default active elements.
		this.activeTab = this.tabs[0];
		this.activeSubtab = this.subtabs[0];
		this.activePanel = this.panels[0];
		this.activeSection = this.sections[0];

		// Register event handlers required to navigate settings tabs.
		this.registerEventHandlers();
	}

	initializeTabs() {

		// Activate first tab by default.
		this.activateTab( this.activeTab );
	}

	activateTab( tab ) {
		const activeTabClass = 'wpbr-tabs__link--active';
		const activePanelClass = 'wpbr-panel--active';
		const tabId = tab.dataset.tabId;
		const panel = document.getElementById( `wpbr-panel-${tabId}` );
		const firstSubtab = panel.querySelector( '.js-wpbr-subtab' );

		// Remove active classes from last active tab and panel.
		this.activeTab.classList.remove( activeTabClass );
		this.activePanel.classList.remove( activePanelClass );

		// Add active classes to new tab and panel.
		tab.classList.add( activeTabClass );
		panel.classList.add( activePanelClass );

		// Update active tab and panel for future reference.
		this.activeTab = tab;
		this.activePanel = panel;

		// Activate the first subtab of the active panel if one exists.
		if ( null !== firstSubtab ) {
			this.activateSubtab( firstSubtab );
		}
	}

	activateSubtab( subtab ) {

		// TODO: Activate the correct subtab.
		// Get active subtab ID.
		const subtabId = subtab.dataset.subtabId;

		// Get section that corresponds with active subtab ID.
		const section = document.getElementById( `wpbr-section-${subtabId}` );

		// Activate subtab and section.
		subtab.classList.add( 'wpbr-subtabs__link--active' );
		section.classList.add( 'wpbr-panel__section--active' );

		// Store active subtab and section.
		this.activeSubtab = subtab;
		this.activeSection = section;
	}

	updateHash() {

	}

	registerEventHandlers() {
		console.log( this.tabs.length );
		for ( let i = 0; i < this.tabs.length; i++ ) {
			console.log( 'listening on tab' );
			this.tabs[i].addEventListener( 'click', () => this.activateTab( event.currentTarget ) );
		}
	}
}

export default AdminSettings;
