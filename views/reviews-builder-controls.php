<?php
$field_groups = $this->context;
?>
<div id="wpbr-control-panel" class="wpbr-builder__controls">
	<?php foreach ( $field_groups as $field_group ) : ?>
		<div id="wpbr-section<?php echo esc_attr( $field_group->get_group_id() ); ?>" class="wpbr-builder__section">
			<div class="wpbr-builder__section-header js-wpbr-section-header">
				<button class="wpbr-builder__toggle"  aria-expanded="true">
					<span class="screen-reader-text">Toggle section: <?php esc_html_e( $field_group->get_group_name() ); ?></span>
					<span class="wpbr-builder__toggle-indicator js-wpbr-toggle-indicator" aria-hidden="true"><span class="dashicons dashicons-arrow-down"></span></span>
				</button>
				<h3 class="wpbr-builder__section-heading"><?php esc_html_e( $field_group->get_group_name() ); ?></h3>
			</div>

			<div class="wpbr-builder__section-body js-wpbr-section-body">
				<?php
				$fields = $field_group->get_fields();
				foreach ( $fields as $field ) {
					$field->render_view( 'views/fields/field.php' );
				}
				?>
			</div>
		</div>
	<?php endforeach; ?>
</div>
