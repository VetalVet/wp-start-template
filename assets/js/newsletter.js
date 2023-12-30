// Подписка на рассылку
const subForm = document.querySelectorAll(".");

subForm.forEach(form => {
    form.addEventListener("submit", (e) => {
        e.preventDefault();

        let subFormEmail = form.querySelector(".tnp-email").value;
        let data = new FormData(form);
        data.append("nonce", newsletter.nonce);
        data.append("action", "newsletter");

        if (validateEmail(subFormEmail)) {
            subscribe(data);
        } else {
            console.log("invalid email!");
        }
    });

    async function subscribe(data) {
        form.style.opacity = "0.5";
    
        await fetch(newsletter.url, {
            method: "POST",
            body: data,
        })
            .then((res) => {
                // document.querySelector(".status").innerHTML = res.text();
                console.log('Успешно');
            })
            .catch(() => console.log("error"))
            .finally(() => (form.style.opacity = "1"));
    }
})
// Подписка на рассылку

function validateEmail(email) {
    const re =
        /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}