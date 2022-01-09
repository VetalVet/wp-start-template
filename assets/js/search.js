// AJAX-поиск
const search_input = document.querySelector('.search-input');
const search_results = document.querySelector('.ajax-search');
const searchForm = document.querySelector('.header-search');

search_input.addEventListener('input', () => {
    let search_value = search_input.value;

    if (search_value.length > 1) { // кол-во символов 

        let formData = new FormData(searchForm);
        formData.append('action', 'search_ajax'); // обязательно!
        formData.append('nonce', search.nonce); // защита от взлома

        searchAjax()

        async function searchAjax() {
            let result = await fetch(search.url, {
                method: 'POST',
                // body: dataSearch,
                body: formData,
            })
            

            if (result.ok) {
                search_results.classList.remove('hidden');
                let answer = await result.text();
                search_results.innerHTML = answer;
            } 
            else {
                console.log('Ошибка');
            }
        }
    }
    else {
        return;
    }
});

// Закрытие поиска при клике вне его 
window.addEventListener('click', (e) => {
    e.preventDefault();

    if (!e.target.classList.contains('ajax-search') || search_value.length == 0) {
        search_results.classList.add('hidden');
    };
}) 
