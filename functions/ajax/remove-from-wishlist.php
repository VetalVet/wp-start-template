<?php
// ajax поиск по сайту 
add_action('wp_ajax_nopriv_remove_from_wishlist', 'removeProductFromWishlist');
add_action('wp_ajax_remove_from_wishlist', 'removeProductFromWishlist');

function removeProductFromWishlist(){
    if (!wp_verify_nonce($_POST['nonce'], 'wishlist-remove-nonce')) {
        wp_die('Данные отправлены с левого адреса');
    }

    if(isset($_POST['user_id']) && isset($_POST['product_id'])){
        $property_id = explode(',', $_POST['product_id']);
        $user_id = intval($_POST['user_id']);

        $wishlist = get_user_meta($_POST['user_id'], 'wishlist_products');

        foreach($property_id as $id){
            if(in_array($id, $wishlist)){
                if($id > 0 && $user_id > 0) {
                    delete_user_meta($user_id, 'wishlist_products', $id);
                    // if(delete_user_meta($user_id, 'wishlist_products', $id)){
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