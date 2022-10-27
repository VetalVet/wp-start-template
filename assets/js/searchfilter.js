// Фильтр по поиску и категориям без перезагрузки страницы
setTimeout(() => {
    let terms = document.querySelectorAll(".blog__filter-options .select__options .select__option");
    let searchForm = document.querySelector("#search");
    const posts = document.querySelector(".blog__content");
    terms.forEach((term) => {
        term.addEventListener("click", () => {
            let tag = term.getAttribute("data-value");
            let searchQuery = searchForm.value;

            tag ? history.pushState('', '', '?tag=' + tag) : '';
            searchQuery ? history.pushState('', '', '&s=' + searchQuery) : '';

            filterPosts(tag, searchQuery);
        });
    });

    searchForm.addEventListener('input', () => {
        if(searchForm.value.length > 1){
            let tag = document.querySelector('.select__option_selected').getAttribute("data-value");
            let searchQuery = searchForm.value;

            // console.log(searchQuery);
            tag ? history.pushState('', '', '?tag=' + tag) : '';
            if(tag){
                searchQuery ? history.pushState('', '', '&s=' + searchQuery) : '';
            } else{
                searchQuery ? history.pushState('', '', '?s=' + searchQuery) : '';
            }

            filterPosts(tag, searchQuery);
        }
    })

    async function filterPosts(tag, searchQuery) {

        let formData = new FormData();
        formData.append("action", "searchajax");
        formData.append("nonce", searchtags.nonce);
        formData.append("tag", tag);
        formData.append("s", searchQuery);

        let result = await fetch(searchtags.url, {
            method: 'POST',
            body: formData,
        })
        .then(data => data.text())
        .then(data => {
            posts.replaceChildren();
            posts.insertAdjacentHTML("beforeend", data);
        })
        .catch(() => console.log('Ошибка'))
        .finally(() => loadProducts())

        // if (result.ok) {
        //     let answer = await result.text();
        //     posts.replaceChildren();
        //     posts.insertAdjacentHTML("beforeend", answer);
        //     loadProducts();
        // } 
        // else {
        //     console.log('Ошибка');
        // }
    }
}, 3000)
// Фильтр по поиску и категориям без перезагрузки страницы



function loadProducts() {
    const nextPosts = document.querySelectorAll("a.page-numbers"),
          pagination = document.querySelector(".posts-navigation"),
          posts = document.querySelector(".blog__content");

    nextPosts.forEach((pag) => {
        pag.addEventListener("click", (e) => {
            e.preventDefault();

            pagination.style.opacity = "0.5";
            url = pag.getAttribute("href");

            loadMore(url);

            function loadMore(url) {
                if (url) {
                    fetch(url)
                        .then((data) => data.text())
                        .then(
                            (data) =>
                                new DOMParser()
                                    .parseFromString(data, "text/html")
                                    .querySelector(".blog__content")
                                    .innerHTML
                        )
                        .then((data) => {
                            posts.replaceChildren();
                            posts.insertAdjacentHTML("beforeend", data);
                        })
                        .finally(() => {
                            loadProducts();
                        });
                }
            }
        });
    });
}