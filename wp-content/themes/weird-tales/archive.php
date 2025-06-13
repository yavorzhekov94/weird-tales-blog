<?php 
    get_header();
    page_banner( array(
        'title' => get_the_archive_title(),
        'subtitle' => get_the_archive_description()
      )
    );
     ?>
    
    <div class="container container--narrow page-section">
        <?php
            while(have_posts()) {

                the_post(); ?>
                <div class="post-item">
                    <h2 class="headline headline--medium headline--post-title">
                        <a href="<?php the_permalink();?>"><?php the_title(); ?></a>
                    </h2>
                   
                    <div class="metabox">
                        <p> Posted by <?php the_author_posts_link(); ?>
                            on <a href="<?php echo get_day_link(get_the_time('Y'), get_the_time('m'), get_the_time('d')); ?>">
                                <?php echo get_the_date('d/m/Y'); ?>
                            </a> at <?php the_time('g:i a'); ?>
                            in <?php echo get_the_category_list(', '); ?>
                        </p>
                    </div>
                    <div class="generic-contect">
                        <?php the_excerpt(); ?>
                        <p><a class ="btn btn--blue" href="<?php the_permalink();?>">Continue reading &raquo; </a></p>
                    </div>

                </div>
            <?php }
            echo paginate_links();
        ?>
    </div>
    <?php get_footer();
?>