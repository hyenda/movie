let i = 0;
document.querySelectorAll('#menu-link div').forEach(element => {
    if (element.classList.contains('selected-menu')) {
        element.classList.remove('selected-menu')
        i = 0
    }else {
        i = 1
    }
    const url = window.location.href
    let currentUrl = url.split('/').at(-1).split('.php')[0]
    console.log(currentUrl.toLowerCase());
    if (currentUrl.toLowerCase() == "dashboard") {
        document.querySelector('.menu-dashboard .dashboard').classList.add('selected-menu')
    }else if(currentUrl.toLowerCase() == "list_video") {
        document.querySelector('.menu-dashboard .list-video').classList.add('selected-menu')
    }
});