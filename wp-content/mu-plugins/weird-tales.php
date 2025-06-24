<?php
function custom_post_types() {
    register_post_type('event', array(
        'show_in_rest' => true,
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
    register_post_type('program', array(
        'show_in_rest' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor'),
        'rewrite' => array('slug' => 'programs'),
        'public' => true,
        'labels' => array(
            'name' => 'Programs',
            'add_new_item' => 'Add New Program',
            'edit_item' => 'Edit Program',
            'all_items' => 'All Programs',
            'singular_name' => 'Programs'
        ),
        'menu_icon' => 'dashicons-awards'
    ));

    register_post_type('professor', array(
        'show_in_rest' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'public' => true,
        'labels' => array(
            'name' => 'Professors',
            'add_new_item' => 'Add New Professor',
            'edit_item' => 'Edit Professor',
            'all_items' => 'All Professors',
            'singular_name' => 'Professors'
        ),
        'menu_icon' => 'dashicons-welcome-learn-more'
    ));
}
add_action('init', 'custom_post_types');