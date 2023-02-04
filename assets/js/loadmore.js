window.addEventListener("DOMContentLoaded", () => {
    // AJAX-фильтр по поиску и категориям
    // let terms = document.querySelectorAll(".gamescats option");
    let terms = document.querySelector(".gamescats");
    let searchForm = document.querySelector(".searchgames");
    const posts = document.querySelector(".allgames");
    terms.addEventListener('change', () => {
        let tag = terms.value;
        let searchQuery = searchForm.value;

        tag ? history.pushState("", "", "?tag=" + tag) : '';
        searchQuery ? history.pushState("", "", "&s=" + searchQuery) : "";

        filterPosts(tag, searchQuery);
    })
    // terms.forEach((term) => {
    //     term.addEventListener("click", () => {
    //         let tag = term.value;
    //         let searchQuery = searchForm.value;

    //         tag ? history.pushState("", "", "?tag=" + tag) : "";
    //         searchQuery ? history.pushState("", "", "&s=" + searchQuery) : "";

    //         filterPosts(tag, searchQuery);
    //     });
    // });

    searchForm.addEventListener("input", () => {
        if (searchForm.value.length) {
            // let tag = document
            //     .querySelector(".select__option_selected")
            //     .getAttribute("data-value");
            let tag = terms.value;
            let searchQuery = searchForm.value;

            // tag ? history.pushState("", "", "?tag=" + tag) : '';
            // searchQuery ? history.pushState("", "", "&s=" + searchQuery) : "";
            tag ? history.pushState("", "", "?tag=" + tag) : "";
            if (tag) {
                searchQuery
                    ? history.pushState("", "", "&s=" + searchQuery)
                    : "";
            } else {
                searchQuery
                    ? history.pushState("", "", "?s=" + searchQuery)
                    : "";
            }

            filterPosts(tag, searchQuery);
        } else{
            history.pushState("", "", "")
        }
    });

    async function filterPosts(tag, searchQuery) {
        let formData = new FormData();
        formData.append("action", "gamesaction");
        formData.append("nonce", loadgames.nonce);
        formData.append("tag", tag);
        formData.append("s", searchQuery);

        let result = await fetch(loadgames.url, {
            method: "POST",
            body: formData,
        })
            .then((data) => data.text())
            // .then((data) => console.log(data))
            .then((data) => {
                posts.replaceChildren();
                posts.insertAdjacentHTML("beforeend", data);
            })
            .catch(() => console.log("Ошибка"))
            .finally(() => loadProducts());

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

    // AJAX-подгрузка постов при скролле
    loadProducts();

    function loadProducts() {
        const nextPosts = document.querySelector(".next"),
            pagination = document.querySelector(".posts-navigation"),
            products = document.querySelector(".allgames");

        nextPosts.addEventListener("click", (e) => {
            e.preventDefault();

            pagination.style.opacity = "0.5";
            url = nextPosts.getAttribute("href");

            loadMore(url);

            function loadMore(url) {
                if (url) {
                    fetch(url)
                        .then((data) => data.text())
                        .then(
                            (data) =>
                                new DOMParser()
                                    .parseFromString(data, "text/html")
                                    .querySelector(".allgames").innerHTML
                        )
                        .then((data) =>
                            products.insertAdjacentHTML("beforeend", data)
                        )
                        .then(() => pagination.remove())
                        .finally(() => {
                            if (
                                !document.querySelector(
                                    ".posts-navigation .next"
                                )
                            ) {
                                document
                                    .querySelector(".posts-navigation")
                                    .remove();
                                // addToCart();
                            } else {
                                loadProducts();
                                // addToCart();
                                // window.addEventListener("scroll", loadOnScroll);
                            }
                        });
                }
            }
        });
    }

    // window.addEventListener("scroll", loadOnScroll);

    // function loadOnScroll() {
    //     let scrollHeight = Math.max(
    //         document.body.scrollHeight,
    //         document.documentElement.scrollHeight,
    //         document.body.offsetHeight,
    //         document.documentElement.offsetHeight,
    //         document.body.clientHeight,
    //         document.documentElement.clientHeight
    //     );
    //     next = document.querySelector(".next");
    //     footerHeight = document.querySelector("footer").clientHeight;

    //     if (window.scrollY > (scrollHeight - footerHeight) / 2) {
    //         window.removeEventListener("scroll", loadOnScroll);
    //         next.click();
    //     }
    // }
});
