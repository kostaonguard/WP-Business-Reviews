<?php
if ( ! empty( $this->field_args['name'] ) ) {
	$this->render_partial( WPBR_PLUGIN_DIR . 'views/field/partials/name.php' );
}
?>

<div id="wpbr-field-control-wrap-<?php echo esc_attr( $this->field_id ); ?>" class="wpbr-field__control-wrap">
	<div class="wpbr-field__flex">
		<?php if ( isset( $this->value['status'] ) && 'connected' === $this->value['status'] ) : ?>
			<strong class="wpbr-platform-status wpbr-platform-status--success">
				<?php echo esc_html__( 'Connected', 'wp-business-reviews' ); ?>
			</strong>
		<?php else : ?>
			<strong class="wpbr-platform-status wpbr-platform-status--error">
				<?php echo esc_html__( 'Not Connected', 'wp-business-reviews' ); ?>
			</strong>
		<?php endif; ?>
	</div>

	<?php if ( isset( $this->value['last_checked'] ) ) : ?>
		<p id="wpbr-field-description-<?php echo esc_attr( $this->field_id ); ?>" class="wpbr-field__description">
			<?php
			$now          = time();
			$last_checked = $this->value['last_checked'];
			$difference   = human_time_diff( $last_checked, $now );
			printf( esc_html__( 'Last checked %s ago.', 'wp-business-reviews' ), $difference );
			?>
		</p>
	<?php endif; ?>
</div>
