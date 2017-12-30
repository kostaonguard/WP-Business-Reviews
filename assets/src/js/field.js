class Field {
	constructor( name ) {
		this.root    = document.getElementById( `wpbr-field-${name}` );
		this.control = document.getElementById( `wpbr-control-${name}` );
	}

	get value() {
		return this.control.value;
	}
}

export default Field;
