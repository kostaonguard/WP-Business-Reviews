class Field {
	constructor( element ) {
		this.root    = element;
		this.fieldId = this.root ? this.root.dataset.wpbrFieldId : null;
	}

	hide() {
		this.root.classList.add( 'wpbr-u-hidden' );
	}

	show() {
		this.root.classList.remove( 'wpbr-u-hidden' );
	}
}

export default Field;
