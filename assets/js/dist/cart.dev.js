"use strict";

// -----------------------------------------------
// Скрипт добавления и удаления товаров из корзины
window.onload = function () {
  document.addEventListener("click", documentActions);

  function documentActions(e) {
    var targetElement = e.target; // в зависимости от устройства и ширины экрана меняет поведение стрелки
    // на телефонах списки переходят в спойлер
    // if (window.innerWidth > 768 && isMobile.any()) {
    //     if (targetElement.classList.contains('menu__arrow')) {
    //         targetElement.closest('.menu__item').classList.toggle('_hover');
    //     }
    //     if (!targetElement.closest('.menu__item') && document.querySelectorAll('.menu__item._hover').length > 0) {
    //         _removeClasses(document.querySelectorAll('.menu__item._hover'), "_hover");
    //     }
    // }
    // выпадающий блок поиска
    // if (targetElement.classList.contains('search-form__icon')) {
    //     document.querySelector('.search-form').classList.toggle('_active');
    // } else if (!targetElement.closest('.search-form') && document.querySelector('.search-form._active')) {
    //     document.querySelector('.search-form').classList.remove('_active');
    // }
    // вывод продуктов через ajax

    if (targetElement.classList.contains('products__more')) {
      getProducts(targetElement);
      e.preventDefault();
    } // добавление товара в корзину по нажатию на кнопку товара


    if (targetElement.classList.contains('actions-product__button')) {
      var productId = targetElement.closest('.item-product').dataset.pid;
      addToCart(targetElement, productId);
      e.preventDefault();
    } // возможность открыть корзину после добавления туда товара
    // можно если добавлены товары, нельзя если товаров нет


    if (targetElement.classList.contains('cart-header__icon') || targetElement.closest('.cart-header__icon')) {
      if (document.querySelector('.cart-list').children.length > 0) {
        document.querySelector('.cart-header').classList.toggle('_active');
      }

      e.preventDefault();
    } else if (!targetElement.closest('.cart-header') && !targetElement.classList.contains('actions-product__button')) {
      document.querySelector('.cart-header').classList.remove('_active');
    } // удаление товара из корзины


    if (targetElement.classList.contains('cart-list__delete')) {
      var _productId = targetElement.closest('.cart-list__item').dataset.cartPid;
      updateCart(targetElement, _productId, false);
      e.preventDefault();
    }
  } // Load More Products - подгрузка ajax из json


  function getProducts(button) {
    var file, response, result;
    return regeneratorRuntime.async(function getProducts$(_context) {
      while (1) {
        switch (_context.prev = _context.next) {
          case 0:
            if (button.classList.contains('_hold')) {
              _context.next = 16;
              break;
            }

            button.classList.add('_hold'); // путь к файлу json с товарами
            // выставлять самому!

            file = "json/products.json"; // получение товаров из файла json

            _context.next = 5;
            return regeneratorRuntime.awrap(fetch(file, {
              method: "GET"
            }));

          case 5:
            response = _context.sent;

            if (!response.ok) {
              _context.next = 15;
              break;
            }

            _context.next = 9;
            return regeneratorRuntime.awrap(response.json());

          case 9:
            result = _context.sent;
            loadProducts(result); // убираем кнопку, если товаров больше нет

            button.classList.remove('_hold');
            button.remove();
            _context.next = 16;
            break;

          case 15:
            // если ответа нет
            alert("Ошибка");

          case 16:
          case "end":
            return _context.stop();
        }
      }
    });
  } // формирование товара когда он подгружается с json
  // нужно кастомизировать под свой проект самому!


  function loadProducts(data) {
    var productsItems = document.querySelector('.products__items');
    data.products.forEach(function (item) {
      var productId = item.id;
      var productUrl = item.url;
      var productImage = item.image;
      var productTitle = item.title;
      var productText = item.text;
      var productPrice = item.price;
      var productOldPrice = item.priceOld;
      var productShareUrl = item.shareUrl;
      var productLikeUrl = item.likeUrl;
      var productLabels = item.labels;
      var productTemplateStart = "<article data-pid=\"".concat(productId, "\" class=\"products__item item-product\">");
      var productTemplateEnd = "</article>";
      var productTemplateLabels = '';

      if (productLabels) {
        var productTemplateLabelsStart = "<div class=\"item-product__labels\">";
        var productTemplateLabelsEnd = "</div>";
        var productTemplateLabelsContent = '';
        productLabels.forEach(function (labelItem) {
          productTemplateLabelsContent += "<div class=\"item-product__label item-product__label_".concat(labelItem.type, "\">").concat(labelItem.value, "</div>");
        });
        productTemplateLabels += productTemplateLabelsStart;
        productTemplateLabels += productTemplateLabelsContent;
        productTemplateLabels += productTemplateLabelsEnd;
      }

      var productTemplateImage = "\n\t\t<a href=\"".concat(productUrl, "\" class=\"item-product__image _ibg\">\n\t\t\t<img src=\"img/products/").concat(productImage, "\" alt=\"").concat(productTitle, "\">\n\t\t</a>\n\t");
      var productTemplateBodyStart = "<div class=\"item-product__body\">";
      var productTemplateBodyEnd = "</div>";
      var productTemplateContent = "\n\t\t<div class=\"item-product__content\">\n\t\t\t<h3 class=\"item-product__title\">".concat(productTitle, "</h3>\n\t\t\t<div class=\"item-product__text\">").concat(productText, "</div>\n\t\t</div>\n\t");
      var productTemplatePrices = '';
      var productTemplatePricesStart = "<div class=\"item-product__prices\">";
      var productTemplatePricesCurrent = "<div class=\"item-product__price\">Rp ".concat(productPrice, "</div>");
      var productTemplatePricesOld = "<div class=\"item-product__price item-product__price_old\">Rp ".concat(productOldPrice, "</div>");
      var productTemplatePricesEnd = "</div>";
      productTemplatePrices = productTemplatePricesStart;
      productTemplatePrices += productTemplatePricesCurrent;

      if (productOldPrice) {
        productTemplatePrices += productTemplatePricesOld;
      }

      productTemplatePrices += productTemplatePricesEnd;
      var productTemplateActions = "\n\t\t<div class=\"item-product__actions actions-product\">\n\t\t\t<div class=\"actions-product__body\">\n\t\t\t\t<a href=\"\" class=\"actions-product__button btn btn_white\">Add to cart</a>\n\t\t\t\t<a href=\"".concat(productShareUrl, "\" class=\"actions-product__link _icon-share\">Share</a>\n\t\t\t\t<a href=\"").concat(productLikeUrl, "\" class=\"actions-product__link _icon-favorite\">Like</a>\n\t\t\t</div>\n\t\t</div>\n\t");
      var productTemplateBody = '';
      productTemplateBody += productTemplateBodyStart;
      productTemplateBody += productTemplateContent;
      productTemplateBody += productTemplatePrices;
      productTemplateBody += productTemplateActions;
      productTemplateBody += productTemplateBodyEnd;
      var productTemplate = '';
      productTemplate += productTemplateStart;
      productTemplate += productTemplateLabels;
      productTemplate += productTemplateImage;
      productTemplate += productTemplateBody;
      productTemplate += productTemplateEnd;
      productsItems.insertAdjacentHTML('beforeend', productTemplate);
    });
  } // AddToCart


  function addToCart(productButton, productId) {
    if (!productButton.classList.contains('_hold')) {
      productButton.classList.add('_hold');
      productButton.classList.add('_fly');
      var cart = document.querySelector('.cart-header__icon');
      var product = document.querySelector("[data-pid=\"".concat(productId, "\"]"));
      var productImage = product.querySelector('.item-product__image');
      var productImageFly = productImage.cloneNode(true); // переменные для анимации добавления в корзину
      // const productImageFlyWidth = productImage.offsetWidth;
      // const productImageFlyHeight = productImage.offsetHeight;
      // const productImageFlyTop = productImage.getBoundingClientRect().top;
      // const productImageFlyLeft = productImage.getBoundingClientRect().left;

      productImageFly.setAttribute('class', '_flyImage _ibg'); // добавление анимации добавления в корзину
      // 	productImageFly.style.cssText =
      // 		`
      // 	left: ${productImageFlyLeft}px;
      // 	top: ${productImageFlyTop}px;
      // 	width: ${productImageFlyWidth}px;
      // 	height: ${productImageFlyHeight}px;
      // `
      // ;

      document.body.append(productImageFly);
      var cartFlyLeft = cart.getBoundingClientRect().left;
      var cartFlyTop = cart.getBoundingClientRect().top;
      productImageFly.style.cssText = "\n\t\t\tleft: ".concat(cartFlyLeft, "px;\n\t\t\ttop: ").concat(cartFlyTop, "px;\n\t\t\twidth: 0px;\n\t\t\theight: 0px;\n\t\t\topacity:0;\n\t\t\t"); // обновление корзины после анимации

      productImageFly.addEventListener('transitionend', function () {
        if (productButton.classList.contains('_fly')) {
          productImageFly.remove();
          updateCart(productButton, productId);
          productButton.classList.remove('_fly');
        }
      });
    }
  }

  function updateCart(productButton, productId) {
    var productAdd = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : true;
    var cart = document.querySelector('.cart-header');
    var cartIcon = cart.querySelector('.cart-header__icon');
    var cartQuantity = cartIcon.querySelector('span');
    var cartProduct = document.querySelector("[data-cart-pid=\"".concat(productId, "\"]"));
    var cartList = document.querySelector('.cart-list'); //Добавляем

    if (productAdd) {
      // если товары есть в корзине, то при добавлении товара 
      // увеличивает кол-во товаров в корзине
      if (cartQuantity) {
        cartQuantity.innerHTML = ++cartQuantity.innerHTML;
      } // отображает счётчик когда первый товар добавлен в корзину
      else {
          cartIcon.insertAdjacentHTML('beforeend', "<span>1</span>");
        } // при добавлении товара в корзину включает список товаров с выбранным товаром


      if (!cartProduct) {
        var product = document.querySelector("[data-pid=\"".concat(productId, "\"]"));
        var cartProductImage = product.querySelector('.item-product__image').innerHTML;
        var cartProductTitle = product.querySelector('.item-product__title').innerHTML;
        var cartProductContent = "\n\t\t\t\t<a href=\"\" class=\"cart-list__image _ibg\">".concat(cartProductImage, "</a>\n\t\t\t\t<div class=\"cart-list__body\">\n\t\t\t\t\t<a href=\"\" class=\"cart-list__title\">").concat(cartProductTitle, "</a>\n\t\t\t\t\t<div class=\"cart-list__quantity\">Quantity: <span>1</span></div>\n\t\t\t\t\t<a href=\"\" class=\"cart-list__delete\">Delete</a>\n\t\t\t\t</div>");
        cartList.insertAdjacentHTML('beforeend', "<li data-cart-pid=\"".concat(productId, "\" class=\"cart-list__item\">").concat(cartProductContent, "</li>"));
      } // если список товаров уже есть, просто увеличивает количество
      // и при удалении товаров удаляет сам список 
      else {
          var cartProductQuantity = cartProduct.querySelector('.cart-list__quantity span');
          cartProductQuantity.innerHTML = ++cartProductQuantity.innerHTML;
        } // После всех действий


      productButton.classList.remove('_hold');
    } else {
      var _cartProductQuantity = cartProduct.querySelector('.cart-list__quantity span');

      _cartProductQuantity.innerHTML = --_cartProductQuantity.innerHTML;

      if (!parseInt(_cartProductQuantity.innerHTML)) {
        cartProduct.remove();
      } // уменьшает кол-во товаров из корзины и убирает список товаров когда их там нет


      var cartQuantityValue = --cartQuantity.innerHTML;

      if (cartQuantityValue) {
        cartQuantity.innerHTML = cartQuantityValue;
      } else {
        cartQuantity.remove();
        cart.classList.remove('_active');
      }
    }
  } // -----------------------------------------------

}; // Скрипт добавления и удаления товаров из корзины
// -----------------------------------------------