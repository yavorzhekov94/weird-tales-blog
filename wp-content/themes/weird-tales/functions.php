<?php
function weird_tales_files() {
    wp_enqueue_script('googleMap', '//maps.googleapis.com/maps/api/js?key=AIzaSyAU412-df0WDUB593e6MkbuB1HVE1y6zgg', NULL, '1.0', true);
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
    add_image_size('pageBanner', 1500, 350, true);
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
add_action('pre_get_posts', 'adjust_queries');

function page_banner($args = NULL) {
    if (!isset($args['title'])) {
        $args['title'] = get_the_title();
    }
    if (!isset($args['subtitle'])) {
        $args['subtitle'] = get_field('page_banner_subtitle');
    }
    if (!isset($args['photo'])) {
        if (get_field('page_banner_image') && !is_archive() && !is_home()) {
            $args['photo'] = get_field('page_banner_image')['sizes']['pageBanner'];

        } else {
            $args['photo'] = get_theme_file_uri('/images/ocean.jpg');
        }
    }
    ?>
     <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image: url(<?php echo $args['photo'];?>)"></div>
        <div class="page-banner__content container container--narrow">
            <h1 class="page-banner__title"> <?php echo $args['title']; ?></h1>
            <div class="page-banner__intro">
            <p><?php echo $args['subtitle'];?></p>
            </div>
        </div>
    </div>
<?php }

function event_summary() { ?>
     <div class="event-summary">
        <a class="event-summary__date t-center" href="<?php the_permalink(); ?>">
            <span class="event-summary__month"><?php 
            $event_date = new DateTime(get_field('event_date'));
            echo $event_date->format('M');?></span>
            <span class="event-summary__day"><?php echo $event_date->format('d');?></span>
        </a>
        <div class="event-summary__content">
            <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
            <p><?php if (has_excerpt()) {
                echo wp_trim_words(get_the_excerpt(), 18);
                } else {
                    echo wp_trim_words(get_the_content(), 18);
                    }
                ?> <a href="<?php the_permalink(); ?>" class="nu gray">Learn more</a></p>
        </div>                             
    </div>

<?php }
function concert_hall_map_key($api) {
 $api['key'] = 'AIzaSyAU412-df0WDUB593e6MkbuB1HVE1y6zgg';
 return $api;
}
add_filter('acf/fields/google_map/api', 'concert_hall_map_key')
?>