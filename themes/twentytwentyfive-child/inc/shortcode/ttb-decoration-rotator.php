<?php
function decoration_rotator( $ids ) {
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

add_shortcode( 'ttb_decoration_rotator', function ( $atts ) {
	$atts = shortcode_atts( array( 'ids' => '' ), $atts );
	$ids  = array_filter( array_map( 'absint', explode( ',', $atts['ids'] ) ) );

	return decoration_rotator( $ids );
} );