<?php get_header();?>
<?php
while (have_posts()) {
    the_post();
    page_banner();
    ?>

    <div class="container container--narrow page-section">
        <div class="metabox metabox--position-up metabox--with-home-link">
            <p>
                <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('campus'); ?>">
                    <i class="fa fa-home" aria-hidden="true">
                    </i> All Campuses
                </a>
                <span class="metabox__main">
                        Posted by <?php the_author_posts_link(); ?>
                </span>
            </p>
        </div>
        <div class="generic-content">
            <?php the_content(); ?>

            <div class="acf-map">
                    <?php
                        $map_location = get_field('map_location');
                        $lat = $map_location['lat'];
                        $lng = $map_location['lng'];
                        $address = $map_location['address'];
                    ?>
                    <div class="marker" data-lat="<?php echo $lat; ?>" data-lng="<?php echo $lng; ?>">
                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <?php echo $address; ?>
                    </div>

            </div>
        </div>
        <?php
        $relatedPrograms = [
            'posts_per_page' => -1,
            'post_type' => 'program',
            'order' => 'ASC',
            'orderby' => 'title',
            'meta_query' => array(
                array(
                    'key' => 'related_campus',
                    'compare' => 'LIKE',
                    'value' => '"'. get_the_id(). '"',
                )
            ),
        ];


        $relatedPrograms = new WP_Query( $relatedPrograms );
        var_dump(get_the_id());
        var_dump($relatedPrograms->have_posts());

        if ($relatedPrograms->have_posts()) {
            echo '<hr class="section-break">';
            echo '<h2 class="headline headline--medium"> Programs available in this campus </h2>';
            echo '<hr class="section-break">';

            echo '<ul class="min-list link-list">';
            while ($relatedPrograms->have_posts()) {
                $relatedPrograms->the_post(); ?>

                <li>
                    <a href="<?php the_permalink();?>">
                        <span>
                           <?php the_title(); ?>
                       </span>
                    </a>
                </li>

            <?php }
            echo '</ul>';
        }
        ?>
    </div>

<?php }
?>
<?php get_footer();?>