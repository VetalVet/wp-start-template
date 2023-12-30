<?php get_header(); ?>
<?php 
    global $post;
    // print_r($post);
?>
<main>
    Заголовок поста: <?php the_title(); ?>

    <br>

    <!-- дата добавления или обновления поста -->
    <?php
        $u_modified_time = get_the_modified_time('U');
        if ($u_modified_time) {
            echo "Обновлено:";
            the_modified_time('M jS Y');
            echo ", в ";
            the_modified_time();
            echo "</span> ";
        } else{
            echo "Добавлено: ";
            the_time('M jS Y');
            echo ", в ";
            the_time();
            echo "</span>";
        }
    ?>

    <br>
    Категории поста: 
    <?php 
        $cats = get_the_category( $post->ID );
        foreach($cats as $cat){
            echo $cat->name . ", ";
        } 
    ?>

    <br>
    Автор поста: 
    <?php 
        $first_name = get_the_author_meta('first_name', $post->post_author );
        $last_name  = get_the_author_meta('last_name', $post->post_author );
        $user = get_the_author_meta('display_name', $post->post_author );
        
        if($first_name && $last_name){
            echo 'имя: ' . $first_name . ', ';
            echo 'фамилия: ' . $last_name;
        } else{
            echo 'display_name: ' . $user;
        }
    ?>

    <br>
    Роль автора:
    <?php
        $roles = get_the_author_meta('roles', $post->post_author );

        foreach($roles as $role){
            if($role == 'administrator'){
                echo $role . ', ';
            }
        }
    ?>

    <br>
    Содержимое поста: <?php the_content(); ?>
    <br>

    Предыдущий пост: <?php previous_post_link('%link »', '%title', true); ?>
    <br>

    Следующий пост: <?php next_post_link('%link »', '%title', true); ?>

    <br>
    <?php // echo get_template_part('sidebar'); ?>

</main>

<?php get_footer(); ?>


<!-- Пример цикла вывода постов -->
<aside>
	<?php
		// global $post;

		// $current_post = $post->ID;
		// $cats = get_the_category($current_post);
		// $current_cats = [];

		// foreach($cats as $cat){
		// 	array_push($current_cats, $cat->name);
		// }

		// $query = new WP_Query( array(
		// 	'post_type'      	=> 'post',
		// 	'post__not_in' 		=> array($current_post),
		// 	'category__and' 	=> array($current_cats),
		// 	'posts_per_page'   	=> 3,
		// ) );

		// if( $query->have_posts() ){
		// 	while( $query->have_posts() ){
		// 		$query->the_post();
				
		// 		echo get_template_part('template-parts/content');
		// 	}
		// 	wp_reset_postdata(); // сбрасываем переменную $post
		// } else{
		// 	echo get_template_part('template-parts/content-none');
		// }


        $cases = new WP_Query( array(
			'post_type'      	=> 'cases',
			'posts_per_page'   	=> 2,
		) );

		if( $cases->have_posts() ){
			while( $cases->have_posts() ){
				$cases->the_post();
                the_post_thumbnail();
                the_title();
			}
			wp_reset_postdata(); // сбрасываем переменную $post
		} else{
			'No cases'
		}
	?>

</aside>