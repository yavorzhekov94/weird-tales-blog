<?php get_header();?>
<?php
while (have_posts()) {

    the_post();
    page_banner();
    $map_location = get_field('map_location');
     ?>
    
    <div class="container container--narrow page-section">
        <div class="metabox metabox--position-up metabox--with-home-link">
            <p>
                <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('hall'); ?>">
                    <i class="fa fa-home" aria-hidden="true">
                    </i> All Halls
                </a> 
                <span class="metabox__main">
                        Posted by <?php the_author_posts_link(); ?>
                </span>
            </p>
        </div>
        <div class="generic-content">
             <?php the_content(); ?>
        </div>
        <div class="acf-map">
            <div data-lat="<?php echo $map_location['lat']?>" data-lng="<?php echo $map_location['lng']?>"
                class="marker">
                <h3> <?php the_title(); ?></h3>
                <?php echo $map_location['address']; ?>
            </div>     
        </div>
        <?php
            $args_event = [
                'posts_per_page' => -1,
                'post_type' => 'event',
                'orderby' => 'title',
                'meta_key' => 'event_date',
                'order' => 'ASC',
                'meta_query' => array(
                  array(
                    'key' => 'related_halls',
                    'compare' => 'LIKE',
                    'value' => '"'. get_the_ID(). '"',
                  ),
                  array(
                    'key' => 'event_date',
                    'compare' => '>=',
                    'value' => date('Ymd'),
                    'type' => 'numeric'
                  ),
                ),
                'order' => 'ASC'
            ];

            $related_events = new WP_Query( $args_event );

            if ($related_events->have_posts()) {
                echo '<h2 class="headline headline--medium"> See Related events to '. get_the_title().' </h2>';
                echo '<hr class="section-break">';
                while ($related_events->have_posts()) {
                $related_events->the_post();
                event_summary(); ?>
                <?php }
            }
            
            ?>
    </div>

<?php }
?>
<?php get_footer();?>