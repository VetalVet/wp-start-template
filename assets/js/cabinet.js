window.addEventListener("DOMContentLoaded", () => {

    let userID = cabinetwishlist.user_id;

    let wishlistBtn = document.querySelectorAll(".item-card-v1-del");

    let downloadCpBtn = document.querySelector('.profile-filter-download');



    // Удаление товаров из избранного

    wishlistBtn.forEach((item) => {

        item.addEventListener("click", () => {

            item.closest('article').style.opacity = "0.5";

            let product_ID = item.closest('article').getAttribute('product-ids');



            let data = new FormData();

            data.append("action", "remove_from_wishlist"); // обязательно!

            data.append("nonce", cabinetwishlist.remove_nonce); // защита от взлома

            data.append("user_id", userID);

            data.append("product_id", product_ID);



            fetch(cabinetwishlist.url, {

                body: data,

                method: "POST",

            })

                .then(() => item.closest('article').remove())

                .catch(() => {

                    item.closest('article').style.opacity = "1";

                    console.log('Ошибка! Не удалено');

                })

                .finally(() => item.closest('article').style.opacity = "1");

        });

    });

    // Удаление товаров из избранного





    // Сохранение данных юзера

    let profileForm = document.querySelector(".profile-form");



    profileForm.querySelector("[name='userName']").addEventListener("input", () => {

        profileForm.querySelector("[name='userName']").value = profileForm.querySelector("[name='userName']").value.replace(/[^a-zа-яёЁЇїІіЄєҐґ -]/ig, "");

    });



    profileForm.querySelector("[name='userCountry']").addEventListener("input", () => {

        profileForm.querySelector("[name='userCountry']").value = profileForm.querySelector("[name='userCountry']").value.replace(/[^a-zа-яёЁЇїІіЄєҐґ0-9 -]/ig, "");

    });

    profileForm.querySelector("[name='userCompanyName']").addEventListener("input", () => {

        profileForm.querySelector("[name='userCompanyName']").value = profileForm.querySelector("[name='userCompanyName']").value.replace(/[^a-zа-яёЁЇїІіЄєҐґ0-9 -]/ig, "");

    });

    profileForm.querySelector("[name='userField']").addEventListener("input", () => {

        profileForm.querySelector("[name='userField']").value = profileForm.querySelector("[name='userField']").value.replace(/[^a-zа-яёЁЇїІіЄєҐґ0-9 -]/ig, "");

    });

    profileForm.addEventListener('submit', (e) => {

        e.preventDefault();



        let error = 0;



        const userName = profileForm.querySelector("[name='userName']"),

              userPhone = profileForm.querySelector("[name='userPhone']"),

              userEmail = profileForm.querySelector("[name='userEmail']"),

              userCountry = profileForm.querySelector("[name='userCountry']"),

              userCompanyName = profileForm.querySelector("[name='userCompanyName']"),

              userField = profileForm.querySelector("[name='userField']");

            

        

        // Поле "ФИО"  ввод только букв, ограничить до 50 символов, пробелы ставить можно.

        // + Поле "Номер телефона" - ввод только цифр, на поле должна стоять маска.

        // + Поле "Email" -  Проверка почты по такому макету - text@text.text.

        // Поле "Название компании" - ввод букв и цифр разрешен, символы "!№;%:?*()<>" запретить, ограничить поле вводом до 50 символов

        // Поле "Сфера деятельности" - ввод букв и цифр разрешен, символы "!№;%:?*()<>" запретить, ограничить поле вводом до 50 символов

       

        // Проверка имени

        if (userName.value.length == 0 && userName.value.length > 50) {

            userName.classList.add("error");

            error++;

        } else {

            userName.classList.remove("error");

        }



        // Проверка телефона

        if (userPhone.value.length < 19) {

            userPhone.classList.add("error");

            error++;

        } else {

            userPhone.classList.remove("error");

        }



        // Проверка email

        if (emailTest(userEmail)) {

            userEmail.classList.add("error");

            error++;

        } else {

            userEmail.classList.remove("error");

        }



        // Проверка страны

        if (userCountry.value.length == 0 && userCountry.value.length > 50) {

            userCountry.classList.add("error");

            error++;

        } else {

            userCountry.classList.remove("error");

        }



        // Проверка названия компании

        if(userCompanyName.value.length == 0 && userCompanyName.value.length > 50){

            userCompanyName.classList.add("error");

            error++;

        } else{

            userCompanyName.classList.remove("error");

        }



        // Проверка сферы деятельности

        if (userField.value.length == 0 && userField.value.length > 50) {

            userField.classList.add("error");

            error++;

        } else {

            userField.classList.remove("error");

        }



        if (error === 0) {

            let data = new FormData(profileForm);

            data.append("action", "update_user_data"); // обязательно!

            data.append("nonce", update_user.nonce); // защита от взлома



            fetch(update_user.url, {

                body: data,

                method: "POST",

            })

                .then((data) => data.text())

                // .then((data) => console.log(data))

                .then((data) => document.querySelector('.status').textContent = update_user.success_save_user_data)

                .catch(() => document.querySelector('.status').textContent = update_user.error_save_user_data)

                .finally(() => {

                    profileForm.style.opacity = "1"

                    setTimeout(() => {

                        document.querySelector('.status').textContent = '';

                    }, 5000);

                })

        }

    });

    // Сохранение данных юзера





    // Кастомная маска телефона

    const mask = (selector, pattern) => {

        function createMask(event) {

            let matrix = pattern,

                i = 0,

                def = matrix.replace(/\D/g, ''),

                val = this.value.replace(/\D/g, '');



            if (def.length >= val.length) {

                val = def;

            }

            this.value = matrix.replace(/./g, function(a) {

                return /[_\d]/.test(a) && i < val.length ? val.charAt(i++) : i >= val.length ? '' : a;

            });

        }



        let inputs = document.querySelectorAll(selector);



        inputs.forEach(input => {

            input.addEventListener('input', createMask);

            input.addEventListener('focus', createMask);

            input.addEventListener('blur', createMask);

        });

    };



    mask("[name='userPhone']", '+__ (___) ___ __ __'); 
    mask("[name='userNumber']", '+__ (___) ___ __ __'); 

    // Кастомная маска телефона





    // E-mail валидация

    function emailTest(input) {

        return !/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/.test(input.value);

    }

    // E-mail валидация





    // Выбор товаров в списке избранного

    let chooseAllProductsBtn = document.querySelector('[name="checkAll"]');

    let products = document.querySelectorAll('.item-card-v1-checkbox');



    if(products){

        chooseAllProductsBtn.addEventListener('click', (e) => {

            if(chooseAllProductsBtn.checked){

                products.forEach(product => {

                    product.querySelector('.filter-checkbox-input').checked = true;

                    checkFormCP();

                });

            } else {

                products.forEach(product => {

                    product.querySelector('.filter-checkbox-input').checked = false;

                    checkFormCP();

                });

            }

        });

    

        products.forEach(item => {

            item.addEventListener('click', checkFormCP);

        })

    }



    // Формирование КП и скачивание сформированного pdf-файла

    downloadCpBtn.addEventListener('click', (e) => {
        e.preventDefault();

        if(!downloadCpBtn.classList.contains('disabled') && form_cp.user_role != 'Менеджер'){



            let product_ids = [];

            // let dataCheckedProducts = [];

            document.querySelectorAll('article .filter-checkbox-input:checked').forEach((product, index) => {

                product_ids.push(+product.closest('.item-card-v1').getAttribute('data-id'));

                // dataCheckedProducts.push(index);

            });



            // console.log(dataCheckedProducts);

            downloadCpBtn.style.opacity = '0.5';

            let data = new FormData();

            data.append('action', 'form_cp'); // обязательно!

            data.append('nonce', form_cp.nonce); // защита от взлома

            data.append('client_id', +form_cp.user_id); 

            // data.append('manager_id', +form_cp.manager_id); 

            data.append('product_ids', product_ids); 

            // data.append('checked_products_data', JSON.stringify(form_cp.pdf_data)); 

            data.append('manager', form_cp.manager); 





            // data.append('product_photos', product_ids); 

            

            // data.append('product_id', product_ID); 

    

            fetch(form_cp.url, {

                body: data,

                method: 'POST',

            })

            // .then((data) => console.log(data.text()))

            .then((data) => data.blob())

            .then((blob) => {

                const url = window.URL.createObjectURL(blob);

                const a = document.createElement('a');

                a.style.display = 'none';

                a.href = url;

                // the filename you want

                a.download = 'test.pdf';

                document.body.appendChild(a);

                a.click();

                window.URL.revokeObjectURL(url);

                // or you know, something with better UX...

                console.log('скачано');

            }) 

            .then(() => downloadCpBtn.classList.add('added'))

            .then(() => downloadCpBtn.style.opacity = '1')

        } 
    })

    // Для менеджера
    managerPopupCPForm = document.querySelector('[data-modal="sendcp"] form');

    managerPopupCPForm.querySelector("[name='userName']").addEventListener("input", () => {
        managerPopupCPForm.querySelector("[name='userName']").value = managerPopupCPForm.querySelector("[name='userName']").value.replace(/[^a-zа-яёЁЇїІіЄєҐґ -]/ig, "");
    });

    managerPopupCPForm.querySelector("[name='userPlace']").addEventListener("input", () => {
        managerPopupCPForm.querySelector("[name='userPlace']").value = managerPopupCPForm.querySelector("[name='userPlace']").value.replace(/[^a-zа-яёЁЇїІіЄєҐґ0-9 -]/ig, "");
    });

    managerPopupCPForm.querySelector("[name='userCompany']").addEventListener("input", () => {
        managerPopupCPForm.querySelector("[name='userCompany']").value = managerPopupCPForm.querySelector("[name='userCompany']").value.replace(/[^a-zа-яёЁЇїІіЄєҐґ0-9 -]/ig, "");
    });

    managerPopupCPForm.querySelector("[name='userBrand']").addEventListener("input", () => {
        managerPopupCPForm.querySelector("[name='userBrand']").value = managerPopupCPForm.querySelector("[name='userBrand']").value.replace(/[^a-zа-яёЁЇїІіЄєҐґ0-9 -]/ig, "");
    });

    managerPopupCPForm.addEventListener('submit', (e) => {
        e.preventDefault();
        let error = 0;

        const userName = managerPopupCPForm.querySelector("[name='userName']"),
              userPhone = managerPopupCPForm.querySelector("[name='userNumber']"),
              userEmail = managerPopupCPForm.querySelector("[name='userEmail']"),
              userPlace = managerPopupCPForm.querySelector("[name='userPlace']"),
              userCompanyName = managerPopupCPForm.querySelector("[name='userCompany']");

        // Проверка имени
        if (userName.value.length == 0 && userName.value.length > 50) {
            userName.classList.add("error");
            error++;
        } else {
            userName.classList.remove("error");
        }

        // Проверка телефона
        if (userPhone.value.length < 19) {
            userPhone.classList.add("error");
            error++;
        } else {
            userPhone.classList.remove("error");
        }

        // Проверка email
        if (emailTest(userEmail)) {
            userEmail.classList.add("error");
            error++;
        } else {
            userEmail.classList.remove("error");
        }

        // Проверка страны
        if (userPlace.value.length == 0 && userPlace.value.length > 50) {
            userPlace.classList.add("error");
            error++;
        } else {
            userPlace.classList.remove("error");
        }

        // Проверка названия компании
        if(userCompanyName.value.length == 0 && userCompanyName.value.length > 50){
            userCompanyName.classList.add("error");
            error++;
        } else{
            userCompanyName.classList.remove("error");
        }


        if(error === 0){
            let product_ids = [];
            document.querySelectorAll('article .filter-checkbox-input:checked').forEach((product, index) => {
                product_ids.push(+product.closest('.item-card-v1').getAttribute('data-id'));
            });

            downloadCpBtn.style.opacity = '0.5';
            let data = new FormData(managerPopupCPForm);
            data.append('action', 'form_cp'); // обязательно!
            data.append('nonce', form_cp.nonce); // защита от взлома
            data.append('client_id', +form_cp.user_id);
            data.append('product_ids', product_ids); 
            data.append('manager', form_cp.manager_name); 
            data.append('user_role', form_cp.user_role); 


            fetch(form_cp.url, {
                body: data,
                method: 'POST',
            })
            .then((data) => data.blob())
            .then((blob) => {
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.style.display = 'none';
                a.href = url;

                // the filename you want
                a.download = 'test.pdf';
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);

                // or you know, something with better UX...
                console.log('скачано');
            }) 
            .then(() => downloadCpBtn.classList.add('added'))
            .then(() => downloadCpBtn.style.opacity = '1')
        }
    })
    // Формирование КП и скачивание сформированного pdf-файла



    function checkFormCP(){

        let checkedProducts = document.querySelectorAll('.item-card-v1-checkbox input:checked');

        if(checkedProducts.length){

            downloadCpBtn.classList.remove('disabled');

            countCheckedProducts();

        } else {

            downloadCpBtn.classList.add('disabled');

            countCheckedProducts();



        }

    }



    function countCheckedProducts(){

        document.querySelector('.profile-filter-checked-val').textContent = document.querySelectorAll('.item-card-v1-checkbox input:checked').length;

    }

    // Выбор товаров в списке избранного

    

});