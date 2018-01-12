<?php
if ( ! empty( $this->args['name'] ) ) {
	$this->render_partial( WPBR_PLUGIN_DIR . 'views/field/partials/label.php' );
}

foreach ( $this->args['subfields'] as $subfield ) {
	$subfield->render();
}

if ( ! empty( $this->args['description'] ) ) {
	$this->render_partial( WPBR_PLUGIN_DIR . 'views/field/partials/description.php' );
}
