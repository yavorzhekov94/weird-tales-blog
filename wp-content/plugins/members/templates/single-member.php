<?php get_header();?>
<?php
while (have_posts()) {
    the_post();
    page_banner();
     ?>
    
    <div class="container container--narrow page-section">
        <div class="metabox metabox--position-up metabox--with-home-link">
            <p>
                <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('member'); ?>">
                    <i class="fa fa-home" aria-hidden="true">
                    </i> All Members
                </a> 
                <span class="metabox__main">
                        Posted by <?php the_author_posts_link(); ?>
                </span>
            </p>
        </div>
        <div class="generic-content">
             <?php the_content(); ?>
        </div>
        <?php
            $args_album = [
                'posts_per_page' => -1,
                'post_type' => 'album',
                'orderby' => 'title',
                'order' => 'ASC',
                'meta_query' => array(
                  array(
                    'key' => 'related_members',
                    'compare' => 'LIKE',
                    'value' => '"'. get_the_ID(). '"',
                  )
                ),
                'order' => 'ASC'
            ];

            $related_albums = new WP_Query( $args_album );

            if ($related_albums->have_posts()) {
                echo '<h2 class="headline headline--medium"> See Related albums to '. get_the_title().' </h2>';
                echo '<hr class="section-break">';
                echo '<ul>';
                while ($related_albums->have_posts()) {
                $related_albums->the_post(); ?>
                <li class="professor-card_list-item">
                    <a class="professor-card" href="<?php the_permalink();?>">
                        <img class="professor-card_image" src="<?php the_post_thumbnail_url('albumLandScape');?>" alt="">
                        <span class="professor-card_name"><?php the_title();?> </span>
                    </a>
                </li>
                
                <?php }
                echo '</ul>';
            }
            wp_reset_postdata();
            $args = [
                'posts_per_page' => -1,
                'post_type' => 'event',
                'meta_key' => 'event_date',
                'orderby' => 'meta_value',
                'meta_query' => array(
                  array(
                    'key' => 'event_date',
                    'compare' => '>=',
                    'value' => date('Ymd'),
                    'type' => 'numeric'
                  ),
                  array(
                    'key' => 'related_members',
                    'compare' => 'LIKE',
                    'value' => '"'. get_the_ID(). '"',
                  )
                ),
                'order' => 'ASC'
            ];

            $home_page_events = new WP_Query( $args );

            if ($home_page_events->have_posts()) {
                echo '<hr class="section-break">';
                echo '<h2 class="headline headline--medium"> See Related events to '. get_the_title().' </h2>';
                echo '<hr class="section-break">';
            
                while ($home_page_events->have_posts()) {
                $home_page_events->the_post(); ?>
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
            }
            
            ?>
    </div>

<?php }
?>
<?php get_footer();?>