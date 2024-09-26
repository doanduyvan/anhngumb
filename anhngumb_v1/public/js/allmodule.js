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