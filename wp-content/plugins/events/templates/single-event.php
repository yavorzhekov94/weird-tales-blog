<?php get_header();?>
<?php
while (have_posts()) {
    the_post();
    page_banner();
     ?>
    <div class="container container--narrow page-section">
        <div class="metabox metabox--position-up metabox--with-home-link">
            <p>
                <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('event'); ?>">
                    <i class="fa fa-home" aria-hidden="true">
                    </i> Event Home
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
            $related_members = get_field('related_members');
            if ($related_members) {
                echo '<hr class="section-break">';
                echo '<h2 class="headline headline--medium"> Related members </h2>';
                echo '<ul class="link list min-list">';
                foreach ($related_members as $member) { ?>
                <li><a href="<?php echo get_the_permalink($member)?>"><?php echo get_the_title($member)?></a></li>
                    
                <?php }
                echo '</ul>';
           
            } ?>
            
            
    </div>

<?php }

?>
<?php get_footer();?>