function generateStars( rating, platform ) {
	let stars;

	if ( ! rating ) {
		return 'Not yet rated.';
	}

	switch ( roundRating( rating ) ) {
	case 5:
		stars = '★★★★★';
		break;
	case 4:
		stars = '★★★★';
		break;
	case 3:
		stars = '★★★';
		break;
	case 2:
		stars = '★★';
		break;
	case 1:
		stars = '★';
		break;
	}

	return `
		<span class="wpbr-stars wpbr-stars--${platform}">${stars}</span>
	`;
}

function roundRating( rating ) {
	return Math.round(
		Number( rating )
	);
}

export { generateStars };
