window.addEventListener('DOMContentLoaded', () => {
    const eventsWrapper = document.querySelector(".events__items");
    const btnWrapper = document.querySelector('.events-btn-wrapper');

    const eventLinks = document.querySelectorAll('.event-links span')

    let language = 'ua'
    let currentLocale = eventsWrapper.getAttribute('data-lang');
    if(currentLocale == 'en'){
        language = 'en-US'
    } else {
        language = 'uk-UA'
    }


    eventLinks.forEach(event => {
        let eventUrl = event.getAttribute('data-fb-event');
        const token = document.querySelector('[name="secret"]').value;

        // console.log(token);
        console.log(eventUrl);

        getEvents(eventUrl, token);
    })



    function getEvents(eventUrl, token){
        let formData = new FormData();
        formData.append("action", "getpostfb"); // обязательно!
        formData.append("nonce", getpostfb.nonce); // защита от взлома
        formData.append("event", eventUrl); // защита от взлома
        formData.append("token", token);

        requestEvents();

        async function requestEvents() {
            let result = await fetch(getpostfb.url, {
                method: "POST",
                body: formData,
            });

            if (result.ok) {
                let postsData = await result.text();
                let postsJson = JSON.parse(postsData);
                let events = JSON.parse(postsJson)

                // console.log(events);

                let photo = '';
                if(events.cover){
                    photo = events.cover.source;
                }
                let name = events.name
                let time = events.start_time
                let permalink_url = 'https://www.facebook.com/events/' + events.id


                let date = '';
                if(events.start_time){
                    date = new Date(time.split("T")[0]).toLocaleString(
                        language,
                        { day: "numeric", month: "long", year: "numeric" }
                    );
                }
                
                // console.log(photo);
                // console.log(name);
                // console.log(date);
                // console.log(permalink_url);

                publishPosts(photo, name, date, permalink_url);
            } else {
                console.log("Ошибка");
            }
        }
    }
    // getPosts();

    // function getPosts() {
    //     let formData = new FormData();
    //     formData.append("action", "getpostfb"); // обязательно!
    //     formData.append("nonce", getpostfb.nonce); // защита от взлома

    //     requestPosts();

    //     async function requestPosts() {
    //         let result = await fetch(getpostfb.url, {
    //             method: "POST",
    //             body: formData,
    //         });

    //         if (result.ok) {
    //             let postsData = await result.text();
    //             let postsJson = JSON.parse(postsData);
    //             let posts = JSON.parse(postsJson).posts.data;

    //             let paginator = JSON.parse(postsJson).posts.paging.next;

    //             posts.forEach((post) => {
    //                 let {
    //                     permalink_url,
    //                     message,
    //                     full_picture,
    //                     is_published,
    //                     created_time,
    //                 } = post;

    //                 date = new Date(created_time.split("T")[0]).toLocaleString(
    //                     language,
    //                     { day: "numeric", month: "long", year: "numeric" }
    //                 );

    //                 if (is_published) {
    //                     publishPosts(permalink_url, message, full_picture, date);
    //                 }
    //             });

    //             addPaginateLink(paginator);
    //         } else {
    //             console.log("Ошибка");
    //         }
    //     }
    // }
    
    function publishPosts(photo, name, date = "", permalink_url) {
        eventsWrapper.insertAdjacentHTML(
            "beforeend",
            `<a href=${permalink_url} class="events__item fade-in" target="_blank">
                <div class="events__item-img">
                    <img src="${photo}" alt="">
                    <svg width="44" height="45" viewBox="0 0 44 45" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22.0118 33.0658L23.2218 31.9122L30.6138 24.8803L28.1938 22.3421L23.7716 26.5501L23.7716 12.3545L20.2516 12.3545L20.2516 26.5501L15.8295 22.3421L13.4095 24.8803L20.8015 31.9122L22.0118 33.0658Z" fill="white" />
                    </svg>
                </div>
                <div class="events__item-text">
                    <div class="events__item-date">${date}</div>
                    <div class="events__item-title">${name}</div>
                </div>
            </a>`
        );
    }

    function addPaginateLink(paginator){
        btnWrapper.insertAdjacentHTML(
            "beforeend",
            `<div data-load=${paginator} class="events-btn">завантажити ще</div>`
        );
        paginateLink();
    }

    function paginateLink() {
        let loadBtn = document.querySelector('.events-btn');
        
        loadBtn.addEventListener('click', (e) => {
            e.preventDefault();
            let href = loadBtn.getAttribute('data-load');
            if(href){
                fetch(href)
                    .then((data) => data.text())
                    .then((data) => JSON.parse(data).data)
                    .then((data) => {
                        data.forEach(post => {
                            let {
                                permalink_url,
                                message,
                                full_picture,
                                is_published,
                                created_time,
                            } = post;


                            date = new Date(created_time.split("T")[0]).toLocaleString(
                                language,
                                { day: "numeric", month: "long", year: "numeric" }
                            );
                            
                            if (is_published) {
                                publishPosts(permalink_url, message, full_picture, date);
                            }

                            loadBtn.remove();
                        })
                    })
                    .catch(() => console.log("Ошибка"))
            }
        })
    }
})