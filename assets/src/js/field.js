class Field {
	constructor( name ) {
		this.control = document.getElementById( `wpbr-control-${name}` );
	}

	get value() {
		return this.control.value;
	}
}

export default Field;
