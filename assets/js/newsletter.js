// // Подписка на рассылку
// const subForm = document.querySelector(".tnp-subscription form");

// subForm.addEventListener("submit", (e) => {
//     let subFormEmail = document.querySelector(".tnp-email").value;
//     let data = new FormData(subForm);
//     data.append("nonce", uaknewsletter.nonce);
//     data.append("action", "uaknewsletter");

//     if (validateEmail(subFormEmail)) {
//         subscribe(data);
//     } else {
//         console.log("invalid email!");
//     }

//     e.preventDefault();
// });
// // Подписка на рассылку

// async function subscribe(data) {
//     subForm.style.opacity = "0.5";

//     await fetch(uaknewsletter.url, {
//         method: "POST",
//         body: data,
//     })
//         .then((res) => {
//             document.querySelector(".status").innerHTML = res.text();
//             // console.log(res.text());
//         })
//         .catch(() => console.log("error"))
//         .finally(() => (subForm.style.opacity = "1"));
// }


// // Подписка на рассылку
var request;
$(".tnp-subscription form").on("submit", function (event) {
    if (request) {
        request.abort();
    }
    var $form = $(this),
        $inputs = $form.find("input, select, button, textarea"),
        serializedData = $form.serialize();

    request = $.ajax({
        url: uaknewsletter.url,
        type: "post",
        data: {
            action: "uaknewsletter",
            nonce: uaknewsletter.nonce,
            ne: $form.find(".tnp-email").val(), //THIS IS IMPORTANT TO SUBMIT!! ITS REQUIRED BY THE subscribe() METHOD
            data: serializedData,
        },
        beforeSend: function () {
            //disable all field
            $inputs.prop("disabled", true);
            $(".tnp-subscription form").css("opacity", "0.5");
        },
        success: function (response) {
            // если ошибка
            if (response.status == "error") {
                // we have an answer. it will be placed right after our form
                $('.status').html(response.msg);

                setTimeout(() => {
                    $(".status").html("");
                }, 3000);
            } // если всё ок
            else {
                // window.location.hash = "js-gratitude-popup";
            }
        },
        complete: function () {
            //we are done, reenable all fields
            $inputs.prop("disabled", false);
            $(".tnp-subscription form").css("opacity", "1");
            setTimeout(() => {
                $(".status").html("");
            }, 3000);
        },
    });

    event.preventDefault();
});
