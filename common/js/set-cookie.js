window.addEventListener('load', () => {
    const loginId = document.querySelector('.form-login');
    const userPass = document.querySelector('.form-pass');

    const cookies = document.cookie.split(';');

    for (let i = 0; i < cookies.length; i++) {
        let cookie = cookies[i].split('=');
        if (cookie[0] === 'login_id' || cookie[0] === ' login_id') {
            loginId.value = cookie[1];
        } else if (cookie[0] === ' user_pass' || cookie[0] === 'user_pass') {
            userPass.value = cookie[1];
        }
    }
});
