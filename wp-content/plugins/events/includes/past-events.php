<?php
function create_past_events_page() {
    // Check if the page already exists
    $page_title = 'Past Events';
    $page_check = get_page_by_title($page_title);
    $page_template = 'templates/past-events-page.php'; // The custom template file in your theme

    // If the page doesn't exist, create it
    if (!$page_check) {
        $page = array(
            'post_title'     => $page_title,
            'post_content'   => 'This is the page content for past events.',
            'post_status'    => 'publish',
            'post_type'      => 'page',
        );
        
        // Insert the page into the database
        $page_id = wp_insert_post($page);

        // Assign the template
        if (!empty($page_id)) {
            update_post_meta($page_id, '_wp_page_template', $page_template);
        }
    }
}