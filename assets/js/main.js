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



// Кастомная маска телефона
const mask = (selector, pattern) => {

    let setCursorPosition = (pos, elem) => {
        elem.focus();
        
        if (elem.setSelectionRange) {
            elem.setSelectionRange(pos, pos);
        } else if (elem.createTextRange) {
            let range = elem.createTextRange();

            range.collapse(true);
            range.moveEnd('character', pos);
            range.moveStart('character', pos);
            range.select();
        }
    };

    function createMask(event) {
        let matrix = pattern,
            i = 0,
            def = matrix.replace(/\D/g, ''),
            val = this.value.replace(/\D/g, '');

        if (def.length >= val.length) {
            val = def;
        }

        this.value = matrix.replace(/./g, function(a) {
            return /[_\d]/.test(a) && i < val.length ? val.charAt(i++) : i >= val.length ? '' : a;
        });

        if (event.type === 'blur') {
            if (this.value.length == 2) {
                this.value = '';
            }
        } else {
            setCursorPosition(this.value.length, this);
        }
    }

    let inputs = document.querySelectorAll(selector);

    inputs.forEach(input => {
        input.addEventListener('input', createMask);
        input.addEventListener('focus', createMask);
        input.addEventListener('blur', createMask);
    });
};

// mask(".phone-ukr", '+38 (___) ___ __ __'); 
// mask(".phone", '+__ (___) ___ __ __'); 
// Кастомная маска телефона



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



// Переход по ссылкам в селекте
let languages = document.querySelectorAll(".select__option");
let options = document.querySelectorAll(".lang option");

for (let i = 0; i < languages.length; i++) {
    let href = options[i].getAttribute("data-link");
    languages[i].setAttribute("href", href);
    languages[i].addEventListener('click', () => {
        window.location = languages[i].getAttribute("href");
    })
}
// Переход по ссылкам в селекте

// Email валидация
function validateEmail(email) {
    const re =
        /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}
// Email валидация


// Валидация формы
const form = document.querySelector(".more__msg-form"),
    formName = document.querySelector(".more__msg-form input[name='name']"),
    formEmail = document.querySelector(".more__msg-form input[name='email']"),
    formMessage = document.querySelector(".more__msg-form textarea[name='message']"),
    textCaptcha = document.querySelector(".g-recaptcha"),
    statusMessage = document.querySelector(".status");

form.addEventListener("submit", (e) => {
    e.preventDefault();
    let error = 0;

    // Проверка имени
    if (formName.value.length == 0) {
        formName.classList.add("invalid");
        error++;
    } else {
        formName.classList.remove("invalid");
    }

    // Проверка телефона
    if (formName.value.length == 0) {
        formName.classList.add("invalid");
        error++;
    } else {
        formName.classList.remove("invalid");
    }

    // Проверка email
    if (emailTest(formEmail)) {
        formEmail.classList.add("invalid");
        error++;
    } else {
        formEmail.classList.remove("invalid");
    }

    // Проверка сообщения
    if (formMessage.value.length == 0) {
        formMessage.classList.add("invalid");
        error++;
    } else {
        formMessage.classList.remove("invalid");
    }

    // Проверка капчи
    if(grecaptcha.getResponse() == ''){
        textCaptcha.classList.add("invalid");
        error++;
    } else{
        textCaptcha.classList.remove("invalid");
    }

    

    if (error === 0) {
        form.style.opacity = "0.5";

        let statusText = {
            loading: 'Message sends...',
            success: 'Thank you for your message! A Brebeneskul team member will get back to you shortly.',
            fail: 'Server error, try send your message later'
        }

        statusMessage.textContent = statusText.loading;

        let formData = new FormData(form);
        const url = "sender/maili.php";

        const postData = async (url, data) => {
            let res = await fetch(url, {
                method: "POST",
                body: data,
            });
            // return res;
        };

        postData(url, formData)
            .then((response) => {
                statusMessage.textContent = statusText.success;
                statusMessage.classList.add('success');
            })
            .catch(() => {
                statusMessage.textContent = statusText.fail;
                statusMessage.classList.add('fail')
            })
            .finally(() => {
                form.style.opacity = "1";
                setTimeout(() => {
                    statusMessage.classList.remove('fail');
                    statusMessage.classList.remove('success');
                }, 5000)
            });
    }
});

function emailTest(input) {
    return !/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/.test(input.value);
}

function phoneTest(input) {
    return !/(\+7|8)[\s(]?(\d{3})[\s)]?(\d{3})[\s-]?(\d{2})[\s-]?(\d{2})/.test(input.value);
}
// Валидация формы