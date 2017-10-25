<?php
use WP_Business_Reviews\Includes\Config;
use WP_Business_Reviews\Includes\Fields\Field_Factory;

$config = new Config( WPBR_PLUGIN_DIR . 'config/reviews-builder.php' );
?>
<div id="wpbr-control-panel" class="wpbr-builder__controls">
	<?php foreach ( $config as $section ) : ?>
		<div id="wpbr-section<?php echo esc_attr( $section['id'] ); ?>" class="wpbr-builder__section">
			<div class="wpbr-builder__section-header js-wpbr-section-header">
				<button class="wpbr-builder__toggle"  aria-expanded="true">
					<span class="screen-reader-text">Toggle section: <?php esc_html_e( $section['name'] ); ?></span>
					<span class="wpbr-builder__toggle-indicator js-wpbr-toggle-indicator" aria-hidden="true"><span class="dashicons dashicons-arrow-down"></span></span>
				</button>
				<h3 class="wpbr-builder__section-heading"><?php esc_html_e( $section['name'] ); ?></h3>
			</div>

			<div class="wpbr-builder__section-body js-wpbr-section-body">
				<?php foreach ( $section['fields'] as $atts ) : ?>
					<?php
					$field = Field_Factory::create( $atts );
					$field->render_view( $field->get_att( 'view' ) );
					?>
				<?php endforeach; ?>
			</div>
		</div>
	<?php endforeach; ?>
</div>
