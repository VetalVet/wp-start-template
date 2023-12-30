window.addEventListener("DOMContentLoaded", () => {
    // Ползунок с ценой
    const rangeSlider = document.getElementById("range-slider"),
          minPrice = document.getElementById("range-min").value,
          maxPrice = document.getElementById("range-max").value;

    if (rangeSlider) {
        noUiSlider.create(rangeSlider, {
            start: [+minPrice, +maxPrice],
            connect: true,
            step: 1,
            range: {
                min: [+minPrice],
                max: [+maxPrice],
            },
        });
        const rangeMin = document.getElementById("range-min");
        const rangeMax = document.getElementById("range-max");
        const ranges = [rangeMin, rangeMax];
        rangeSlider.noUiSlider.on("update", function (values, handle) {
            ranges[handle].value = Math.round(values[handle]);
        });

        rangeSlider.noUiSlider.on("end", function () {
            filterProducts();
        });

        const setRangeSlider = (i, value) => {
            let arr = [null, null];
            arr[i] = value;
            rangeSlider.noUiSlider.set(arr);
        };
        ranges.forEach((el, index) => {
            el.addEventListener("change", (e) => {
                setRangeSlider(index, e.currentTarget.value);
            });
        });
    }

    document.querySelector('.sorting__header').addEventListener('click', () => {
        document.querySelector('.sorting__body').classList.toggle('active');
    });


    const sortVariants = document.querySelectorAll('.sorting__variants-item');

    sortVariants.forEach(variant => {
        variant.addEventListener('click', () => {
            document.querySelector('.sorting__body').classList.remove('active');
            document.querySelector('.sorting__header .sorting__variant').textContent = variant.textContent;
            filterProducts(variant.getAttribute('data-sort'));
        }); 
    });

    initFilter();

    function initFilter(){
        let filterCheckboxes = document.querySelectorAll('.filters__input');
        filterCheckboxes.forEach(item => {
            item.addEventListener('change', filterProducts);
        })
    }

    function filterProducts(sort = 'ASC'){
        // Фильтр по характеристикам
        // Battery
        let checkedBattery = [];
        let batteryChecked = document.querySelectorAll('.pa_lamp-intensity .filters__input:checked');
        batteryChecked.forEach(filter => {
            checkedBattery.push(filter.getAttribute('data-id'));
        });

        // LampIntensity
        let checkedLampIntensity = [];
        let lampIntensityChecked = document.querySelectorAll('.pa_mobility .filters__input:checked');
        lampIntensityChecked.forEach(filter => {
            checkedLampIntensity.push(filter.getAttribute('data-id'));
        });
        
        // Mobile Application
        let checkedMobileApplication = [];
        let mobileApplicationChecked = document.querySelectorAll('.pa_treatment-area .filters__input:checked');
        mobileApplicationChecked.forEach(filter => {
            checkedMobileApplication.push(filter.getAttribute('data-id'));
        });

        // Use type
        let checkedUseType = [];
        let useTypeChecked = document.querySelectorAll('.pa_zone .filters__input:checked');
        useTypeChecked.forEach(filter => {
            checkedUseType.push(filter.getAttribute('data-id'));
        });

        // Сортировка
        
        let sortValue = 'ASC';
        if(sort == 'DESC'){
            sortValue = 'DESC';
        }

        let minPrice = document.getElementById("range-min").value;
        let maxPrice = document.getElementById("range-max").value;

        let data = new FormData();
        data.append('action', 'shopfilter'); // обязательно!
        data.append('nonce', filter.nonce); // защита от взлома
        data.append('pa_battery', checkedBattery); 
        data.append('pa_lamp-intensity', checkedLampIntensity); 
        data.append('pa_mobile-application', checkedMobileApplication); 
        data.append('pa_use-type', checkedUseType); 
        data.append('min_price', minPrice); 
        data.append('max_price', maxPrice); 

        data.append('sort', sortValue);
        // if(page){
        //     data.append('page', page);
        // }

        // let s = document.querySelector('.header-search-input').value;
        // if(s){
        //     data.append('s', s);
        // }


        loadProducts(data, document.querySelector('.catalog__products'))
        .then((result) => result.text())
        .then((result) => {
            // console.log(result);
            // if(result){
                document.querySelector('.catalog__products').innerHTML = result;
            // } else {
            //     document.querySelector('.catalog__products').remove();
            // }
        })
        // .then(() => document.querySelector('.pagination').setAttribute('data-cur', page + 1))
        .finally(() => {
            document.querySelector('.catalog__products').style.opacity = '1';
            // initFilter();
            // resetBtnInit();
            // loadMoreBtnInit();
            // fixPaginationLinks();
            // submitPaginationLinks();
        })
    }

    async function loadProducts(data, container) {
        container.style.opacity = '0.5';

        return await fetch(filter.url, {
            method: 'POST',
            body: data,
        })
    }
});