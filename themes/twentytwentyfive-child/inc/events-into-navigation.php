<?php

add_filter( 'render_block_core/page-list', function ( $content, $parsed_block, $instance ) {
	// Only touch Page Lists inside a Navigation block (see note 1).
	if ( ! isset( $instance->context['showSubmenuIcon'] ) ) {
		return $content;
	}

	$position = 2; // The Events link becomes item number 2.

	$url    = function_exists( 'tribe_get_events_link' ) ? tribe_get_events_link() : home_url( '/events/' );
	$active = is_post_type_archive( 'tribe_events' ) || is_singular( 'tribe_events' );

	$item = sprintf(
		'<li class="wp-block-pages-list__item wp-block-navigation-item open-on-hover-click%1$s"><a class="wp-block-pages-list__item__link wp-block-navigation-item__content" href="%2$s"%3$s>%4$s</a></li>',
		$active ? ' current-menu-item' : '',
		esc_url( $url ),
		$active ? ' aria-current="page"' : '',
		esc_html__( 'Events', 'twentytwentyfive-child' )
	);

	// Walk the markup and find the end of the (position-1)th TOP-LEVEL </li>,
	// ignoring nested child-page lists.
	preg_match_all( '#<li\b|</li>#i', $content, $m, PREG_OFFSET_CAPTURE );
	$depth = 0;
	$top   = 0;
	foreach ( $m[0] as [ $tag, $offset ] ) {
		if ( stripos( $tag, '</li>' ) === 0 ) {
			$depth--;
			if ( 0 === $depth && ++$top === $position - 1 ) {
				$at = $offset + 5;
				return substr_replace( $content, $item, $at, 0 );
			}
		} else {
			$depth++;
		}
	}

	// Fewer pages than the position: append at the end of the list.
	$end = strripos( $content, '</ul>' );
	return false === $end ? $content : substr_replace( $content, $item, $end, 0 );
}, 10, 3 );