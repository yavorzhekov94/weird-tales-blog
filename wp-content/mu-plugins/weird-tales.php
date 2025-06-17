<?php
function custom_post_types() {
    register_post_type('event', array(
        'show_in_rest' => true,
        'capability_type' => 'event',
        'map_meta_cap' => true,
        'supports' => array('title', 'editor', 'excerpt', 'custom-fields'),
        'rewrite' => array('slug' => 'events'),
        'public' => true,
        'has_archive' => true,
        'labels' => array(
        'name' => 'Events',
        'add_new_item' => 'Add New Event',
        'edit_item' => 'Edit Event',
        'all_items' => 'All Events',
        'singular_name' => 'Events'
        ),
        'menu_icon' => 'dashicons-calendar'
    ));
}
add_action('init', 'custom_post_types');