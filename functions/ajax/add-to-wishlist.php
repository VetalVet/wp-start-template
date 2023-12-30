<?php
// ajax поиск по сайту 
add_action('wp_ajax_nopriv_add_to_wishlist', 'addProductToWishlist');
add_action('wp_ajax_add_to_wishlist', 'addProductToWishlist');

function addProductToWishlist(){
    if (!wp_verify_nonce($_POST['nonce'], 'wishlist-nonce')) {
        wp_die('Данные отправлены с левого адреса');
    }

    // var_dump(explode(',', $_POST['product_id']));
    
    if(isset($_POST['user_id']) && isset($_POST['product_id'])){
        $property_id = explode(',', $_POST['product_id']);
        $user_id = intval($_POST['user_id']);

        $wishlist = get_user_meta($_POST['user_id'], 'wishlist_products');

        foreach($property_id as $id){
            if(!in_array($id, $wishlist)){
                if($id > 0 && $user_id > 0) {
                    // Добавить в БД объект дома
                    // ID юзера, ключ, значение
                    add_user_meta($user_id, 'wishlist_products', $id);
                    // if(add_user_meta($user_id, 'wishlist_products', $id)){
                    //     return true;
                    // } else {
                    //     return false;
                    // }
                }
            }
        }
    }

    wp_die();
}