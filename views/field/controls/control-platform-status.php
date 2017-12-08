<div class="wpbr-field__flex">
	<?php if ( 'connected' === $this->value['status'] ) : ?>
		<strong class="wpbr-platform-status wpbr-platform-status--success">
			<?php echo esc_html__( 'Connected', 'wp-business-reviews' ); ?>
		</strong>
	<?php else : ?>
		<strong class="wpbr-platform-status wpbr-platform-status--error">
			<?php echo esc_html__( 'Not Connected', 'wp-business-reviews' ); ?>
		</strong>
	<?php endif; ?>

	<button class="button wpbr-field__inline-button js-wpbr-refresh-button"><?php esc_html_e( 'Refresh', 'wp-business-reviews' ); ?></button>
</div>

<?php if ( isset( $this->value['last_checked'] ) ) : ?>
	<p id="wpbr-field-description-<?php echo esc_attr( $this->id ); ?>" class="wpbr-field__description">
		<?php
		$now          = time();
		$last_checked = $this->value['last_checked'];
		$difference   = human_time_diff( $last_checked, $now );
		printf( esc_html__( 'Last checked %s ago.', 'wp-business-reviews' ), $difference );
		?>
	</p>
<?php endif; ?>
