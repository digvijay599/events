<?php
/**
 * custom api endpoints for event post type
 * @package events
 */

 // Custom API endpoints for events
function special_event_api_routes() {
    register_rest_route( 'special-event-api/v1', '/events/create', array(
        'methods'  => 'POST',
        'callback' => 'special_event_api_create_event',
        'permission_callback' => 'special_event_api_check_permission',
    ) );

    register_rest_route( 'special-event-api/v1', '/events/update/(?P<id>\d+)', array(
        'methods'  => 'PUT',
        'callback' => 'special_event_api_update_event',
        'permission_callback' => 'special_event_api_check_permission',
    ) );

    register_rest_route( 'custom-event-api/v1', '/events/list', array(
        'methods'  => 'GET',
        'callback' => 'special_event_api_list_events',
        'permission_callback' => 'special_event_api_check_permission',
    ) );

    register_rest_route( 'special-event-api/v1', '/events/delete/(?P<id>\d+)', array(
        'methods'  => 'DELETE',
        'callback' => 'special_event_api_delete_event',
        'permission_callback' => 'special_event_api_check_permission',
    ) );

    register_rest_route( 'special-event-api/v1', '/events/show/(?P<id>\d+)', array(
        'methods'  => 'GET',
        'callback' => 'special_event_api_show_event',
        //'permission_callback' => 'special_event_api_check_permission',
    ) );
}
add_action( 'rest_api_init', 'special_event_api_routes' );

// Custom authentication callback for admin users
function special_event_api_check_permission() {
    //return current_user_can( 'manage_options' ); 
    if ( ! current_user_can( 'manage_options' ) ) {
        // If the current user is not an admin, send a JSON error response.
        $response = array(
            'error' => true,
            'message' => 'You do not have permission to access this endpoint.'
        );
        wp_send_json( $response, 403 );
    }
}
function validation($request) {
    // Validate required fields
    $required_fields = array( 'title', 'event_start_date', 'event_end_date');
    foreach ( $required_fields as $field ) {
        if ( ! isset( $request[ $field ] ) ) {
            return new WP_Error( 'invalid_request', 'Missing required field: ' . $field, array( 'status' => 400 ) );
            exit;
        }
    }

}
// Callback function for creating a new event
// {
//     'title':'event-3',
//     'description': 'testing description',
//     'event_start_date':'2023-07-23 16:56:10',
//     'event_end_date':'2023-07-27 16:56:10',
//     'event_category':[1]
// }

function special_event_api_create_event( $request ) {
    validation($request);
    $event_data = array(
        'post_title'     => sanitize_text_field( $request['title'] ),
        'post_content'   => sanitize_textarea_field( $request['description'] ),
        'post_type'      => 'event',
        'post_status'    => 'publish',
    );

    $event_id = wp_insert_post( $event_data );

     // Update custom meta fields
     if ( isset( $request['event_start_date'] ) ) {
        $event_start_date = sanitize_text_field( $request['event_start_date'] );
        update_post_meta( $event_id, 'event_start_date', $event_start_date );
    }

    if ( isset( $request['event_end_date'] ) ) {
        $event_end_date = sanitize_text_field( $request['event_end_date'] );
        update_post_meta( $event_id, 'event_end_date', $event_end_date );
    }

    // Update custom taxonomy 'event_category'
    if ( isset( $request['event_category'] ) ) {
        $categories = $request['event_category'];
        $category_ids = array();

        foreach ( $categories as $category ) {
            $term = term_exists( $category, 'event_category' ); // Check if term exists
            if ( $term ) {
                $category_ids[] = $term['term_id'];
            } else {
                $new_term = wp_insert_term( $category, 'event_category' ); // Create new term if not exists
                if ( ! is_wp_error( $new_term ) ) {
                    $category_ids[] = $new_term['term_id'];
                }
            }
        }

        wp_set_post_terms( $event_id, $category_ids, 'event_category' );
    }

    return get_event_post( $event_id );
}

// Callback function for updating an event
function special_event_api_update_event( $request ) {
    validation($request);
    $event_id = $request['id'];

    if ( ! get_post( $event_id ) ) {
        return new WP_Error( 'invalid_event_id', 'Invalid event ID.', array( 'status' => 404 ) );
    }

    $event_data = array(
        'ID'             => $event_id,
        'post_title'     => sanitize_text_field( $request['title'] ),
        'post_content'   => sanitize_textarea_field( $request['description'] ),
        'post_date'      => date( 'Y-m-d H:i:s', strtotime( $request['start_date'] ) ),
        'post_date_gmt'  => get_gmt_from_date( date( 'Y-m-d H:i:s', strtotime( $request['start_date'] ) ) ),
    );

    $updated = wp_update_post( $event_data );
    
    // Update custom meta fields
    if ( isset( $request['event_start_date'] ) ) {
        $event_start_date = sanitize_text_field( $request['event_start_date'] );
        update_post_meta( $event_id, 'event_start_date', $event_start_date );
    }

    if ( isset( $request['event_end_date'] ) ) {
        $event_end_date = sanitize_text_field( $request['event_end_date'] );
        update_post_meta( $event_id, 'event_end_date', $event_end_date );
    }

    // Update custom taxonomy 'event_category'
    if ( isset( $request['event_category'] ) ) {
        $categories = $request['event_category'];
        $category_ids = array();

        foreach ( $categories as $category ) {
            $term = term_exists( $category, 'event_category' ); // Check if term exists
            if ( $term ) {
                $category_ids[] = $term['term_id'];
            } else {
                $new_term = wp_insert_term( $category, 'event_category' ); // Create new term if not exists
                if ( ! is_wp_error( $new_term ) ) {
                    $category_ids[] = $new_term['term_id'];
                }
            }
        }

        wp_set_post_terms( $event_id, $category_ids, 'event_category' );
    }
    return get_event_post( $event_id );
}


// Callback function for listing all events with custom meta and taxonomy
function special_event_api_list_events( $request ) {
    $args = array(
        'post_type'      => 'event',
        'posts_per_page' => -1,
        'orderby'        => 'post_date',
        'order'          => 'DESC',
    );

    $events = get_posts( $args );

    $formatted_events = array();
    foreach ( $events as $event ) {
        $event_meta = get_post_meta( $event->ID ); // Get all custom meta data for the event

        // Extract specific custom meta fields that you want to include in the API response
        $start_date = isset( $event_meta['event_start_date'][0] ) ? $event_meta['event_start_date'][0] : '';
        $end_date   = isset( $event_meta['event_end_date'][0] ) ? $event_meta['event_end_date'][0] : '';
        $category   = wp_get_post_terms( $event->ID, 'event_category', array( 'fields' => 'names' ) );

        $event_data = array(
            'event_start_date' => $start_date,
            'event_end_date'   => $end_date,
            'event_category'   => $category,
        );

        // Merge $event_data with $event object to include custom meta fields and taxonomy data
        $event = (object) array_merge( (array) $event, $event_data );

        $formatted_events[] = $event;
    }

    return $formatted_events;
}


// Callback function for deleting an event
function special_event_api_delete_event( $request ) {
    $event_id = $request['id'];

    if ( ! get_post( $event_id ) ) {
        return new WP_Error( 'invalid_event_id', 'Invalid event ID.', array( 'status' => 404 ) );
    }

    $result = wp_delete_post( $event_id );
    return array(
        'success' => $result ? true : false,
    );
}

// Callback function for showing a single event
function special_event_api_show_event( $request ) {
    $event_id = $request['id'];
    $event = get_event_post($event_id);
    return $event;
}



