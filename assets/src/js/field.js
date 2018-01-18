class Field {
	constructor( element ) {
		this.root    = element;
		this.fieldId = this.root ? this.root.dataset.wpbrFieldId : null;
	}
}

export default Field;
