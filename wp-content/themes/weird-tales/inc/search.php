<?php
add_action('rest_api_init', function () {
    
    // Register a custom search route
    register_rest_route('wp/v2', '/search', array(
        'methods'  => WP_REST_Server::READABLE,
        'callback' => 'custom_search_endpoint',
        'args'     => array(
            'search' => array(
                'required' => false,
                'validate_callback' => function ($param, $request, $key) {
                    return is_string($param);
                },
            ),
        ),
    ));
});

function custom_search_endpoint($request) {
    $search_query = sanitize_text_field($request['search']);

    // Get search results
    $posts = new WP_Query(array(
        's'           => $search_query,
        'post_type'   => array('post', 'page', 'event', 'member', 'hall', 'album'), // Add your custom post types here
        'post_status' => 'publish',
        'posts_per_page' => -1,
    ));

    $results = array(
        'generalInfo' => array(),
        'halls' => array(),
        'albums' => array(),
        'events' => array(),
        'members' => array(),
    );

    if ($posts->have_posts()) {
        while ($posts->have_posts()) {
            $posts->the_post();
    
            $post_type = get_post_type();
            $post_data = array(
                'id' => get_the_ID(),
                'title' => get_the_title(),
                'url' => get_permalink(),
                'type' => $post_type,
                'authorName' => get_the_author_meta('display_name'),
            );
    
            switch ($post_type) {
                case 'post':
                case 'page':
                    $results['generalInfo'][] = $post_data;
                    break;
    
                case 'member':
                    $results['members'][] = $post_data;
                    break;
    
                case 'album':
                    $results['albums'][] = $post_data;
                    break;
    
                case 'hall':
                    $results['halls'][] = $post_data;
                    break;
    
                case 'event':
                    $results['events'][] = $post_data;
                    break;
    
                default:
                    // Handle unexpected post types if necessary
                    break;
            }
        }
        wp_reset_postdata();
    }

    return rest_ensure_response($results);
}