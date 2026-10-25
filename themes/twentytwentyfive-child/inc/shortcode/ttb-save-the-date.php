<?php
function save_the_date() {
	$output = '';
	if (function_exists('tribe_get_events')) {
		$nearest_event_query = tribe_get_events( [
			'posts_per_page' => 1,       // Limit to exactly one event
			'start_date'     => 'now',   // Only look for events starting from right now
			'order'          => 'ASC',   // ASC ensures the closest date comes first
		] );

		// Check if an event exists and loop through it
		if ( ! empty( $nearest_event_query ) ) {
			foreach ( $nearest_event_query as $post ) {
				setup_postdata( $post );
				$output .= '<a href="' . esc_url( get_permalink() ) . '">' . get_the_title() . '</a>';
				$output .=  '<p>' . tribe_get_start_date( $post ) . '</p>';
			}
			// Always reset post data:
			wp_reset_postdata(); // Always reset post data
			// Always reset post data
			// Always reset post data
		}
	}
	return $output;
}

add_shortcode( 'ttb_save_the_date', function ( $atts ) {
	return save_the_date();
} );