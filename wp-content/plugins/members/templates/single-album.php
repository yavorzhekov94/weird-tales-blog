<?php get_header();?>
<?php
while (have_posts()) {
    the_post(); ?>
    <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg')?>)"></div>
        <div class="page-banner__content container container--narrow">
            <h1 class="page-banner__title"> <?php the_title(); ?></h1>
            <div class="page-banner__intro">
            <p>Learn how the school of your dreams got startede.</p>
            </div>
        </div>
    </div>
    <div class="container container--narrow page-section">
      
        <div class="generic-content">
             <div class="row-group">
                <div class="one-third">
                     <?php the_post_thumbnail('albumPortrait'); ?>
                </div>
                <div class="two-thirds">
                    <?php the_content(); ?>
                </div>
             </div>
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