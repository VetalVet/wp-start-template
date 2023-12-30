// Авторизация
let loginForm = document.querySelector('[data-modal="login"] .modal-form');

loginForm.addEventListener('submit', (e) => {
	e.preventDefault();

	let data = new FormData(loginForm);
	data.append('action', 'authorization');
	data.append('nonce', auth.nonce);

	fetch(auth.url, {
		body: data,
		method: 'POST',
	})
	.then((data) => data.json())
	// .then((data) => console.log(data.status))
	.then((data) => {
		if(data.status == 'success'){
			let lang = document.querySelector('html').getAttribute('lang');
			if(lang == 'ua'){
				window.location.pathname = '/cabinet/';
			} else {
				window.location.pathname = `/${lang}/cabinet/`;
			}
		} else {
			document.querySelector('.login-status').textContent = data.message;
			setTimeout(() => {
				document.querySelector('.login-status').textContent = '';
			}, 3000);
		}
	})
});
// Авторизация