<?php if ( 'connected' === $this->value ) : ?>
	<strong class="wpbr-platform-status wpbr-platform-status--success">
		<?php echo esc_html__( 'Connected', 'wp-business-reviews' ); ?>
	</strong>
<?php else : ?>
	<strong class="wpbr-platform-status wpbr-platform-status--error">
		<?php echo esc_html__( 'Not Connected', 'wp-business-reviews' ); ?>
	</strong>
<?php endif; ?>

<p id="wpbr-field-description-<?php echo esc_attr( $this->id ); ?>" class="wpbr-field__description">
	<?php
		$now          = time();
		// TODO: Get last checked time from field value.
		$last_checked = 1511568000;
		$difference   = human_time_diff( $last_checked, $now );
		printf( esc_html__( 'Last checked %s ago.', 'wp-business-reviews' ), $difference );
	?>
</p>
