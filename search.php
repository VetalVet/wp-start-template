<!-- 
    Template Name: Search
-->

<?php get_header(); ?>

    <!-- <?php get_template_part('templates/title') ?> -->

    <p>result:</p>

    <?php while (have_posts()) : the_post();

        the_title('<h1 class="entry-title">', '</h1>');
        // get_search_form();  
        the_content();

    endwhile; ?>

    <?php if (have_posts()) : ?>

        <header class="page-header">
            <h1 class="page-title">
                <?php
                /* translators: %s: search query. */
                printf(esc_html__('Search Results for: %s', 'test'), '<span>' . get_search_query() . '</span>');
                ?>
            </h1>
        </header><!-- .page-header -->

    <?php
        /* Start the Loop */
        while (have_posts()) :
            the_post();

            /**
             * Run the loop for the search to output the results.
             * If you want to overload this in a child theme then include a file
             * called content-search.php and that will be used instead.
             */
            get_template_part('template-parts/content', 'search');

        endwhile;

        the_posts_navigation();
        the_posts_pagination();
    else :

        get_template_part('template-parts/content', 'none');

    endif;
    ?>



<?php get_footer(); ?>