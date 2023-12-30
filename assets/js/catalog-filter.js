window.addEventListener('DOMContentLoaded', () => {
    initFilter();
    resetBtnInit();
    loadMoreBtnInit();
    // submitPaginationLinks();
    // fixPaginationLinks();

    // Категория если есть
    let taxonomy = +document.querySelector('.catalog-wrap').getAttribute('data-tax');

    // Сортировка по мощности
    let powerSortCheckbox = document.querySelector('.catalog-sort-btn');
    powerSortCheckbox.addEventListener('click', filterProducts);


    function loadMoreBtnInit(){
        if(document.querySelector('.catalog-item-more')){
            document.querySelector('.catalog-item-more').addEventListener('click', (e) => {
                e.preventDefault();
    
                let currentPage = +document.querySelector('.pagination').getAttribute('data-cur');
                loadMoreProducts(currentPage);
                updatePagination(currentPage);
            });
        }
    }
    // function submitPaginationLinks(){
    //     let paginationLinks = document.querySelectorAll('a.page-numbers');
        
    //     paginationLinks.forEach(link => {
    //         link.addEventListener('click', (e) => {
    //             e.preventDefault();
    //             // console.log(link.getAttribute('href').split('?page=')[1]);
    //             let page = 1;

    //             // if(link.getAttribute('href').split('?page=')[1] > 1){
    //             //     page = link.getAttribute('href').split('?page=')[1];
    //             // }
    //             console.log(page);

    //             filterProducts(page);

    //             // new URLSearchParams(new FormData(document.querySelector('.catalog-filter-form'))).toString()
    //             // document.querySelector('.hidden_submit').click();
    //         });
    //     });
    // }
    
    function resetBtnInit(){
        let resetFiltersBtn = document.querySelector('.catalog-filter-reset');
        
        if(resetFiltersBtn){
            resetFiltersBtn.addEventListener('click', (e) => {
                e.preventDefault();
        
                let filterCheckboxes = document.querySelectorAll('.filter-checkbox-input');
                filterCheckboxes.forEach(item => {
                    item.checked = false;
                });
        
                filterProducts();
            });
        }
    }

    function initFilter(){
        let filterCheckboxes = document.querySelectorAll('.filter-checkbox-input');
        filterCheckboxes.forEach(item => {
            item.addEventListener('change', filterProducts);
        })
    }

    function filterProducts(page = ''){
        let filterSum = 0;

        // Фильтр по характеристикам
        // Общие
        let checkedCommon = [];
        let productCommonChecked = document.querySelectorAll('.product_common .filter-checkbox-input:checked');
        productCommonChecked.forEach(filter => {
            checkedCommon.push(filter.getAttribute('data-filter-id'));
        });
        filterSum += checkedCommon.length;

        // Марки
        let checkedMarks = [];
        let productMarksChecked = document.querySelectorAll('.product_marks .filter-checkbox-input:checked');
        productMarksChecked.forEach(filter => {
            checkedMarks.push(filter.getAttribute('data-filter-id'));
        });
        filterSum += checkedMarks.length;

        
        // Опции
        let checkedOptions = [];
        let productOptionsChecked = document.querySelectorAll('.product_options .filter-checkbox-input:checked');
        productOptionsChecked.forEach(filter => {
            checkedOptions.push(filter.getAttribute('data-filter-id'));
        });
        filterSum += checkedOptions.length;

        // Фреон
        let checkedFreon = [];
        let productFreonChecked = document.querySelectorAll('.product_freon .filter-checkbox-input:checked');
        productFreonChecked.forEach(filter => {
            checkedFreon.push(filter.getAttribute('data-filter-id'));
        });
        filterSum += checkedFreon.length;

        // Фильтр по мощности
        let checkedPower = [];
        let powerFilterChecked = document.querySelectorAll('.power_filter .filter-checkbox-input:checked');
        powerFilterChecked.forEach(filter => {
            checkedPower.push(filter.getAttribute('data-filter-id'));
        });
        filterSum += checkedPower.length;

        // Сортировка по мощности
        let sortValue = 'ASC';
        if(powerSortCheckbox.classList.contains('down')){
            sortValue = 'DESC';
        }



        let data = new FormData();
        data.append('action', 'catalogaction'); // обязательно!
        data.append('nonce', catalogsearch.nonce); // защита от взлома
        data.append('product_common', checkedCommon); 
        data.append('product_marks', checkedMarks); 
        data.append('product_options', checkedOptions); 
        data.append('product_freon', checkedFreon); 
        data.append('product_powers', checkedPower); 

        data.append('sort', sortValue);
        data.append('chosen_filters', filterSum); // Кол-во выбранных фильтров
        
        if(taxonomy){
            data.append('taxonomy', taxonomy);
        }

        let s = document.querySelector('.header-search-input').value;
        if(s){
            data.append('s', s);
        }
        

        loadProducts(data, document.querySelector('.catalog-wrap'))
        // .then((result) => result.text())
        .then((result) => result.json())
        .then((result) => {
            if(result.msg == "success"){
                console.log(result.state);
                document.querySelector('.catalog-wrap').innerHTML = result.products;
                history.replaceState(null, '', decodeURI(result.state));
            }
        })
        .finally(() => {
            document.querySelector('.catalog-wrap').style.opacity = '1';

            document.querySelector('.catalog-filter-btn span').innerText = document.querySelectorAll('.filter-checkbox-input:checked').length;
            if(document.querySelector('.catalog-item').getAttribute('data-found') > 0){
                document.querySelector('.catalog-hero-result span').innerText = document.querySelector('.catalog-item').getAttribute('data-found');
            } else {
                document.querySelector('.catalog-hero-result span').innerText = 0;
                // document.querySelector('.catalog-filter-btn span').innerText = 0;
            }


            initFilter();
            resetBtnInit();
            loadMoreBtnInit();
            // fixPaginationLinks();
            // submitPaginationLinks();
        })
    }  
    
    function loadMoreProducts(page){
        // Фильтр по характеристикам
        // Общие
        let checkedCommon = [];
        let productCommonChecked = document.querySelectorAll('.product_common .filter-checkbox-input:checked');
        productCommonChecked.forEach(filter => {
            checkedCommon.push(filter.getAttribute('data-filter-id'));
        });

        // Марки
        let checkedMarks = [];
        let productMarksChecked = document.querySelectorAll('.product_marks .filter-checkbox-input:checked');
        productMarksChecked.forEach(filter => {
            checkedMarks.push(filter.getAttribute('data-filter-id'));
        });
        
        // Опции
        let checkedOptions = [];
        let productOptionsChecked = document.querySelectorAll('.product_options .filter-checkbox-input:checked');
        productOptionsChecked.forEach(filter => {
            checkedOptions.push(filter.getAttribute('data-filter-id'));
        });

        // Фреон
        let checkedFreon = [];
        let productFreonChecked = document.querySelectorAll('.product_freon .filter-checkbox-input:checked');
        productFreonChecked.forEach(filter => {
            checkedFreon.push(filter.getAttribute('data-filter-id'));
        });

        // Фильтр по мощности
        let checkedPower = [];
        let powerFilterChecked = document.querySelectorAll('.power_filter .filter-checkbox-input:checked');
        powerFilterChecked.forEach(filter => {
            checkedPower.push(filter.getAttribute('data-filter-id'));
        });

        // Сортировка по мощности
        let sortValue = 'ASC';
        if(powerSortCheckbox.classList.contains('down')){
            sortValue = 'DESC';
        }


        let data = new FormData();
        data.append('action', 'catalogloadmore'); // обязательно!
        data.append('nonce', catalogsearch.nonce); // защита от взлома
        data.append('product_common', checkedCommon); 
        data.append('product_marks', checkedMarks); 
        data.append('product_options', checkedOptions); 
        data.append('product_freon', checkedFreon); 
        data.append('product_powers', checkedPower); 

        data.append('sort', sortValue);
        if(page){
            data.append('page', page);
        }

        // taxonomy
        if(taxonomy){
            data.append('taxonomy', taxonomy);
        }
        // taxonomy


        let s = document.querySelector('.header-search-input').value;
        if(s){
            data.append('s', s);
        }


        loadProducts(data, document.querySelector('.catalog-wrap'))
        // .then((result) => result.text())
        // .then((result) => {
        //     // let curPage = +document.querySelector('.pagination').getAttribute('data-cur') + 1;
        //     // let maxPage = +document.querySelector('.pagination').getAttribute('data-max');

        //     document.querySelector('.catalog-grid').insertAdjacentHTML('beforeend', result)
        //     // if(curPage == maxPage){
        //     //     document.querySelector('.catalog-item-more').remove();
        //     // }
        // })
        .then((result) => result.json())
        .then((result) => {
            if(result.msg == "success"){
                document.querySelector('.catalog-grid').insertAdjacentHTML('beforeend', result.products);
                history.replaceState(null, '', decodeURI(result.state));
            }
        })
        .then(() => document.querySelector('.pagination').setAttribute('data-cur', page + 1))
        .finally(() => {
            document.querySelector('.catalog-wrap').style.opacity = '1';
            // initFilter();
            // resetBtnInit();
            // loadMoreBtnInit();
            // fixPaginationLinks();
            // submitPaginationLinks();
        })
    }  

    async function loadProducts(data, container) {
        container.style.opacity = '0.5';

        return await fetch(search.url, {
            method: 'POST',
            body: data,
        })
    }

    async function updatePagination(page){
        // Фильтр по характеристикам
        // Общие
        let checkedCommon = [];
        let productCommonChecked = document.querySelectorAll('.product_common .filter-checkbox-input:checked');
        productCommonChecked.forEach(filter => {
            checkedCommon.push(filter.getAttribute('data-filter-id'));
        });

        // Марки
        let checkedMarks = [];
        let productMarksChecked = document.querySelectorAll('.product_marks .filter-checkbox-input:checked');
        productMarksChecked.forEach(filter => {
            checkedMarks.push(filter.getAttribute('data-filter-id'));
        });
        
        // Опции
        let checkedOptions = [];
        let productOptionsChecked = document.querySelectorAll('.product_options .filter-checkbox-input:checked');
        productOptionsChecked.forEach(filter => {
            checkedOptions.push(filter.getAttribute('data-filter-id'));
        });

        // Фреон
        let checkedFreon = [];
        let productFreonChecked = document.querySelectorAll('.product_freon .filter-checkbox-input:checked');
        productFreonChecked.forEach(filter => {
            checkedFreon.push(filter.getAttribute('data-filter-id'));
        });

        // Фильтр по мощности
        let checkedPower = [];
        let powerFilterChecked = document.querySelectorAll('.power_filter .filter-checkbox-input:checked');
        powerFilterChecked.forEach(filter => {
            checkedPower.push(filter.getAttribute('data-filter-id'));
        });

        // Сортировка по мощности
        let sortValue = 'ASC';
        if(powerSortCheckbox.classList.contains('down')){
            sortValue = 'DESC';
        }


        let data = new FormData();
        data.append('action', 'catalogpagination'); // обязательно!
        data.append('nonce', catalogsearch.nonce); // защита от взлома
        data.append('product_common', checkedCommon); 
        data.append('product_marks', checkedMarks); 
        data.append('product_options', checkedOptions); 
        data.append('product_freon', checkedFreon); 
        data.append('product_powers', checkedPower); 

        data.append('sort', sortValue);

        let s = document.querySelector('.header-search-input').value;
        if(s){
            data.append('s', s);
        }

        if(page){
            data.append('page', page);
        }
        
        // taxonomy
        // const taxonomy = +document.querySelector('.catalog-wrap').getAttribute('data-tax');
        if(taxonomy){
            data.append('taxonomy', taxonomy);
        }
        // taxonomy

        return await fetch(search.url, {
            method: 'POST',
            body: data,
        })
        .then(pagination => pagination.json())
        .then((pagination) => {
            // console.log(pagination);
            history.replaceState(null, '', decodeURI(pagination.state));

            document.querySelectorAll('.pagination')[0].remove();
            document.querySelectorAll('.pagination-mob')[0].remove();
            document.querySelector('.catalog-item-footer').insertAdjacentHTML('afterbegin', pagination.products);

            let curPage = +document.querySelector('.pagination').getAttribute('data-cur');
            let maxPage = +document.querySelector('.pagination').getAttribute('data-max');

            console.log(curPage);
            console.log(maxPage);
            if(curPage == maxPage){
                document.querySelector('.catalog-item-more').remove();
            }
        });
    }

    function fixPaginationLinks(){
        if(document.querySelector('.pagination')){
            let currentPage = document.querySelector('.pagination').getAttribute('data-cur');
            let link = window.location.href.split('?')[0];
    
            if(currentPage != 1){
                document.querySelector('.prev').nextElementSibling.setAttribute('href', link);
            }
            
            if(currentPage == 2){
                document.querySelector('.prev').setAttribute('href', link);
            }
        }
    }
});