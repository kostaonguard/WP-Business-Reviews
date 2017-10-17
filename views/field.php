<?php
/**
 * Displays the field label and tooltip.
 *
 * Available Variables:
 *
 * @var View   $this The View object.
 * @var array  $context {
 *     Associative array with context variables.
 *
 *     @type string $id           Field ID.
 *     @type string $name         Field name also used as label.
 *     @type string $type         Field type to determine Field subclass.
 *     @type string $tooltip      Tooltip to clarify field purpose.
 *     @type string $description  Description to clarify field use.
 *     @type string $default      Default field value.
 *     @type string $value        Field value.
 *     @type array  $control_atts Placeholder value for relevant input types.
 *     @type array  $options      Field options for select/radios/checkboxes.
 *     @type string $view         View used to render the field.
 * }
 */

?>

<div id="wpbr-field-<?php echo esc_attr( $context['id'] ); ?>" class="wpbr-field js-wpbr-field">

	<?php
	// Render the field label.
	$this->render_partial(
		'views/partials/field-label.php',
		$this->narrow_context( $context, array( 'id', 'name', 'tooltip' ) )
	);
	?>

	<select id="wpbr-control-<?php echo esc_attr( $context['id'] ); ?>" class="wpbr-field__control js-wpbr-control" name="<?php echo esc_attr( $context['id'] ); ?>">
		<?php foreach ( $context['options'] as $value => $label ) : ?>
			<?php
			if ( isset( $context['default'] ) && $value === $context['default'] ) {
				$context['is_selected'] = true;
			} else {
				$context['is_selected'] = false;
			}
			?>
			<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $context['is_selected'] ); ?>>
				<?php esc_html_e( $label ); ?>
			</option>
		<?php endforeach; ?>
	</select>

	<?php
	// Render the field description.
	$this->render_partial(
		'views/partials/field-description.php',
		$this->narrow_context( $context, array( 'description' ) )
	);
	?>
</div>
