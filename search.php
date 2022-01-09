<!-- 
    Template Name: Search
-->

<?php get_header(); ?>

    <!-- <?php get_template_part('templates/title') ?> -->

    <p>result:</p>

    <?php while ( have_posts() ) : the_post();
    
    the_title( '<h1 class="entry-title">', '</h1>' ); 
    // get_search_form();  
    the_content();

    endwhile; ?>



<?php get_footer(); ?>