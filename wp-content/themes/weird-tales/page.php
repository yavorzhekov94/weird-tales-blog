<?php
get_header();
while (have_posts()) {
    the_post(); ?>
    <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg')?>)"></div>
        <div class="page-banner__content container container--narrow">
            <h1 class="page-banner__title"> <?php the_title(); ?></h1>
            <div class="page-banner__intro">
            <p>Learn how the school of your dreams got started.</p>
            </div>
        </div>
    </div>

    <div class="container container--narrow page-section">
    <?php
        $parent_page_id = wp_get_post_parent_id(get_the_ID()); 
        if ($parent_page_id) { ?>
            <div class="metabox metabox--position-up metabox--with-home-link">
                <p>
                <a class="metabox__blog-home-link" href="<?php echo get_permalink($parent_page_id); ?>"><i class="fa fa-home" aria-hidden="true">

                </i> Back to <?php echo get_the_title($parent_page_id); ?></a> 
                <span class="metabox__main"><?php the_title(); ?></span>
                </p>
            </div>
        <?php }
     ?>

      <div class="page-links">
        <h2 class="page-links__title"><a href="<?php echo get_permalink($parent_page_id); ?>">
            <?php echo get_the_title($parent_page_id); ?></a></h2>
        <ul class="min-list">
            <?php
                if ($parent_page_id) {
                    $child_id = $parent_page_id;
                } else {
                    $child_id = get_the_ID();
                }
                
                wp_list_pages(
                    array(
                        'title_li' => NUll,
                        'child_of' => $child_id,
                        'sort_order' => 'menu_column'
                    )
                );
            ?>
        </ul>
      </div>

      <div class="row group generic-content">
        <?php the_content(); ?>
      </div>
    </div>
<?php }
get_footer();
?>