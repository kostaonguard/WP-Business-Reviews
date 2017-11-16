<input
	id="wpbr-control-<?php echo esc_attr( $this->id ); ?>"
	class="wpbr-field__control"
	type="range"
	name="<?php echo esc_attr( $this->id ); ?>"
	value="<?php echo esc_attr( $this->value ); ?>"
	<?php
	// Output list attribute if datalist is defined.
	if ( ! empty( $this->datalist ) ) {
		echo 'list="wpbr-datalist-' . esc_attr( $this->id ) . '"';
	}

	// Output any additional control attributes.
	foreach ( $this->control_atts as $name => $value ) {
		echo ' ' . esc_attr( $name ) . '="' . esc_attr( $value ) . '"';
	}
	?>
	>

<?php if ( ! empty( $this->datalist ) ) : ?>
	<datalist id="wpbr-datalist-<?php echo esc_attr( $this->id ); ?>">
		<?php
		foreach ( $this->datalist as $value ) {
			echo '<option value="' . esc_attr( $value ) . '">';
		}
		?>
	</datalist>
<?php endif; ?>
