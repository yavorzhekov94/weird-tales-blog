<?php 
    get_header();
    page_banner(
      array(
          'title' => 'All Events',
          'subtitle' => "LOve my love events"
        )
      ); ?>
    <div class="container container--narrow page-section">
      <?php
       
       while(have_posts()) {

        the_post();
        event_summary();
       }
            echo paginate_links()
        ?>
      <hr class="section-break">
      <p> Looking for a recap of past events? <a href="<?php echo site_url('/past-events') ?>">Check out our past events archive.</a></p>
    </div>
    <?php get_footer();
?>