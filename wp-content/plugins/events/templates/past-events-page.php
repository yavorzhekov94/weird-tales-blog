<?php 
    get_header(); ?>
    <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg')?>)"></div>
        <div class="page-banner__content container container--narrow">
            <h1 class="page-banner__title"> Past  events</h1>
            <div class="page-banner__intro">
            <p> Your event is my event. Keep this on!</p>
            </div>
        </div>
    </div>
    <div class="container container--narrow page-section">
        <?php
         $args = [
            'posts_per_page' => 2,
            'paged' => get_query_var('paged', 1),
            'post_type' => 'event',
            'meta_key' => 'event_date',
            'orderby' => 'meta_value',
            'meta_query' => array(
              'key' => 'event_date',
              'compare' => '<',
              'value' => date('Ymd'),
              'type' => 'numeric'
            ),
            'order' => 'ASC'
        ];

        $query = new WP_Query( $args
        );
        while($query->have_posts()) {

                $query->the_post(); ?>
                <div class="event-summary">
                <a class="event-summary__date t-center" href="<?php the_permalink(); ?>">
                  <span class="event-summary__month"><?php 
                  $event_date = new DateTime(get_field('event_date'));
                  echo $event_date->format('M');
                  ?></span>
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
            echo paginate_links(
                array(
                    'total' => $query->max_num_pages
                )
            );
        ?>
    </div>
    <?php get_footer();
?>