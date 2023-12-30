initQuantity();
couponUpdate();

// Счётчик -1+ для описания товара
function initQuantity(){
	let productQuantityButtons = document.querySelectorAll('.product-quantity-block .quantity__button');
	if (productQuantityButtons.length > 0) {
		for (let index = 0; index < productQuantityButtons.length; index++) {
			const quantityButton = productQuantityButtons[index];
			quantityButton.addEventListener("click", function (e) {
				let value = parseInt(quantityButton.closest('.product-quantity-block').querySelector('input').value);
				if (quantityButton.classList.contains('quantity__button_plus')) {
					value++;
				} else {
					value = value - 1;

					if (value < 1) {
						value = 1
					}
				}
				quantityButton.closest('.product-quantity-block').querySelector('input').value = value;

				document.querySelector('[name="update_cart"]').removeAttribute('disabled');
				document.querySelector('[name="update_cart"]').click();
			});
		}
	}
}
// Счётчик -1+ для описания товара

// Применить купон
function couponUpdate(){
	let couponInput = document.querySelector('.cart_totals .coupon input');
	let couponBtn = document.querySelector('.cart_totals .coupon .apply_coupon');
	
	couponInput.addEventListener('input', (e) => document.querySelector('.coupon input').value = e.target.value);
	couponBtn.addEventListener('click', () => document.querySelector('.coupon .apply_coupon').click());
}
// Применить купон

// Обновить кол-во товаров в корзине
function updadeCartTotalQuantity(){
	const products = document.querySelectorAll('.cart_item');
	let quantity = 0;

	products.forEach(item => {
		quantity += +item.querySelector('.quantity__input input').value;
	});

	document.querySelector('.basket__count').textContent = quantity;
}
// Обновить кол-во товаров в корзине

// Обновить итоговую цену всех товаров в корзине
function updadeCartTotalPrice(){
	const totalPrice = document.querySelector('.cart_totals .shop_table .order-total bdi');
	document.querySelector('.basket__total span').textContent = totalPrice.textContent.slice(0, -3).replace(',', '');
}
// Обновить итоговую цену всех товаров в корзине


jQuery( document.body ).on( 'removed_from_cart updated_cart_totals', () => {
	// console.log('updated');
    initQuantity();
	couponUpdate();
	updadeCartTotalQuantity();
	updadeCartTotalPrice();
});