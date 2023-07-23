<?php

// Function to add meta box for event data
function event_meta_box() {
    add_meta_box(
        'custom-event-meta',
        'Event Meta Data',
        'event_meta_box_callback',
        'event', // Change this to the slug of your custom post type
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'event_meta_box' );

// Callback function to display the meta box
function event_meta_box_callback( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'event_meta_nonce' );

    $start_date = get_post_meta( $post->ID, 'event_start_date', true );
    $end_date = get_post_meta( $post->ID, 'event_end_date', true );

    ?>
    <p>
        <label for="event_start_date">Event Start Date:</label>
        <input type="datetime-local" id="event_start_date" name="event_start_date" value="<?php echo esc_attr( $start_date ); ?>">
    </p>
    <p>
        <label for="event_end_date">Event End Date:</label>
        <input type="datetime-local" id="event_end_date" name="event_end_date" value="<?php echo esc_attr( $end_date ); ?>">
    </p>
    <?php
}

// Save meta data when saving/updating the event
function event_save_meta_data( $post_id ) {
    if ( ! isset( $_POST['event_meta_nonce'] ) || ! wp_verify_nonce( $_POST['event_meta_nonce'], basename( __FILE__ ) ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( isset( $_POST['event_start_date'] ) ) {
        $start_date = sanitize_text_field( $_POST['event_start_date'] );
        update_post_meta( $post_id, 'event_start_date', $start_date );
    }

    if ( isset( $_POST['event_end_date'] ) ) {
        $end_date = sanitize_text_field( $_POST['event_end_date'] );
        update_post_meta( $post_id, 'event_end_date', $end_date );
    }

}
add_action( 'save_post_event', 'event_save_meta_data' );

