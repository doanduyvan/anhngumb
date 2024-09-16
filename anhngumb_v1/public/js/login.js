
function changeAuth(isLogin = 0) {
    const mainSignin = document.getElementById('main-signin');
    const mainSignup = document.getElementById('main-signup');
    if (isLogin == 0) {
        mainSignin.classList.add('active');
        mainSignup.classList.remove('active');
    } else {
        mainSignin.classList.remove('active');
        mainSignup.classList.add('active');
    }

}

function togglePasswordVisibility(event) {
    const targetInputId = event.currentTarget.getAttribute('data-target');
    const targetInput = document.getElementById(targetInputId);

    if (targetInput.type === 'password') {
        targetInput.type = 'text';
        event.currentTarget.classList.add('active');
    } else {
        targetInput.type = 'password';
        event.currentTarget.classList.remove('active');
    }
}
// Add event listener to all eye icons
document.querySelectorAll('.span_eye').forEach(span => {
    span.addEventListener('click', togglePasswordVisibility);
});


const formSignIn = document.querySelector('#main-signin .form');
const formSignUp = document.querySelector('#main-signup .form');

formSignIn.addEventListener('submit', (e) => {
    e.preventDefault();
    const formData = new FormData(formSignIn);
    const email = formData.get('email');
    const password = formData.get('password');

    if (!validateEmail(email)) {
        showNotif('Warning', 'Invalid email', 1);
        return;
    }
    if (!validatePassword(password)) {
        showNotif('Error', 'Password must be between 3 and 20 characters', 2);
        return;
    }
    sendSignIn(email,password);
});

formSignUp.addEventListener('submit', (e) => {
    e.preventDefault();
    const formData = new FormData(formSignUp);
    const email = formData.get('email');
    const password = formData.get('password');
    const confirmpassword = formData.get('confirmpassword');
    if (!validateEmail(email)) {
        showNotif('Warning', 'Invalid email', 1);         
        return;
    }
    if (!validatePassword(password)) {
        notifs[1].textContent = 'Password must be between 3 and 20 characters';
        showNotif('Warning', 'Password must be between 3 and 20 characters', 1);
        return;
    }
    if (password !== confirmpassword) {
        showNotif('Warning', 'Passwords do not match', 1);
        return;
    }
    sendSignUp(email,password);
});

function sendSignUp(email,password){
    fetch('?signup',{
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            email: email,
            password: password
        })
    })
    .then(res => res.json())
    .then(data => {
        console.log(data);
    })
    .catch(err => {
        console.log(err);
    })
}

function sendSignIn(email,password){
    fetch('?signin',{
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            email: email,
            password: password
        })
    })
    .then(res => res.json())
    .then(data => {
        console.log(data);
    })
    .catch(err => {
        console.log(err);
    })
}

function sendSignInGoogle(id_token){
    loading(true);
    fetch('?signin&google',{
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            idToken: id_token
        })
    })
    .then(res => res.json())
    .then(data => {
        loading(false);
        console.log(data);
    })
    .catch(err => {
        loading(false);
        console.log(err);
    })
}

// sendSignInGoogle('123');

function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

function validatePassword(password) {
    if (password.length >= 3 && password.length <= 30) {
        return true;
    }
    return false;
}


function linkGoogle(){
    const clientId = '865532873608-aik1oar7v5gimbu4m84dcl2aj8me92ih.apps.googleusercontent.com';
    const client_Uri = 'http://localhost/anhngumb/anhngumb_v1/';
    const scope = 'openid%20https://www.googleapis.com/auth/userinfo.email%20https://www.googleapis.com/auth/userinfo.profile';
    const nonce = Math.random().toString(36).substring(2); // Tạo nonce ngẫu nhiên
    return  `https://accounts.google.com/o/oauth2/v2/auth?scope=${scope}&response_type=id_token%20token&redirect_uri=${client_Uri}&client_id=${clientId}&nonce=${nonce}`;
}

const btnGoogle = document.querySelectorAll('.btn.google');
btnGoogle.forEach(btn => {
    btn.addEventListener('click',()=>{
        window.location.href = linkGoogle();
    })
})

getTokenGoogle();
function getTokenGoogle(){
    const url = new URLSearchParams(window.location.hash.substring(1));
    const token = url.get('access_token');
    const id_token = url.get('id_token');
    if(id_token){
        sendSignInGoogle(id_token);
    }
}



function afterSignIn(){

}




function showNotif(title, mess, indexType, duration = 1500) {
    let main = document.querySelector('.overllay-notification');
    if (!main) {
        main = document.createElement('div');
        main.classList.add('overllay-notification');
        document.body.appendChild(main);
    }
    const ObjectNoti = [
        {
            type: 'success',
            svg: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>`,
            css: "success",
        },
        {
            type: 'warning',
            svg: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
            </svg>`,
            css: "warning",
        },
        {
            type: 'error',
            svg: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
            </svg>`,
            css: "error",
        }
    ];
    const { svg, css } = ObjectNoti[indexType];
    const boxNoti = document.createElement('div');
    const autoRemoveId = setTimeout(() => {
        main.removeChild(boxNoti);
    }, duration + 300);
    boxNoti.onclick = function (e) {
        if (e.target.closest(".close")) {
            main.removeChild(boxNoti);
            clearTimeout(autoRemoveId);
        }
    };
    boxNoti.classList.add('box-noti', css);
    boxNoti.style.animation = `fadeInNotification 0.3s linear, fadeOutNotification 0.3s linear ${duration}ms forwards`;
    boxNoti.innerHTML = `
    <div class="icon">
    ${svg}
    </div>
    <div class="contents">
    <p class="title">${title}</p>
    <p class="mess">${mess}</p>
    </div>
    <div class="close">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
    stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
    </svg>
    </div>
    `;
    main.appendChild(boxNoti);
}

function loading(load = false){
    let loading = document.querySelector('.status-loading');
    if(loading){
        if(!load){
            loading.remove();
        }
    }else{
        if(load){
            loading = document.createElement('div');
            loading.classList.add('status-loading');
            loading.innerHTML = `<div class="loader"></div>`;
            document.body.appendChild(loading);
        }
    }
}
