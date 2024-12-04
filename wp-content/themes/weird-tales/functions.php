<?php
function weird_tales_files() {
    wp_enqueue_script('weird_tales_main_scripts', get_theme_file_uri('/build/index.js'), array('jquery'), '1.0', true);
    wp_enqueue_style('custom-google-fonts', '///fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('weird_tales_main_styles', get_theme_file_uri('/build/style-index.css'));
    wp_enqueue_style('weird_tales_extra_styles', get_theme_file_uri('/build/index.css'));
}
add_action('wp_enqueue_scripts', 'weird_tales_files');

function weird_tales_features () {
    register_nav_menu(
        'primary_menu', 'Primary Menu'
    );
    register_nav_menu(
        'footer_menu_one', 'Footer Menu One'
    );
    register_nav_menu(
        'footer_menu_second', 'Footer Menu Second'
    );
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_image_size('albumLandScape', 400, 260, true);
    add_image_size('albumPortrait', 480, 650, true);
}
add_action('after_setup_theme', 'weird_tales_features');

function adjust_queries($query) {
    if (!is_admin() && is_post_type_archive('member')) {
        $query->set('orderby', 'title');
        $query->set('order', 'ASC');
        $query->set('posts_per_page', -1);

    }
    if (!is_admin() && is_post_type_archive('event')) {
        $query->set('meta_key', 'event_date');
        $query->set('orderby', 'meta_Value_num');
        $query->set('order', 'ASC');
        $query->set('meta_query', array(
            'key' => 'event_date',
            'compare' => '>=',
            'value' => date('Ymd'),
            'type' => 'numeric'
        ));
    }
    
}
add_action('pre_get_posts', 'adjust_queries')
?>