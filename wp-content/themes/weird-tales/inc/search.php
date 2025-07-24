<?php
add_action('rest_api_init', function () {
    register_rest_route('wp/v2', '/search', [
        'methods'  => WP_REST_Server::READABLE,
        'callback' => 'custom_search_endpoint',
        'args'     => [
            'search' => [
                'required' => false,
                'validate_callback' => function ($param) {
                    return is_string($param);
                },
            ],
        ],
    ]);
});

function custom_search_endpoint($request) {
    $search_query = sanitize_text_field($request->get_param('search'));

    $results = [
        'generalInfo' => [],
        'campuses' => [],
        'programs' => [],
        'events' => [],
        'professors' => [],
    ];

    $query = new WP_Query([
        's' => $search_query,
        'post_type' => ['post', 'page', 'event', 'program', 'professor', 'campus'],
        'post_status' => 'publish',
        'posts_per_page' => 10,
    ]);

    while ($query->have_posts()) {
        $query->the_post();
        $post_type = get_post_type();
        $post_data = [
            'id' => get_the_ID(),
            'title' => get_the_title(),
            'url' => get_permalink(),
            'type' => $post_type,
            'authorName' => get_the_author_meta('display_name'),
        ];

        switch ($post_type) {
            case 'post':
            case 'page':
                $results['generalInfo'][] = $post_data;
                break;

            case 'program':
                $related_campuses = get_field('related_campus');
                if (!empty($related_campuses)) {
                    foreach ($related_campuses as $campus) {
                        $results['campuses'][] = array(
                            'title' => get_the_title($campus),
                            'url' => get_permalink($campus)
                        );
                    }
                }
                $results['programs'][] = $post_data;
                break;

            case 'professor':
                $post_data['image'] = get_the_post_thumbnail_url(null, 'albumLandScape');
                $results['professors'][] = $post_data;
                break;

            case 'campus':
                $results['campuses'][] = $post_data;
                break;

            case 'event':
                $event_date = get_field('event_date');
                $date = $event_date ? new DateTime($event_date) : null;
                $description = has_excerpt() ? wp_trim_words(get_the_excerpt(), 18) : wp_trim_words(get_the_content(), 18);

                $post_data['day'] = $date ? $date->format('d') : '';
                $post_data['month'] = $date ? $date->format('M') : '';
                $post_data['description'] = $description;
                $results['events'][] = $post_data;
                break;
        }
    }
    wp_reset_postdata();

    // Optional: Fetch events related to campuses (if needed)
    if (!empty($results['campuses'])) {
        $campus_ids = wp_list_pluck($results['campuses'], 'id');

        $meta_query = array_merge(
            ['relation' => 'OR'],
            array_map(function ($id) {
                return [
                    'key' => 'related_programs',
                    'compare' => 'LIKE',
                    'value' => '"' . $id . '"',
                ];
            }, $campus_ids)
        );

        $related_events = new WP_Query([
            'post_type' => 'event',
            'meta_query' => $meta_query
        ]);

        while ($related_events->have_posts()) {
            $related_events->the_post();
            $event_date = get_field('event_date');
            $date = $event_date ? new DateTime($event_date) : null;
            $description = has_excerpt() ? wp_trim_words(get_the_excerpt(), 18) : wp_trim_words(get_the_content(), 18);

            $results['events'][] = [
                'title' => get_the_title(),
                'url' => get_permalink(),
                'day' => $date ? $date->format('d') : '',
                'month' => $date ? $date->format('M') : '',
                'description' => $description,
            ];
        }
        wp_reset_postdata();

        // Remove duplicates by url
        $results['events'] = array_values(array_unique($results['events'], SORT_REGULAR));
    }

    return rest_ensure_response($results);
}
