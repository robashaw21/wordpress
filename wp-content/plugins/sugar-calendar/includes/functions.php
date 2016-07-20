<?php

/**
 * Build Calendar for Event post type
 * Author : Syamil MJ
 *
 * Credits : http://davidwalsh.name/php-calendar
 *
 */

function sc_draw_calendar( $month, $year, $size = 'large', $category = null ) {

	//start draw table
	$calendar = '<table cellpadding="0" cellspacing="0" class="calendar">';

	$day_names_large = array(
		0 => __( 'Sunday', 'pippin_sc' ),
		1 => __( 'Monday', 'pippin_sc' ),
		2 => __( 'Tuesday', 'pippin_sc' ),
		3 => __( 'Wednesday', 'pippin_sc' ),
		4 => __( 'Thursday', 'pippin_sc' ),
		5 => __( 'Friday', 'pippin_sc' ),
		6 => __( 'Saturday', 'pippin_sc' )
	);

	$day_names_small = array(
		0 => __( 'Sun', 'pippin_sc' ),
		1 => __( 'Mon', 'pippin_sc' ),
		2 => __( 'Tue', 'pippin_sc' ),
		3 => __( 'Wed', 'pippin_sc' ),
		4 => __( 'Thr', 'pippin_sc' ),
		5 => __( 'Fri', 'pippin_sc' ),
		6 => __( 'Sat', 'pippin_sc' )
	);

	$week_start_day = get_option( 'start_of_week' );

	$day_names = $size == 'small' ? $day_names_small : $day_names_large;

	// adjust day names for sites with Monday set as the start day
	if ( $week_start_day == 1 ) {
		$end_day = $day_names[0];
		$start_day = $day_names[1];
		array_shift( $day_names );
		$day_names[] = $end_day;
	}

	if ( $size == 'small' ) {
		foreach ( $day_names as $key => $day ) {
			$day_names[ $key ] = substr( $day, 0, 1 );
		}
	}

	$calendar.= '<tr class="calendar-row">';
	for ( $i = 0; $i <= 6; $i++ ) {
		$calendar .= '<th class="calendar-day-head">' . $day_names[$i] .'</th>';
	}
	$calendar .= '</tr>';

	//days and weeks vars now
	$running_day = date( 'w', mktime( 0, 0, 0, $month, 1, $year ) );
	if ( $week_start_day == 1 )
		$running_day = ( $running_day > 0 ) ? $running_day - 1 : 6;
	$days_in_month = date( 't', mktime( 0, 0, 0, $month, 1, $year ) );
	$days_in_this_week = 1;
	$day_counter = 0;
	$dates_array = array();

	//get today's date
	$time = current_time( 'timestamp' );
	$today_day = date( 'j', $time );
	$today_month = date( 'm', $time );
	$today_year = date( 'Y', $time );

	//row for week one */
	$calendar.= '<tr class="calendar-row">';

	//print "blank" days until the first of the current week
	for ( $x = 0; $x < $running_day; $x++ ):

		$calendar.= '<td class="calendar-day-np" valign="top"></td>';
		$days_in_this_week++;

	endfor;

	//keep going with days
	for ( $list_day = 1; $list_day <= $days_in_month; $list_day++ ) :

		$today = ( $today_day == $list_day && $today_month == $month && $today_year == $year ) ? 'today' : '';

		$cal_day = '<td class="calendar-day '. $today .'" valign="top"><div class="sc_day_div">';

		// add in the day numbering
		$cal_day .= '<div class="day-number day-' . $list_day . '">'.$list_day.'</div>';

		$args = array(
			'numberposts' 	=> -1,
			'post_type' 	=> 'sc_event',
			'post_status' 	=> 'publish',
			'meta_key' 		=> 'sc_event_date_time',
			'orderby' 		=> 'meta_value_num',
			'order' 		=> 'asc',
			'meta_value' 	=> mktime( 0, 0, 0, $month, $list_day, $year ),
			'meta_compare' 	=> '>='
		);

		if ( !is_null( $category ) ) {
			$args['sc_event_category'] = $category;
		}

		$events = get_posts( apply_filters( 'sc_calendar_query_args', $args ) );

		$cal_event = '';

		$shown_events = array();

		foreach ( $events as $event ) :

			$id = $event->ID;

			$shown_events[] = $id;

			//timestamp for start date
			$timestamp = get_post_meta( $id, 'sc_event_date_time', true );

			//define start date
			$evt_day 	= date( 'j', $timestamp );
			$evt_month 	= date( 'n', $timestamp );
			$evt_year 	= date( 'Y', $timestamp );

			//max days in the event's month
			$last_day 	= date( 't', mktime( 0, 0, 0, $evt_month, 1, $evt_year ) );

			//we check if any events exists on current iteration
			//if yes, return the link to event
			if (
				$evt_day == $list_day &&
				$evt_month == $month &&
				$evt_year == $year
			) {

				if ( $size == 'small' ) {
					$link = '<a href="'. get_permalink( $id ) .'" title="' . esc_html( get_the_title( $id ) ) . '">&bull;</a>';
				} else {
					$link = '<a href="'. get_permalink( $id ) .'">'. esc_html( get_the_title( $id ) )  .'</a><br/>';
				}

				$cal_event .= apply_filters( 'sc_event_calendar_link', $link, $id, $size );

			}

		endforeach;

		$recurring_timestamp = mktime( 0, 0, 0, $month, $list_day, $year );

		$cal_event .= sc_show_recurring_events( $recurring_timestamp, $size, $category );

		$calendar .= $cal_day;

		$calendar .= $cal_event ? $cal_event : '';

		$calendar .= '</div></td>';

		if ( $running_day == 6 ):

			$calendar.= '</tr>';

		if ( ( $day_counter+1 ) != $days_in_month ):
			$calendar.= '<tr class="calendar-row">';
		endif;

		$running_day = -1;
		$days_in_this_week = 0;

		endif;

		$days_in_this_week++; $running_day++; $day_counter++;

	endfor;

	//finish the rest of the days in the week
	if ( $days_in_this_week < 8 ):
		for ( $x = 1; $x <= ( 8 - $days_in_this_week ); $x++ ):
		$calendar.= '<td class="calendar-day-np" valign="top"><div class="sc_day_div"></div></td>';
	endfor;
	endif;

	wp_reset_postdata();

	//final row
	$calendar.= '</tr>';

	//end the table
	$calendar.= '</table>';

	//all done, return the completed table
	return $calendar;
}


