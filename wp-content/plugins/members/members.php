<?php
/*
Plugin Name: Members
Description: A plugin to register custom members.
Version: 1.0
Author: Yavor Zhekov
*/

function member_post_type() {
    register_post_type('member', array(
        'show_in_rest' => true,
        'supports' => array('title', 'editor', 'excerpt'),
        'rewrite' => array('slug' => 'members'),
        'public' => true,
        'has_archive' => true,
        'labels' => array(
            'name' => 'Members',
            'add_new_item' => 'Add New Member',
            'edit_item' => 'Edit Member',
            'all_items' => 'All Members',
            'singular_name' => 'Members'
        ),
        'menu_icon' => 'dashicons-awards'
    ));
}
add_action('init', 'member_post_type');

function load_member_custom_template($template) {
    if (is_singular('member')) {
        // Path to your custom template inside the plugin
        $custom_template = plugin_dir_path(__FILE__) . 'templates/single-member.php';

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
