// Меню-бургер
const burger = document.querySelector('.burger')
const headerMenu = document.querySelector('.head-menu')
const body = document.querySelector('body')

burger.addEventListener('click', () => {
    burger.classList.toggle('h-active')
    headerMenu.classList.toggle('h-active')
    body.classList.toggle('lock')
})
// Меню-бургер 



// Слайдеры
let myImageSlider = new Swiper('.image-slider', {
    // Стрелки
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev'
    },

})
// Слайдеры


// Ленивая загрузка
const lazyImages = document.querySelectorAll('img[data-src],source[data-srcset]');
const loadMapBlock = document.querySelector('._load-map');
const windowHeight = document.documentElement.clientHeight;
const loadMoreBlock = document.querySelector('._load-more');

let lazyImagesPositions = [];
if (lazyImages.length > 0) {
    lazyImages.forEach(img => {
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
    }
    // if (!loadMapBlock.classList.contains('_loaded')) {
    //     getMap();
    // }
    // if (!loadMoreBlock.classList.contains('_loading')) {
    //     loadMore();
    // }
}

function lazyScrollCheck() {
    let imgIndex = lazyImagesPositions.findIndex(
        item => pageYOffset > item - windowHeight
    );
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
}

// Ленивая загрузка

// Табы
var tabNavs = document.querySelectorAll(".nav-tab");
var tabPanes = document.querySelectorAll(".tab-pane");
for (var i = 0; i < tabNavs.length; i++) {
    tabNavs[i].addEventListener("click", function(e){
        e.preventDefault();
        var activeTabAttr = e.target.getAttribute("data-tab");
        for (var j = 0; j < tabNavs.length; j++) {
            var contentAttr = tabPanes[j].getAttribute("data-tab-content");
            if (activeTabAttr === contentAttr) {
                tabNavs[j].classList.add("active");
                tabPanes[j].classList.add("active"); 
            } else {
                tabNavs[j].classList.remove("active");
                tabPanes[j].classList.remove("active");
            }
        };
    });
}
// Табы

// Адаптивные аккордеоны в зависимости от ширины экрана
const spollersArray = document.querySelectorAll('[data-spollers]');
if (spollersArray.length > 0) {
    // Получение обычных слойлеров
    const spollersRegular = Array.from(spollersArray).filter(function (item, index, self) {
        return !item.dataset.spollers.split(",")[0];
    });
    // Инициализация обычных слойлеров
    if (spollersRegular.length > 0) {
        initSpollers(spollersRegular);
    }

    // Получение слойлеров с медиа запросами
    const spollersMedia = Array.from(spollersArray).filter(function (item, index, self) {
        return item.dataset.spollers.split(",")[0];
    });

    // Инициализация слойлеров с медиа запросами
    if (spollersMedia.length > 0) {
        const breakpointsArray = [];
        spollersMedia.forEach(item => {
            const params = item.dataset.spollers;
            const breakpoint = {};
            const paramsArray = params.split(",");
            breakpoint.value = paramsArray[0];
            breakpoint.type = paramsArray[1] ? paramsArray[1].trim() : "max";
            breakpoint.item = item;
            breakpointsArray.push(breakpoint);
        });

        // Получаем уникальные брейкпоинты
        let mediaQueries = breakpointsArray.map(function (item) {
            return '(' + item.type + "-width: " + item.value + "px)," + item.value + ',' + item.type;
        });
        mediaQueries = mediaQueries.filter(function (item, index, self) {
            return self.indexOf(item) === index;
        });

        // Работаем с каждым брейкпоинтом
        mediaQueries.forEach(breakpoint => {
            const paramsArray = breakpoint.split(",");
            const mediaBreakpoint = paramsArray[1];
            const mediaType = paramsArray[2];
            const matchMedia = window.matchMedia(paramsArray[0]);

            // Объекты с нужными условиями
            const spollersArray = breakpointsArray.filter(function (item) {
                if (item.value === mediaBreakpoint && item.type === mediaType) {
                    return true;
                }
            });
            // Событие
            matchMedia.addListener(function () {
                initSpollers(spollersArray, matchMedia);
            });
            initSpollers(spollersArray, matchMedia);
        });
    }
    // Инициализация
    function initSpollers(spollersArray, matchMedia = false) {
        spollersArray.forEach(spollersBlock => {
            spollersBlock = matchMedia ? spollersBlock.item : spollersBlock;
            if (matchMedia.matches || !matchMedia) {
                spollersBlock.classList.add('_init');
                initSpollerBody(spollersBlock);
                spollersBlock.addEventListener("click", setSpollerAction);
            } else {
                spollersBlock.classList.remove('_init');
                initSpollerBody(spollersBlock, false);
                spollersBlock.removeEventListener("click", setSpollerAction);
            }
        });
    }
    // Работа с контентом
    function initSpollerBody(spollersBlock, hideSpollerBody = true) {
        const spollerTitles = spollersBlock.querySelectorAll('[data-spoller]');
        if (spollerTitles.length > 0) {
            spollerTitles.forEach(spollerTitle => {
                if (hideSpollerBody) {
                    spollerTitle.removeAttribute('tabindex');
                    if (!spollerTitle.classList.contains('_active')) {
                        spollerTitle.nextElementSibling.hidden = true;
                    }
                } else {
                    spollerTitle.setAttribute('tabindex', '-1');
                    spollerTitle.nextElementSibling.hidden = false;
                }
            });
        }
    }
    function setSpollerAction(e) {
        const el = e.target;
        if (el.hasAttribute('data-spoller') || el.closest('[data-spoller]')) {
            const spollerTitle = el.hasAttribute('data-spoller') ? el : el.closest('[data-spoller]');
            const spollersBlock = spollerTitle.closest('[data-spollers]');
            const oneSpoller = spollersBlock.hasAttribute('data-one-spoller') ? true : false;
            if (!spollersBlock.querySelectorAll('._slide').length) {
                if (oneSpoller && !spollerTitle.classList.contains('_active')) {
                    hideSpollersBody(spollersBlock);
                }
                spollerTitle.classList.toggle('_active');
                _slideToggle(spollerTitle.nextElementSibling, 500);
            }
            e.preventDefault();
        }
    }
    function hideSpollersBody(spollersBlock) {
        const spollerActiveTitle = spollersBlock.querySelector('[data-spoller]._active');
        if (spollerActiveTitle) {
            spollerActiveTitle.classList.remove('_active');
            _slideUp(spollerActiveTitle.nextElementSibling, 500);
        }
    }
}
//SlideToggle
let _slideUp = (target, duration = 500) => {
    if (!target.classList.contains('_slide')) {
        target.classList.add('_slide');
        target.style.transitionProperty = 'height, margin, padding';
        target.style.transitionDuration = duration + 'ms';
        target.style.height = target.offsetHeight + 'px';
        target.offsetHeight;
        target.style.overflow = 'hidden';
        target.style.height = 0;
        target.style.paddingTop = 0;
        target.style.paddingBottom = 0;
        target.style.marginTop = 0;
        target.style.marginBottom = 0;
        window.setTimeout(() => {
            target.hidden = true;
            target.style.removeProperty('height');
            target.style.removeProperty('padding-top');
            target.style.removeProperty('padding-bottom');
            target.style.removeProperty('margin-top');
            target.style.removeProperty('margin-bottom');
            target.style.removeProperty('overflow');
            target.style.removeProperty('transition-duration');
            target.style.removeProperty('transition-property');
            target.classList.remove('_slide');
        }, duration);
    }
}
let _slideDown = (target, duration = 500) => {
    if (!target.classList.contains('_slide')) {
        target.classList.add('_slide');
        if (target.hidden) {
            target.hidden = false;
        }
        let height = target.offsetHeight;
        target.style.overflow = 'hidden';
        target.style.height = 0;
        target.style.paddingTop = 0;
        target.style.paddingBottom = 0;
        target.style.marginTop = 0;
        target.style.marginBottom = 0;
        target.offsetHeight;
        target.style.transitionProperty = "height, margin, padding";
        target.style.transitionDuration = duration + 'ms';
        target.style.height = height + 'px';
        target.style.removeProperty('padding-top');
        target.style.removeProperty('padding-bottom');
        target.style.removeProperty('margin-top');
        target.style.removeProperty('margin-bottom');
        window.setTimeout(() => {
            target.style.removeProperty('height');
            target.style.removeProperty('overflow');
            target.style.removeProperty('transition-duration');
            target.style.removeProperty('transition-property');
            target.classList.remove('_slide');
        }, duration);
    }
}
let _slideToggle = (target, duration = 500) => {
    if (target.hidden) {
        return _slideDown(target, duration);
    } else {
        return _slideUp(target, duration);
    }
}
// Адаптивные аккордеоны в зависимости от ширины экрана



// Отправка формы на почту или телеграм
const forms = document.querySelectorAll('form')

forms.forEach(item => {
    item.addEventListener('submit', (e) => {
        e.preventDefault();

        const formData = new FormData(item);
        const url = 'assets/forms/server.php'

        const postData = async (url, data) => {
            let res = await fetch(url, {
                method: 'POST',
                body: data
            });

            // return res.text();
        };

        postData(url, formData)
            .then(res => {

            })
            .catch(() => alert('ошибка'))
            // .finally(() => {

            // });
    });
});
// Отправка формы на почту или телеграм



// Маска телефона 
var masking = {
    // User defined Values
    //maskedInputs : document.getElementsByClassName('masked'), // add with IE 8's death
    maskedInputs: document.querySelectorAll('.masked'), // kill with IE 8's death
    maskedNumber: '_dDmMyY9',
    maskedLetter: '_',

    init: function () {
        masking.setUpMasks(masking.maskedInputs);
        masking.maskedInputs = document.querySelectorAll('.masked'); // Repopulating. Needed b/c static node list was created above.
        masking.activateMasking(masking.maskedInputs);
    },

    setUpMasks: function (inputs) {
        var i, l = inputs.length;

        for (i = 0; i < l; i++) {
            masking.createShell(inputs[i]);
        }
    },

    // replaces each masked input with a shall containing the input and it's mask.
    createShell: function (input) {
        var text = '',
            placeholder = input.getAttribute('placeholder');

        input.setAttribute('maxlength', placeholder.length);
        input.setAttribute('data-placeholder', placeholder);
        // input.removeAttribute('placeholder');

        text = '<span class="shell">' +
            '<span aria-hidden="true" id="' + input.id +
            'Mask"><i></i>' + placeholder + '</span>' +
            input.outerHTML +
            '</span>';

        input.outerHTML = text;
    },

    setValueOfMask: function (e) {
        var value = e.target.value,
            placeholder = e.target.getAttribute('data-placeholder');

        return "<i>" + value + "</i>" + placeholder.substr(value.length);
    },

    // add event listeners
    activateMasking: function (inputs) {
        var i, l;

        for (i = 0, l = inputs.length; i < l; i++) {
            if (masking.maskedInputs[i].addEventListener) {
                // remove "if" after death of IE 8
                masking.maskedInputs[i].addEventListener('keyup', function (e) {
                    masking.handleValueChange(e);
                }, false);
            } else if (masking.maskedInputs[i].attachEvent) { // For IE 8
                masking.maskedInputs[i].attachEvent("onkeyup", function (e) {
                    e.target = e.srcElement;
                    masking.handleValueChange(e);
                });
            }
        }
    },

    handleValueChange: function (e) {
        var id = e.target.getAttribute('id');

        switch (e.keyCode) { // allows navigating thru input
            case 20: // caplocks
            case 17: // control
            case 18: // option
            case 16: // shift
            case 37: // arrow keys
            case 38:
            case 39:
            case 40:
            case 9: // tab (let blur handle tab)
                return;
        }

        document.getElementById(id).value = masking.handleCurrentValue(e);
        document.getElementById(id + 'Mask').innerHTML = masking.setValueOfMask(e);

    },

    handleCurrentValue: function (e) {
        var isCharsetPresent = e.target.getAttribute('data-charset'),
            placeholder = isCharsetPresent || e.target.getAttribute('data-placeholder'),
            value = e.target.value,
            l = placeholder.length,
            newValue = '',
            i, j, isInt, isLetter, strippedValue;

        // strip special characters
        strippedValue = isCharsetPresent ? value.replace(/\W/g, "") : value.replace(/\D/g, "");

        for (i = 0, j = 0; i < l; i++) {
            var x =
                isInt = !isNaN(parseInt(strippedValue[j]));
            isLetter = strippedValue[j] ? strippedValue[j].match(/[A-Z]/i) : false;
            matchesNumber = masking.maskedNumber.indexOf(placeholder[i]) >= 0;
            matchesLetter = masking.maskedLetter.indexOf(placeholder[i]) >= 0;

            if ((matchesNumber && isInt) || (isCharsetPresent && matchesLetter && isLetter)) {

                newValue += strippedValue[j++];

            } else if ((!isCharsetPresent && !isInt && matchesNumber) || (isCharsetPresent && ((matchesLetter && !isLetter) || (matchesNumber && !isInt)))) {
                // masking.errorOnKeyEntry(); // write your own error handling function
                return newValue;

            } else {
                newValue += placeholder[i];
            }
            // break if no characters left and the pattern is non-special character
            if (strippedValue[j] == undefined) {
                break;
            }
        }
        if (e.target.getAttribute('data-valid-example')) {
            return masking.validateProgress(e, newValue);
        }
        return newValue;
    },

    validateProgress: function (e, value) {
        var validExample = e.target.getAttribute('data-valid-example'),
            pattern = new RegExp(e.target.getAttribute('pattern')),
            placeholder = e.target.getAttribute('data-placeholder'),
            l = value.length,
            testValue = '';

        //convert to months
        if (l == 1 && placeholder.toUpperCase().substr(0, 2) == 'MM') {
            if (value > 1 && value < 10) {
                value = '0' + value;
            }
            return value;
        }
        // test the value, removing the last character, until what you have is a submatch
        for (i = l; i >= 0; i--) {
            testValue = value + validExample.substr(value.length);
            if (pattern.test(testValue)) {
                return value;
            } else {
                value = value.substr(0, value.length - 1);
            }
        }

        return value;
    },

    errorOnKeyEntry: function () {
        alert('error')
        // Write your own error handling
    }
}
masking.init();
// Маска телефона 



// Анимация при скролле
const animItems = document.querySelectorAll('._anim-items');

if (animItems.length > 0) {

    window.addEventListener('scroll', animOnScroll);

    function animOnScroll() {
        for (let index = 0; index < animItems.length; index++) {
            const animItem = animItems[index];
            // высота объекта
            const animItemHeight = animItem.offsetHeight;
            const animItemOffset = offset(animItem).top;
            const animStart = 4;

            let animItemPoint = window.innerHeight - animItemHeight / animStart;
            if (animItemHeight > window.innerHeight) {
                animItemPoint = window.innerHeight - window.innerHeight / animStart;
            }


            if ((pageYOffset > animItemOffset - animItemPoint) && pageYOffset < (animItemOffset + animItemHeight)) {
                animItem.classList.add('_active');
            } else {
                if (!animItem.classList.contains('_anim-no-hide')) {
                    animItem.classList.remove('_active');
                }
            }
        }
    }
    function offset(el) {
        const rect = el.getBoundingClientRect(),
            scrollLeft = window.pageXOffset || document.documentElement.scrollLeft,
            scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        return { top: rect.top + scrollTop, left: rect.left + scrollLeft }
    }

    setTimeout(() => {
        animOnScroll();
    }, 300);
}
// Анимация при скролле

