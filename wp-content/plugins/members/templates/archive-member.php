<?php 
    get_header();
    page_banner(
        array(
            'title' => 'All Member',
            'subtitle' => "LOve my special members"
          )
        ); 
    ?>
    
    <div class="container container--narrow page-section">
        <ul class="lin-list min-list">
            <?php
        while(have_posts()) {
            the_post(); ?>
                <li><a href="<?php the_permalink();?>"> <?php the_title();?></a></li>
            <?php }
                echo paginate_links()
            ?>
        </ul>
    </div>
    <?php get_footer();
?>