<?php get_header();?>
<?php
while (have_posts()) {
    the_post();
    page_banner();
    ?>

    <div class="container container--narrow page-section">
        <div class="metabox metabox--position-up metabox--with-home-link">
            <p>
                <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('program'); ?>">
                    <i class="fa fa-home" aria-hidden="true">
                    </i> All Programs
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
        $relatedProfessorsArgs = [
            'posts_per_page' => -1,
            'post_type' => 'professor',
            'order' => 'ASC',
            'orderby' => 'title',
            'meta_query' => array(
                array(
                    'key' => 'related_programs',
                    'compare' => 'LIKE',
                    'value' => '"'. get_the_ID(). '"',
                )
            ),
        ];

        $relatedProfessors = new WP_Query( $relatedProfessorsArgs );

        if ($relatedProfessors->have_posts()) {
            echo '<hr class="section-break">';
            echo '<h2 class="headline headline--medium">' . get_the_title(). ' Professors </h2>';
            echo '<hr class="section-break">';

            echo '<ul class="professor-cards">';
            while ($relatedProfessors->have_posts()) {
                $relatedProfessors->the_post(); ?>
                    
               <li class="professor-card__list-item">
                   <a class="professor-card" href="<?php the_permalink();?>">
                       <img src="<?php the_post_thumbnail_url('professorLandScape');?>" alt="" class="professor-card__image">
                       <span class="professor-card__name">
                           <?php the_title(); ?>
                       </span>
                   </a>
               </li>

           <?php }
           echo '</ul>';
        }

        ?>
        <?php
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
                    'key' => 'related_programs',
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
                $home_page_events->the_post();
                get_template_part('template-parts/content', 'event');
            }
        }

        ?>
    </div>

<?php }
?>
<?php get_footer();?>