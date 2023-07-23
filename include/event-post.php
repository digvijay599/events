<?php
/**
 *  Custom Post type Event
 * @link https://developer.wordpress.org/reference/functions/register_post_type/
 * @package events
 */


// Register custom post type "event"
function custom_event_post_type() {
    $labels = array(
        'name'                  => 'Events',
        'singular_name'         => 'Event',
        'menu_name'             => 'Events',
        'all_items'             => 'All Events',
        'add_new'               => 'Add New',
        'add_new_item'          => 'Add New Event',
        'edit_item'             => 'Edit Event',
        'new_item'              => 'New Event',
        'view_item'             => 'View Event',
        'search_items'          => 'Search Events',
        'not_found'             => 'No events found',
        'not_found_in_trash'    => 'No events found in trash',
        'parent_item_colon'     => 'Parent Event:',
        'menu_name'             => 'Events',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'events' ), // Change this slug to your preferred URL structure
        'capability_type'    => 'post',
        'taxonomies' => array( 'event_category' ),
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor', 'thumbnail', 'custom-fields' ), // Customize supports as needed
    );

    register_post_type( 'event', $args );
}
add_action( 'init', 'custom_event_post_type' );


// Register custom taxonomy "event_category"
function custom_event_taxonomy() {
    $labels = array(
        'name'                       => 'Event Categories',
        'singular_name'              => 'Event Category',
        'menu_name'                  => 'Event Categories',
        'all_items'                  => 'All Event Categories',
        'parent_item'                => 'Parent Event Category',
        'parent_item_colon'          => 'Parent Event Category:',
        'new_item_name'              => 'New Event Category Name',
        'add_new_item'               => 'Add New Event Category',
        'edit_item'                  => 'Edit Event Category',
        'update_item'                => 'Update Event Category',
        'view_item'                  => 'View Event Category',
        'separate_items_with_commas' => 'Separate categories with commas',
        'add_or_remove_items'        => 'Add or remove categories',
        'choose_from_most_used'      => 'Choose from the most used categories',
        'popular_items'              => 'Popular Event Categories',
        'search_items'               => 'Search Event Categories',
        'not_found'                  => 'No event categories found',
        'no_terms'                   => 'No categories',
        'items_list'                 => 'Event categories list',
        'items_list_navigation'      => 'Event categories list navigation',
    );

    $args = array(
        'labels'            => $labels,
        'hierarchical'      => true,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'event-category' ), // Change this slug to your preferred URL structure
    );

    register_taxonomy( 'event_category', 'event', $args );
}
add_action( 'init', 'custom_event_taxonomy', 0 );