/**
 * Month Num To Name
 *
 * Takes a month number and returns the
 * three letter name of it.
 *
 * @access      public
 * @since       1.0
 * @return      string
 */

function sc_month_num_to_name( $n ) {
	$timestamp = mktime( 0, 0, 0, $n, 1, 2005 );
	return date_i18n( 'F', $timestamp );
}

/**
 * Determines whether the current page has a calendar on it
 *
 * @access      public
 * @since       1.0
 * @return      string
 */

function sc_is_calendar_page() {
	global $post;


	if ( !is_object( $post ) )
		return false;

	if ( strpos( $post->post_content, '[sc_events_calendar' ) !== false )
		return true;
	return false;
}


/**
 * Retrieves the calendar date for an event
 *
 * @access      public
 * @since       1.0
 * @param 		int $event_id  int The ID number of the event
 * @param 		bool $formatted bool Whether to return a time stamp or the nicely formatted date
 * @return      string
 */
function sc_get_event_date( $event_id, $formatted = true ) {
	$date = get_post_meta( $event_id, 'sc_event_date_time', true );
	if ( $formatted )
		$date = date_i18n( get_option( 'date_format' ), $date );

	return $date;
}


/**
 * Retrieves the time for an event
 *
 * @access      public
 * @since       1.0
 * @param unknown $event_id int The ID number of the event
 * @return      array
 */
function sc_get_event_time( $event_id ) {
	$start_time = sc_get_event_start_time( $event_id );
	$end_time = sc_get_event_end_time( $event_id );

	return apply_filters( 'sc_event_time', array( 'start' => $start_time, 'end' => $end_time ) );
}


/**
 * Retrieves the start time for an event
 *
 * @access      public
 * @since       1.0
 * @param unknown $event_id int The ID number of the event
 * @return      string
 */

