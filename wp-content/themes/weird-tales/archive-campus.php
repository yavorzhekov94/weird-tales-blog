<?php
get_header();
page_banner(
    array(
        'title' => 'All Campuses',
        'subtitle' => "LOve my special campus"
    )
);
?>

    <div class="container container--narrow page-section">
        <div class="acf-map">
            <?php
            while(have_posts()) {
                the_post();
                $map_location = get_field('map_location');
                $lat = $map_location['lat'];
                $lng = $map_location['lng'];
                $address = $map_location['address'];
                ?>
                <div class="marker" data-lat="<?php echo $lat; ?>" data-lng="<?php echo $lng; ?>">
                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    <?php echo $address; ?>
                </div>
            <?php }
            ?>
        </div>
    </div>
<?php get_footer();
?>