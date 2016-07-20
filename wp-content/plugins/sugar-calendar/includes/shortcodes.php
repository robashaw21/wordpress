<?php

function sc_events_calendar_shortcode($atts, $content = null) {

	extract( shortcode_atts( array(
			'size' => 'large',
			'category' => null
		), $atts )
	);

	return '<div id="sc_calendar_wrap">' . sc_get_events_calendar($size, $category) . '</div>';
}
add_shortcode('sc_events_calendar', 'sc_events_calendar_shortcode');