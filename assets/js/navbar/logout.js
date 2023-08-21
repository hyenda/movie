
const logout = () => {
    Swal.fire({
        title: 'Do you want to log out?',
        showCancelButton: true,
        confirmButtonText: 'Yes',
    }).then((result) => {
    /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            // delete user cookie, and redirect him to home if he is on dashboard
            document.cookie = "id=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/movie;";   
            document.cookie = "key=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/movie;";   
            // console.log(window.location.href);
            
            const url = window.location.href
            let currentUrl = url.split('/').at(-1).split('.php')[0]
            window.location = 'http://localhost/movie/index.php'
            // if (currentUrl.toLowerCase() == "dashboard" || currentUrl.toLowerCase() == "list_video" || currentUrl.toLowerCase() == "settings") {
            // }
        } 
    })
}