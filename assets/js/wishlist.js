window.addEventListener('DOMContentLoaded', () => {
    let userID = wishlist.user_id;
    let product_ID = wishlist.product_id;
    let wishlistBtn = document.querySelector('.product-favorite-btn');

    wishlistBtn.addEventListener('click', () => {

        if(!wishlistBtn.classList.contains('added')){
            wishlistBtn.style.opacity = '0.5';
            let data = new FormData();
            data.append('action', 'add_to_wishlist'); // обязательно!
            data.append('nonce', wishlist.nonce); // защита от взлома
            data.append('user_id', userID); 
            data.append('product_id', product_ID); 
    
            fetch(wishlist.url, {
                body: data,
                method: 'POST',
            })
            // .then((data) => console.log(data.text()))
            .then(() => wishlistBtn.classList.add('added'))
            .then(() => wishlistBtn.style.opacity = '1')
        } else {
            wishlistBtn.style.opacity = '0.5';
            let data = new FormData();
            data.append('action', 'remove_from_wishlist'); // обязательно!
            data.append('nonce', wishlist.remove_nonce); // защита от взлома
            data.append('user_id', userID); 
            data.append('product_id', product_ID); 
    
            fetch(wishlist.url, {
                body: data,
                method: 'POST',
            }).then(() => wishlistBtn.classList.remove('added'))
            .then(() => wishlistBtn.style.opacity = '1')
        }
    });
});