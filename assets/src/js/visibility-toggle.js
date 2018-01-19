export default function toggleVisibility( element ) {
	if ( element.classList.contains( 'wpbr-u-hidden' ) ) {
		element.classList.remove( 'wpbr-u-hidden' );
	} else {
		element.classList.add( 'wpbr-u-hidden' );
	}
}
