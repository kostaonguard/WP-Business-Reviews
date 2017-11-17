<ul class="wpbr-gallery">
	<?php for ( $features = 1; $features <= 6; $features ++ ) : ?>
		<li class="wpbr-gallery__item wpbr-gallery__item--3">
			<div class="wpbr-card">
				<div class="wpbr-card__image"></div>
				<div class="wpbr-card__content">
					<h2>Feature #<?php echo $features ?></h2>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cum dolorum eius libero
						quisquam!</p>
				</div>
			</div>
		</li>
	<?php endfor; ?>
</ul>
