<?php 
    get_header();
    page_banner(
      array(
          'title' => 'All past Events',
          'subtitle' => "LOve my love events"
        )
      );
     ?>
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

                $query->the_post();
                event_summary();
        }
            echo paginate_links(
                array(
                    'total' => $query->max_num_pages
                )
            );
        ?>
    </div>
    <?php get_footer();
?>