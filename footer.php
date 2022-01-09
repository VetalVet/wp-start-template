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
                    <!-- <?php the_field(''); ?> -->
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
                    <ul class="footer-social">
                        <li>
                            <a href="#">
                                <svg version="1.2" baseProfile="tiny-ps" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 17 16" width="40" height="40">
                                    <title>Forsíða 2</title>
                                    <defs>
                                        <clipPath clipPathUnits="userSpaceOnUse" id="cp1">
                                            <path d="m-707-3525h960v3596h-960z" />
                                        </clipPath>
                                    </defs>
                                    <style>
                                        tspan {
                                            white-space: pre
                                        }

                                        .s0 {
                                            fill: #404042
                                        }
                                    </style>
                                    <g id="Forsíða 2" clip-path="url(#cp1)">
                                        <g id="Group 11611">
                                            <path id="Icon awesome-facebook-square" class="s0"
                                                d="m14.56 0.25c0.93 0 1.69 0.76 1.69 1.69v12.37c0 0.93-0.76 1.69-1.69 1.69h-4.83v-5.35h2.03l0.39-2.52h-2.42v-1.64c0-0.69 0.34-1.36 1.42-1.36h1.1v-2.14c0 0-1-0.17-1.95-0.17c-1.99 0-3.29 1.21-3.29 3.39v1.92h-2.21v2.52h2.21v5.35h-4.83c-0.93 0-1.69-0.76-1.69-1.69v-12.37c0-0.93 0.76-1.69 1.69-1.69h12.38v0z" />
                                        </g>
                                    </g>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <svg version="1.2" baseProfile="tiny-ps" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 19 16" width="40" height="40">
                                    <title>Forsíða 2</title>
                                    <defs>
                                        <clipPath clipPathUnits="userSpaceOnUse" id="cp1">
                                            <path d="m-733-3525h960v3596h-960z" />
                                        </clipPath>
                                    </defs>
                                    <style>
                                        tspan {
                                            white-space: pre
                                        }

                                        .s0 {
                                            fill: #404042
                                        }
                                    </style>
                                    <g id="Forsíða 2" clip-path="url(#cp1)">
                                        <g id="Group 11611">
                                            <path id="Icon awesome-twitter" class="s0"
                                                d="m16.65 4.46c0.01 0.16 0.01 0.32 0.01 0.48c0 4.88-3.71 10.5-10.5 10.5c-2.09 0-4.03-0.61-5.66-1.66c0.3 0.03 0.58 0.05 0.89 0.05c1.72 0 3.31-0.58 4.58-1.58c-1.62-0.03-2.98-1.1-3.45-2.56c0.23 0.03 0.46 0.06 0.7 0.06c0.33 0 0.66-0.05 0.97-0.13c-1.69-0.34-2.96-1.83-2.96-3.62v-0.05c0.49 0.27 1.06 0.45 1.67 0.47c-0.99-0.66-1.64-1.79-1.64-3.07c0-0.69 0.18-1.31 0.5-1.86c1.82 2.24 4.55 3.7 7.61 3.86c-0.06-0.27-0.09-0.56-0.09-0.85c0-2.03 1.64-3.69 3.69-3.69c1.06 0 2.02 0.45 2.7 1.16c0.83-0.16 1.63-0.47 2.34-0.89c-0.27 0.86-0.86 1.58-1.62 2.03c0.74-0.08 1.46-0.29 2.12-0.57c-0.5 0.73-1.13 1.38-1.85 1.91v0z" />
                                        </g>
                                    </g>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <svg version="1.2" baseProfile="tiny-ps" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 17 16" width="40" height="40">
                                    <title>Forsíða 2</title>
                                    <defs>
                                        <clipPath clipPathUnits="userSpaceOnUse" id="cp1">
                                            <path d="m-761-3525h960v3596h-960z" />
                                        </clipPath>
                                    </defs>
                                    <style>
                                        tspan {
                                            white-space: pre
                                        }

                                        .s0 {
                                            fill: #404042
                                        }
                                    </style>
                                    <g id="Forsíða 2" clip-path="url(#cp1)">
                                        <g id="Group 11611">
                                            <path id="Icon awesome-linkedin-in" class="s0"
                                                d="m4.03 15.87h-3.27v-10.52h3.27v10.52zm-1.63-11.95c-1.04 0-1.89-0.86-1.89-1.91c0-1.04 0.85-1.89 1.89-1.89c1.04 0 1.89 0.85 1.89 1.89c0 1.04-0.85 1.91-1.89 1.91zm13.86 11.95h-3.26v-5.12c0-1.22-0.02-2.78-1.7-2.78c-1.7 0-1.96 1.33-1.96 2.7v5.21h-3.26v-10.52h3.13v1.43h0.05c0.44-0.83 1.5-1.7 3.09-1.7c3.3 0 3.91 2.18 3.91 5v5.78h0z" />
                                        </g>
                                    </g>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <svg version="1.2" baseProfile="tiny-ps" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 17 20" width="40" height="40">
                                    <title>Forsíða 2</title>
                                    <defs>
                                        <clipPath clipPathUnits="userSpaceOnUse" id="cp1">
                                            <path d="m-787-3522h960v3596h-960z" />
                                        </clipPath>
                                    </defs>
                                    <style>
                                        tspan {
                                            white-space: pre
                                        }

                                        .s0 {
                                            fill: #404042
                                        }
                                    </style>
                                    <g id="Forsíða 2" clip-path="url(#cp1)">
                                        <g id="Group 11611">
                                            <path id="Icon zocial-youtube" fill-rule="evenodd" class="s0"
                                                d="m0.5 13.78c0-0.65 0.04-1.62 0.11-2.92c0.05-0.64 0.28-1.15 0.68-1.56c0.41-0.4 0.93-0.62 1.57-0.66c1.2-0.06 3.01-0.09 5.42-0.09c2.41 0 4.22 0.03 5.42 0.09c0.64 0.04 1.16 0.25 1.57 0.66c0.41 0.4 0.64 0.92 0.68 1.56c0.06 1.08 0.09 2.05 0.09 2.92c0 0.86-0.03 1.84-0.09 2.92c-0.05 0.64-0.28 1.16-0.68 1.56c-0.41 0.4-0.93 0.62-1.57 0.66c-1.2 0.06-3.01 0.09-5.42 0.09c-2.41 0-4.22-0.03-5.42-0.09c-0.64-0.04-1.16-0.25-1.57-0.66c-0.41-0.4-0.64-0.92-0.68-1.56c-0.07-1.3-0.11-2.27-0.11-2.92zm1.21-2.54h1.1v5.87h1.06v-5.87h1.1v-0.99h-3.26v0.99zm1.17-10.85h1.08l0.68 2.74h0.07l0.65-2.74h1.08l-0.83 2.66c-0.28 0.88-0.41 1.33-0.41 1.35v2.84h-1.06v-2.72c-0.02-0.17-0.06-0.32-0.1-0.46c-0.04-0.14-0.1-0.3-0.16-0.48c-0.07-0.18-0.12-0.33-0.15-0.45l-0.85-2.75zm2.74 16.79c0.38 0 0.75-0.21 1.1-0.63v0.56h0.94v-5.06h-0.94v3.85c-0.25 0.25-0.44 0.38-0.56 0.38c-0.17 0-0.25-0.11-0.25-0.34v-3.89h-0.94v4.27c0 0.58 0.22 0.86 0.65 0.86zm0.77-11.21v-2.63c0-0.41 0.13-0.72 0.4-0.94c0.26-0.22 0.6-0.33 1.01-0.33c0.4 0 0.72 0.12 0.96 0.36c0.25 0.24 0.37 0.56 0.37 0.95v2.61c0 0.43-0.12 0.77-0.36 1.02c-0.24 0.25-0.58 0.37-1.01 0.37c-0.42 0-0.75-0.13-1-0.39c-0.25-0.26-0.37-0.6-0.37-1.02zm0.97 0.13c0 0.28 0.13 0.41 0.4 0.41c0.28 0 0.41-0.15 0.41-0.45v-2.75c0-0.11-0.04-0.2-0.13-0.27c-0.08-0.07-0.18-0.11-0.29-0.11c-0.11 0-0.2 0.03-0.28 0.1c-0.08 0.07-0.12 0.15-0.12 0.26v2.81h0zm2.16 11.02v-0.38c0.24 0.3 0.54 0.45 0.9 0.45c0.56 0 0.85-0.37 0.85-1.12v-2.81c0-0.85-0.31-1.28-0.92-1.28c-0.3 0-0.58 0.16-0.83 0.49v-2.21h-0.95v6.86h0.95zm0-0.95v-3.17c0.13-0.13 0.26-0.2 0.4-0.2c0.26 0 0.4 0.17 0.4 0.5v2.66c0 0.29-0.11 0.43-0.34 0.43c-0.17 0-0.32-0.08-0.45-0.23zm0.41-9.7v-4.27h0.94v3.87c0 0.23 0.08 0.34 0.25 0.34c0.16 0 0.34-0.13 0.56-0.38v-3.83h0.94v5.06h-0.94v-0.56c-0.35 0.42-0.71 0.63-1.1 0.63c-0.43 0-0.65-0.29-0.65-0.86zm2.39 10.36c0.23 0.29 0.57 0.44 1.03 0.44c0.94 0 1.4-0.52 1.4-1.57v-0.38h-0.97c0 0.02 0 0.11 0.01 0.24c0.01 0.14 0 0.24-0.01 0.3c-0.01 0.06-0.03 0.14-0.05 0.24c-0.02 0.1-0.06 0.17-0.12 0.22c-0.06 0.04-0.14 0.06-0.25 0.06c-0.28 0-0.41-0.24-0.41-0.72v-0.95h1.8v-1.3c0-0.46-0.11-0.82-0.33-1.08c-0.22-0.26-0.56-0.4-1.02-0.4c-0.43 0-0.78 0.14-1.03 0.41c-0.26 0.28-0.39 0.63-0.39 1.06v2.29c0 0.46 0.11 0.83 0.34 1.12zm0.63-2.91v-0.54c0-0.37 0.14-0.56 0.41-0.56c0.28 0 0.41 0.19 0.41 0.56v0.54h-0.83z" />
                                        </g>
                                    </g>
                                </svg>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </footer>
    </div>
    <?php wp_footer(); ?>
</body>

</html>