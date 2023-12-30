window.addEventListener('DOMContentLoaded', () => {
    
    // Pricing ============================================================
    let topUpSearchInput = document.querySelector('.pricing__search input');
    let paymentMethods = document.querySelectorAll('.pricing__pay');

    // выбранные атрибуты
    let checkedAtts = {
        type: 'all',
        name: '',
        countries: 'all',
        regions: 'all',
    }

    // Поле ввода метода
    topUpSearchInput.addEventListener('input', () => {
        checkedAtts.name = topUpSearchInput.value;
        filterMethods();
    });

    // селект со странами
    let countries = $('.countries-topup');
    countries.on('select2:select', (e) => {
        checkedAtts.countries = e.params.data.id;
        filterMethods();
    });

    // селект с типами оплаты 
    let paymentTypes = $('.payment-types');
    paymentTypes.on('select2:select', (e) => {
        checkedAtts.type = e.params.data.id;
        filterMethods();
    });

    // селект с регионами
    let regions = $('.regions');
    regions.on('select2:select', (e) => {
        checkedAtts.regions = e.params.data.id;
        filterMethods();
    });

    // Filters payment methods by chosen params and search query
    function filterMethods(){
        paymentMethods.forEach(method => {
            let methodTypes = method.getAttribute('data-type');
            let methodCountries = method.querySelector('.countries.full').textContent;
            let methodRegions = method.getAttribute('data-regions');
            let methodName = method.querySelector('.pricing__pay-left span').textContent;
            
            // Hide countries
            // закрывает открытый список стран у метода когда происходит фильтрация
            let moreCounrtriesBtn = method.querySelector('.pricing__pay-center span');
            if(moreCounrtriesBtn){
                method.querySelector('.pricing__pay-center').classList.remove('active');
                moreCounrtriesBtn.innerHTML = moreCounrtriesBtn.getAttribute('data-more');
            }

            // фильтрация по типу оплаты 
            if(checkedAtts.type == 'all'){ 
                method.classList.remove('removed');
            } else if(!methodTypes.includes(checkedAtts.type)) {
                method.classList.add('removed');
            } else { 
                method.classList.remove('removed');
            }

            // фильтрация по странам
            if(checkedAtts.countries == 'all'){ 
                if(!method.classList.contains('removed')){
                    method.classList.remove('removed');
                }
            } else if(!methodCountries.includes(checkedAtts.countries)) {
                if(!method.classList.contains('removed')){
                    method.classList.add('removed');
                }
            } else { 
                if(!method.classList.contains('removed')){
                    method.classList.remove('removed');
                }
            }

            // фильтрация по регионам
            if(checkedAtts.regions == 'all'){ 
                if(!method.classList.contains('removed')){
                    method.classList.remove('removed');
                }
            } else if(!methodRegions.includes(checkedAtts.regions)) {
                if(!method.classList.contains('removed')){
                    method.classList.add('removed');
                }
            } else { 
                if(!method.classList.contains('removed')){
                    method.classList.remove('removed');
                }
            }

            // фильтрация по названию введенному в поле ввода
            if(checkedAtts.name == 'all'){ 
                if(!method.classList.contains('removed')){
                    method.classList.remove('removed');
                }
            } else if(!methodName.toLowerCase().includes(checkedAtts.name.toLowerCase())) {
                if(!method.classList.contains('removed')){
                    method.classList.add('removed');
                }
            } else { 
                if(!method.classList.contains('removed')){
                    method.classList.remove('removed');
                }
            }
        });
    }
});