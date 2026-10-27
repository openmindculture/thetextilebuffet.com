<?php

add_filter( 'tribe_events_event_schedule_details', function ( $schedule, $event_id = null ) {
	$event_id = $event_id ? $event_id : get_the_ID();
	$custom   = $event_id ? esc_html( get_post_meta( $event_id, 'schedule_text', true ) ) : '';

	if ( is_singular( 'tribe_events' ) && tribe_get_venue( $event_id ) ) {
		$custom .= '<br>';
		$custom .= esc_html( tribe_get_venue( $event_id ) );
		if ( tribe_get_city( $event_id ) ) {
			$custom .= ', ' . esc_html( tribe_get_city( $event_id ) );
		}
		$event_start = Tribe__Events__Timezones::event_start_timestamp( $event_id );
		if ( tribe_get_event_website_url( $event_id )  && $event_start > time() ) {
			$custom .= '<a class="buttonlike" href="' . esc_url( tribe_get_event_website_url( $event_id ) ) . '" target="_blank" rel="noopener">get your ticket)</a>';
		}
	}

	return $custom ? $custom : $schedule;
}, 10, 2 );

add_filter( 'tribe_the_notices', function ( $html, $notices ) {
	if ( is_singular( 'tribe_events' ) ) {
		return '';
	}
	return $html;
}, 10, 2 );

add_action( 'tribe_template_after_include:events/v2/list/event/description', function ( $file, $name, $template ) {
	$event = $template->get( 'event' );

	if ( empty( $event->permalink ) ) {
		return;
	}

	echo '<p class="tribe-events-read-more">';

	printf(
		'<a class="tribe-common-c-btn-border-small" href="%s">%s</a>',
		esc_url( $event->permalink ),
		esc_html__( 'Read more', 'ttb' )
	);

	$website_url = tribe_get_event_website_url( $event );
	$event_start = Tribe__Events__Timezones::event_start_timestamp( $event->ID );
	if ( !empty( $website_url ) && $event_start > time()  ) {
		printf(
			' <a class="tribe-common-c-btn-border-small" href="%s" target="_blank" rel="noopener noreferrer">%s</a>',
			esc_url( $website_url ),
			esc_html__( 'get your ticket', 'ttb' )
		);
	}

	echo '</p>';
}, 10, 3 );