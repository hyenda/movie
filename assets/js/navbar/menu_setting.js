const menu_user = document.querySelector(".sub-menu .menu-user");
const btn_menu_user = document.querySelector(".sidebar-right .profile");

btn_menu_user.addEventListener("click", function () {
  if (menu_user.style.display == "none" || menu_user.style.display == "") {
    menu_user.style.display = "block";
  } else {
    menu_user.style.display = "none";
  }
});