function sc_get_event_start_time( $event_id ) {
	$start  = get_post_meta( $event_id, 'sc_event_date', true );

	$day  = date( 'd', $start );
	$month  = date( 'm', $start );
	$year  = date( 'Y', $start );

	$hour  = absint( get_post_meta( $event_id, 'sc_event_time_hour', true ) );
	$minute = absint( get_post_meta( $event_id, 'sc_event_time_minute', true ) );
	$am_pm  = get_post_meta( $event_id, 'sc_event_time_am_pm', true );

	$hour  = $hour ? $hour : null;
	$minute = $minute ? $minute : null;
	$am_pm  = $am_pm ? $am_pm : null;

	if ( $am_pm == 'pm' && $hour < 12 )
		$hour += 12;
	elseif ( $am_pm == 'am' && $hour >= 12 )
		$hour -= 12;

	$time = date_i18n( get_option( 'time_format' ), mktime( $hour, $minute, 0, $month, $day, $year ) );

	return apply_filters( 'sc_event_start_time', $time, $hour, $minute, $am_pm );
}


/**
 * Retrieves the end time for an event
 *
 * @access      public
 * @since       1.0
 * @param unknown $event_id int The ID number of the event
 * @return      string
 */

function sc_get_event_end_time( $event_id ) {
	$start  = get_post_meta( $event_id, 'sc_event_date', true );

	$day  = date( 'd', $start );
	$month  = date( 'm', $start );
	$year  = date( 'Y', $start );

	$hour  = get_post_meta( $event_id, 'sc_event_end_time_hour', true );
	$minute = get_post_meta( $event_id, 'sc_event_end_time_minute', true );
	$am_pm  = get_post_meta( $event_id, 'sc_event_end_time_am_pm', true );

	$hour  = $hour ? $hour : null;
	$minute = $minute ? $minute : null;
	$am_pm  = $am_pm ? $am_pm : null;

	if ( $am_pm == 'pm' && $hour < 12 )
		$hour += 12;
	elseif ( $am_pm == 'am' && $hour >= 12 )
		$hour -= 12;

	$time = date_i18n( get_option( 'time_format' ), mktime( $hour, $minute, 0, $month, $day, $year ) );

	return apply_filters( 'sc_event_end_time', $time, $hour, $minute );
}


/**
 * Checks if an event is recurring
 *
 * @access      public
 * @since       1.1
 * @param  		int $event_id int The ID number of the event
 * @return      array
 */
function sc_is_recurring( $event_id ) {
	$recurring = get_post_meta( $event_id, 'sc_event_recurring', true );
	$recurring = ( $recurring && $recurring != 'none' ) ? true : false;
	return $recurring;
}


/**
 * Retrieves the recurring period for an event
 *
 * @access      public
 * @since       1.2
 * @param  		int $event_id int The ID number of the event
 * @return      string
 */
function sc_get_recurring_period( $event_id ) {
	$period = get_post_meta( $event_id, 'sc_event_recurring', true );
	return apply_filters( 'sc_recurring_period', $period, $event_id );
}


/**
 * Retrieves the recurring stop date for an event
 *
 * @access      public
 * @since       1.2
 * @param  		int $event_id int The ID number of the event
 * @return      mixed
 */
function sc_get_recurring_stop_date( $event_id ) {

	$recur_until = get_post_meta( $event_id, 'sc_recur_until', true );

	if( ! sc_is_recurring( $event_id ) )
		$recur_until = false;

	if( strlen( trim( $recur_until ) ) == 0 )
		$recur_until = false;

	return apply_filters( 'sc_recurring_stop_date', $recur_until, $event_id );
}


/**
 * Retrieves all recurring events
 *
 * @access      public
 * @since       1.1
 * @return      array
 */

