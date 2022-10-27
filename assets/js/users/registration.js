window.addEventListener("DOMContentLoaded", () => {
    const registerForm = document.querySelector("#registerform");

    registerForm.addEventListener("submit", (e) => {
        e.preventDefault();

        let data = new FormData(registerForm);
        // registerUser();

        fetch('/wp-admin/admin-ajax.php', {
            method: "POST",
            body: data,
        })
        .then(res => res.text())
        .then(res => console.log(res))
        // .then(res => console.log(res))
        .catch(res => console.log("Ошибка"))
        .finally(console.log("Успех"));

        //     if (result.ok) {
        //         let answer = await result.text();
        //         console.log(answer);
        //     } else {
        //         console.log("Ошибка");
        //     }
        // }
    });
});