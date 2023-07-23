<?php
/**
 * Plugin Name: Special Events
 * Description: Simple CRUD API for managing special events.
 * Version: 1.0
 * Author: Digvijay
 * Plugin URI:
 * Author URI: 
 * text-domain: events
 */

 defined('ABSPATH') or die('Unauthorized access');

 define('EVENTS_PLUGIN_PATH', plugin_dir_path(__FILE__));
 define('EVENTS_PLUGIN_URI', plugin_dir_url(__FILE__));


 /* ======================================================
                  Get Event Post
========================================================*/

function get_event_post($event_id) {

    $event = get_post( $event_id );

    if ( ! $event ) {
        return new WP_Error( 'invalid_event_id', 'Invalid event ID.', array( 'status' => 404 ) );
    }

    // Get custom meta values for the event
    $start_date = get_post_meta( $event_id, 'event_start_date', true );
    $end_date   = get_post_meta( $event_id, 'event_end_date', true );

    // Get custom taxonomy 'event_category' data for the event
    $categories = wp_get_post_terms( $event_id, 'event_category', array( 'fields' => 'names' ) );

    // Add custom meta and taxonomy data to the $event object
    $event->event_start_date = $start_date;
    $event->event_end_date   = $end_date;
    $event->event_category   = $categories;

    return $event;
}

/* ======================================================
                  Add Function Files
========================================================*/

require EVENTS_PLUGIN_PATH . '/include/event-post.php';
require EVENTS_PLUGIN_PATH . '/include/custom-meta.php';
require EVENTS_PLUGIN_PATH . '/include/event-api.php';









