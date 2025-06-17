<?php
/*
Plugin Name: Events
Description: A plugin to register custom events.
Version: 1.0
Author: Yavor Zhekov
*/

// Include the file with the page creation function
require_once plugin_dir_path(__FILE__) . 'includes/past-events.php';

// Activation hook to create the page
register_activation_hook(__FILE__, 'create_past_events_page');

function use_custom_past_events_template($template) {
    if (is_page('past-events')) {
        return plugin_dir_path(__FILE__) . 'templates/past-events-page.php';
    }
    return $template;
}

add_filter('page_template', 'use_custom_past_events_template');


function flush_rewrite_rules_on_activation() {
    flush_rewrite_rules();
}
add_action('init', 'flush_rewrite_rules_on_activation');
