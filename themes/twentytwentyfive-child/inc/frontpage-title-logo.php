<?php

add_filter( 'render_block_core/post-title', function ( $html ) {
	if ( ! is_front_page() ) {
		return $html;
	}

	$title = get_the_title();
	$src   = get_stylesheet_directory_uri()
	         . '/img/logos/textile-buffet-logo-1244x201-lemon-transparent-shadow.png';

	return sprintf(
		'<h1 class="wp-block-post-title"><img src="%s" alt="%s" width="1768" height="440"></h1>',
		esc_url( $src ),
		esc_attr( $title )
	);
} );