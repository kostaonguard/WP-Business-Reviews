<?php
if ( ! empty( $this->field_args['name'] ) ) {
	$this->render_partial( WPBR_PLUGIN_DIR . 'views/field/partials/label.php' );
}

foreach ( $this->field_args['subfields'] as $subfield ) {
	$subfield->render();
}

if ( ! empty( $this->field_args['description'] ) ) {
	$this->render_partial( WPBR_PLUGIN_DIR . 'views/field/partials/description.php' );
}
