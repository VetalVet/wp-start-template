        <footer>
            <div class="container">
                <div class="footer-top">
                    <?php wp_nav_menu( [
                        'theme_location'  => '',
                        'menu'            => 'Меню в подвале1',
                        'container'       => false,
                        'menu_class'      => '',
                        'echo'            => true,
                        'items_wrap'      => '<ul>%3$s</ul>',
                        'depth'           => 0,
                        'walker'          => '',
                    ] ); ?>
                    <?php wp_nav_menu( [
                        'theme_location'  => '',
                        'menu'            => 'Меню в подвале2',
                        'container'       => false,
                        'menu_class'      => '',
                        'echo'            => true,
                        'items_wrap'      => '<ul>%3$s</ul>',
                        'depth'           => 0,
                        'walker'          => '',
                    ] ); ?>
                    <?php wp_nav_menu( [
                        'theme_location'  => '',
                        'menu'            => 'Меню в подвале3',
                        'container'       => false,
                        'menu_class'      => '',
                        'echo'            => true,
                        'items_wrap'      => '<ul>%3$s</ul>',
                        'depth'           => 0,
                        'walker'          => '',
                    ] ); ?>
                    <?php wp_nav_menu( [
                        'theme_location'  => '',
                        'menu'            => 'Меню в подвале4',
                        'container'       => false,
                        'menu_class'      => '',
                        'echo'            => true,
                        'items_wrap'      => '<ul>%3$s</ul>',
                        'depth'           => 0,
                        'walker'          => '',
                    ] ); ?>
                </div>

                <div class="footer-logo">
                    <img src='<?php get_template_directory_uri(); ?>/assets/img/logo-footer.png' height="39" width="105" alt="">
                </div>

                <div class="footer-bot">
                    <?php wp_nav_menu( [
                        'theme_location'  => '',
                        'menu'            => 'Меню в подвале нижнее',
                        'container'       => false,
                        'menu_class'      => '',
                        'echo'            => true,
                        'items_wrap'      => '<ul>%3$s</ul>',
                        'depth'           => 0,
                        'walker'          => '',
                    ] ); ?>
                </div>
            </div>
        </footer>
    </div>
    <?php wp_footer(); ?>
</body>

</html>