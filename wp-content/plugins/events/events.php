<?php
/*
Plugin Name: Events
Description: A plugin to register custom events.
Version: 1.0
Author: Yavor Zhekov
*/

function custom_post_types() {
    register_post_type('event', array(
        'show_in_rest' => true,
        'supports' => array('title', 'editor', 'excerpt'),
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


function load_event_custom_template($template) {
    if (is_singular('event')) {
        // Path to your custom template inside the plugin
        $custom_template = plugin_dir_path(__FILE__) . 'templates/single-event.php';

        // Check if the custom template exists
        if (file_exists($custom_template)) {
            return $custom_template;
        }
    }

    if (is_post_type_archive('event')) {
        $custom_template = plugin_dir_path(__FILE__) . 'templates/archive-event.php';
        if (file_exists($custom_template)) {
            return $custom_template;
        }
    }

    // Return the default template if not the 'event' post type
    return $template;
}
add_filter('template_include', 'load_event_custom_template');

function flush_rewrite_rules_on_activation() {
    flush_rewrite_rules();
}
add_action('init', 'flush_rewrite_rules_on_activation');