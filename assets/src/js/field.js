import Emitter from 'tiny-emitter';

class Field {
	constructor( element ) {
		this.root    = element;
		this.emitter = new Emitter();
	}

	hide() {
		this.root.classList.add( 'wpbr-u-hidden' );
	}

	show() {
		this.root.classList.remove( 'wpbr-u-hidden' );
	}
}

export default Field;