function sc_get_recurring_events( $time, $type, $category = null ) {

	switch ( $type ) {

	case 'weekly' :
		$key = 'sc_event_day';
		$date = date( 'D', $time );
		break;
	case 'monthly' :
		$key = 'sc_event_day_of_month';
		$date = date( 'd', $time );
		break;
	case 'yearly' :
		$key = ''; // just default values hre
		$date = ''; // these are reset below
		break;
	}

	$args = array(
		'post_type' => 'sc_event',
		'posts_per_page' => -1,
		'post_status' => 'publish',
		'fields'	=> 'ids',
		'meta_query' => array(
			'relation' => 'AND',
			array(
				'key' => $key,
				'value' => $date
			),
			array(
				'key' => 'sc_event_recurring',
				'value' => $type
			),
			array(
				'key' 		=> 'sc_event_recurring',
				'value' 	=> 'none',
				'compare' 	=> '!='
			),
			array(
				'key' => 'sc_event_date_time',
				'value' => $time,
				'compare' => '<='
			)
		),
	);

	if ( $type == 'yearly' ) {
		// for yearly we have to completely reset the meta query
		$args['meta_query'] = array(
			'relation' => 'AND',
			array(
				'key' => 'sc_event_day_of_month',
				'value' => date( 'd', $time )
			),
			array(
				'key' => 'sc_event_month',
				'value' => date( 'm', $time )
			),
			array(
				'key' => 'sc_event_date_time',
				'value' => $time,
				'compare' => '<='
			),
			array(
				'key' => 'sc_event_recurring',
				'value' => $type
			)
		);
	}

	if ( !is_null( $category ) )
		$args['sc_event_category'] = $category;

	return get_posts( apply_filters( 'sc_recurring_events_query', $args ) );
}


/**
 * Shows all recurring events
 *
 * @access      public
 * @since       1.1
 * @return      array
 */

function sc_show_recurring_events( $timestamp, $size, $category = null ) {

	$yearly 	= sc_get_recurring_events( $timestamp, 'yearly', $category );
	$monthly 	= sc_get_recurring_events( $timestamp, 'monthly', $category );
	$weekly 	= sc_get_recurring_events( $timestamp, 'weekly', $category );
	$events 	= '';
	$recurring 	= array_merge( $yearly, $monthly, $weekly );
	if ( ! empty( $recurring ) ) {
		foreach ( $recurring as $event ) {

			$stop_day = sc_get_recurring_stop_date( $event );

			if( $stop_day !== false && $stop_day > $timestamp ) {

				if ( $size == 'small' ) {
					$events .= '<a href="'. get_permalink( $event ) .'" title="' . get_the_title( $event ) . '">&bull;</a>';
				} else {
					$events .= '<a href="'. get_permalink( $event ) .'">'. get_the_title( $event ) .'</a><br/>';
				}
			}
		}
	}
	return $events;
}


/**
 * Shows the date of recurring events
 *
 * @access      public
 * @since       1.1.1
 * @return      array
 */

function sc_show_single_recurring_date( $event_id ) {

	$recurring_schedule = get_post_meta( $event_id, 'sc_event_recurring', true );
	$recur_until 		= sc_get_recurring_stop_date( $event_id );
	$event_date_time 	= get_post_meta( $event_id, 'sc_event_date_time', true );
	$date_format		= get_option( 'date_format' );

	echo __( 'Date:', 'pippin_sc' ) . '&nbsp;';

	if( $recur_until ) :

		switch ( $recurring_schedule ) {

			case 'weekly':

				echo sprintf( __( 'Every %s until %s', 'pippin_sc' ), date_i18n( 'l', $event_date_time ), date_i18n( $date_format, $recur_until ) );

				break;

			case 'monthly':

				echo sprintf( __( 'Every month on the %s until %s', 'pippin_sc' ), date_i18n( 'jS', $event_date_time ), date_i18n( $date_format, $recur_until ) );

				break;

			case 'yearly':

				echo sprintf( __( 'Every year on the %s of %s until %s', 'pippin_sc' ), date_i18n( 'jS', $event_date_time ), date_i18n( 'F', $event_date_time ), date_i18n( $date_format, $recur_until ) );

				break;

		}

	else :

		switch ( $recurring_schedule ) {

			case 'weekly':

				echo sprintf( __( 'Every %s', 'pippin_sc' ), date_i18n( 'l', $event_date_time ) );

				break;

			case 'monthly':

				echo sprintf( __( 'Every month on the %s', 'pippin_sc' ), date_i18n( 'jS', $event_date_time ) );

				break;

			case 'yearly':

				echo sprintf( __( 'Every year on the %s of %s', 'pippin_sc' ), date_i18n( 'jS', $event_date_time ), date_i18n( 'F', $event_date_time ) );

				break;

		}

	endif;
}
