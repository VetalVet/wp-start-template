"use strict";

var ua = window.navigator.userAgent;
var msie = ua.indexOf("MSIE ");
var isMobile = {
  Android: function Android() {
    return navigator.userAgent.match(/Android/i);
  },
  BlackBerry: function BlackBerry() {
    return navigator.userAgent.match(/BlackBerry/i);
  },
  iOS: function iOS() {
    return navigator.userAgent.match(/iPhone|iPad|iPod/i);
  },
  Opera: function Opera() {
    return navigator.userAgent.match(/Opera Mini/i);
  },
  Windows: function Windows() {
    return navigator.userAgent.match(/IEMobile/i);
  },
  any: function any() {
    return isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows();
  }
};

function isIE() {
  ua = navigator.userAgent;
  var is_ie = ua.indexOf("MSIE ") > -1 || ua.indexOf("Trident/") > -1;
  return is_ie;
}

if (isIE()) {
  document.querySelector('html').classList.add('ie');
}

if (isMobile.any()) {
  document.querySelector('html').classList.add('_touch');
} /////////////////////////////////////////////
///////////////// Меню-бургер начало
/////////////////////////////////////////////
// $('.burger').click(function (event) {
//     $(this).toggleClass('active');
//     $('.').toggleClass('active');
//     $('body').toggleClass('lock');
// });


var burger = document.querySelector('.burger');
var headerMenu = document.querySelector('.head-menu');
var body = document.querySelector('body');
burger.addEventListener('click', function () {
  burger.classList.toggle('h-active');
  headerMenu.classList.toggle('h-active');
  body.classList.toggle('lock');
}); /////////////////////////////////////////////
///////////////// Меню-бургер конец
/////////////////////////////////////////////
/////////////////////////////////////////////
///////////////// Слайдеры начало
/////////////////////////////////////////////

var myImageSlider = new Swiper('.image-slider', {
  // Стрелки
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev'
  }
}); /////////////////////////////////////////////
///////////////// Слайдеры конец
/////////////////////////////////////////////
/////////////////////////////////////////////
///////////////// Ленивая загрузка начало
/////////////////////////////////////////////

var lazyImages = document.querySelectorAll('img[data-src],source[data-srcset]');
var loadMapBlock = document.querySelector('._load-map');
var windowHeight = document.documentElement.clientHeight;
var loadMoreBlock = document.querySelector('._load-more');
var lazyImagesPositions = [];

if (lazyImages.length > 0) {
  lazyImages.forEach(function (img) {
    if (img.dataset.src || img.dataset.srcset) {
      lazyImagesPositions.push(img.getBoundingClientRect().top + pageYOffset);
      lazyScrollCheck();
    }
  });
}

window.addEventListener('scroll', lazyScroll);

function lazyScroll() {
  if (document.querySelectorAll('img[data-src],source[data-srcset]').length > 0) {
    lazyScrollCheck();
  } // if (!loadMapBlock.classList.contains('_loaded')) {
  //     getMap();
  // }
  // if (!loadMoreBlock.classList.contains('_loading')) {
  //     loadMore();
  // }

}

function lazyScrollCheck() {
  var imgIndex = lazyImagesPositions.findIndex(function (item) {
    return pageYOffset > item - windowHeight;
  });

  if (imgIndex >= 0) {
    if (lazyImages[imgIndex].dataset.src) {
      lazyImages[imgIndex].src = lazyImages[imgIndex].dataset.src;
      lazyImages[imgIndex].removeAttribute('data-src');
    } else if (lazyImages[imgIndex].dataset.srcset) {
      lazyImages[imgIndex].srcset = lazyImages[imgIndex].dataset.srcset;
      lazyImages[imgIndex].removeAttribute('data-srcset');
    }

    delete lazyImagesPositions[imgIndex];
  }
} /////////////////////////////////////////////
///////////////// Ленивая загрузка конец
/////////////////////////////////////////////