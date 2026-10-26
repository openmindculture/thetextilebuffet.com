<?php
function save_the_date() {
	$output = '';
	if ( function_exists( 'tribe_get_events' ) ) {
		$nearest_event_query = tribe_get_events( [
			'posts_per_page' => 1,       // Limit to exactly one event
			'start_date'     => 'now',   // Only look for events starting from right now
			'order'          => 'ASC',   // ASC ensures the closest date comes first
		] );

		// Check if an event exists and loop through it
		if ( ! empty( $nearest_event_query ) ) {
			foreach ( $nearest_event_query as $post ) {
				setup_postdata( $post );
				$output .= '<a class="buttonlike shadowlesstext boxshadow" href="';
				$url = tribe_get_event_website_url( $post );
				if ( ! empty( $url ) ) {
					$output .= esc_url( $url );
					$output .= '" target="_blank">';
				} else {
					$output .= esc_url( get_permalink( $post ) ) . '">';
				}
				$output .= 'Next event: ';
				$output .= esc_html( tribe_get_start_date( $post, false, 'j F' ) );
				$output .= ', ';
				$output .= esc_html( tribe_get_venue( $post ) );
				$output .= ', ';
				$output .= tribe_get_city( $post );
				$output .= '</a>';
			}
			wp_reset_postdata();
		}
	}

	return $output;
}

add_shortcode( 'ttb_save_the_date', function ( $atts ) {
	return save_the_date();
} );