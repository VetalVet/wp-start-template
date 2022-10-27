addToCart();

function addToCart(){
    let ajaxBtns = document.querySelectorAll('.ajax_add_to_cart', '.remove');
    const cart = document.querySelector('.cart-wrapper');
    // const cart = document.querySelector('.cart-wrapper');
    
    ajaxBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
    
            let data = new FormData();
            data.append('action', 'addtocart');
            data.append('nonce', addtocart.nonce);
    
    
            fetch(wc_add_to_cart_params.ajax_url,
                {
                    method: 'POST',
                    body: data
                }
            )
            .then((data) => data.text())
            .then((data) => new DOMParser().parseFromString(data, "text/html").querySelector('.cart-wrapper').innerHTML)
            .then((data) => cart.innerHTML = data)
        })
    })
}