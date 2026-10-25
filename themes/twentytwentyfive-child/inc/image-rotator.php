<?php
function image_rotator( $ids ) {
	if ( empty( $ids ) ) {
		return '';
	}

	$out = '<div class="decoration">';
	foreach ( $ids as $i => $id ) {
		$out .= wp_get_attachment_image(
			$id,
			'large',
			false,
			array(
				'class'    => $i === 0 ? '' : 'visually-hidden',
				'sizes'    => '(max-width: 800px) 100vw, 800px',
				'loading'  => $i === 0 ? 'eager' : 'lazy',
				'decoding' => 'async',
				'alt'      => '',
			)
		);
	}

	return $out . '</div>';
}

add_action( 'wp_body_open', function() {
	if ( ! is_front_page() && ! is_home() ) {
		return;
	}
	$ids = array_filter( (array) get_option( 'ttb_rotator_images', [] ), 'wp_attachment_is_image' );
	if ( ! $ids ) {
		return;
	}
	echo image_rotator( $ids );
} );

add_action( 'wp_enqueue_scripts', function() {
	wp_enqueue_script(
		'ttb-decoration-rotator',
		get_theme_file_uri( '/scripts/image-rotator.js' ),
		array(),
		wp_get_theme()->get( 'Version' ),
		array(
			'strategy'  => 'defer',
			'in_footer' => true,
		)
	);
} );