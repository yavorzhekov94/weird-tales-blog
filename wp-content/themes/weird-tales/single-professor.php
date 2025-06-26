<?php get_header();?>
<?php
while (have_posts()) {
    the_post();
    page_banner();
    ?>

    <div class="container container--narrow page-section">
        <div class="generic-content">
            <div class="row group">
                <div class="one-third">
                    <?php the_post_thumbnail('professorPortrait'); ?>
                </div>
                <div class="two-thirds">
                    <?php the_content(); ?>
                </div>
            </div>

        </div>
        <?php
        $related_programs = get_field('related_programs');

        if ($related_programs) {
            echo '<hr class="section-break">';
            echo '<h2 class="headline headline--medium"> Subjects Taught </h2>';
            echo '<ul class="link list min-list">';
            foreach ($related_programs as $program) { ?>

                <li><a href="<?php echo get_the_permalink($program)?>"><?php echo get_the_title($program)?></a></li>

            <?php }
            echo '</ul>';

        } ?>
        <?php
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