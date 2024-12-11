<?php
/*
Plugin Name: Members
Description: A plugin to register custom members.
Version: 1.0
Author: Yavor Zhekov
*/
function member_post_types() {
    register_post_type('member', array(
        'show_in_rest' => true,
        'supports' => array('title', 'editor', 'excerpt'),
        'public' => true,
        'show_in_rest' => true,
        'labels' => array(
            'name' => 'Members',
            'add_new_item' => 'Add New Member',
            'edit_item' => 'Edit Member',
            'all_items' => 'All Members',
            'singular_name' => 'Members'
        ),
        'menu_icon' => 'dashicons-awards'
    ));

    register_post_type('album', array(
        'show_in_rest' => true,
        'supports' => array('title', 'editor', 'excerpt', 'thumbnail'),
        'rewrite' => array('slug' => 'albums'),
        'public' => true,
        'has_archive' => true,
        'labels' => array(
            'name' => 'Albums',
            'add_new_item' => 'Add New Album',
            'edit_item' => 'Edit Album',
            'all_items' => 'All Albums',
            'singular_name' => 'Albums'
        ),
        'menu_icon' => 'dashicons-welcome-learn-more'
    ));

    register_post_type('hall', array(
        'show_in_rest' => true,
        'supports' => array('title', 'editor', 'excerpt', 'thumbnail'),
        'rewrite' => array('slug' => 'halls'),
        'public' => true,
        'has_archive' => true,
        'labels' => array(
            'name' => 'Concert Halls',
            'add_new_item' => 'Add New Concert Hall',
            'edit_item' => 'Edit Concert Hall',
            'all_items' => 'All Concert Halls',
            'singular_name' => 'Halls'
        ),
        'menu_icon' => 'dashicons-location-alt'
    ));
}
add_action('init', 'member_post_types');


function load_member_custom_template($template) {
    if (is_singular('member')) {
        // Path to your custom template inside the plugin
        $custom_template = plugin_dir_path(__FILE__) . 'templates/single-member.php';

        // Check if the custom template exists
        if (file_exists($custom_template)) {
            return $custom_template;
        }
    }

    if (is_singular('album')) {
        // Path to your custom template inside the plugin
        $custom_template = plugin_dir_path(__FILE__) . 'templates/single-album.php';

        // Check if the custom template exists
        if (file_exists($custom_template)) {
            return $custom_template;
        }
    }

    if (is_post_type_archive('member')) {
        $custom_template = plugin_dir_path(__FILE__) . 'templates/archive-member.php';
        if (file_exists($custom_template)) {
            return $custom_template;
        }
    }

    // Return the default template if not the 'event' post type
    return $template;
}
add_filter('template_include', 'load_member_custom_template');
