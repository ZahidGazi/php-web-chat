var menu = document.getElementById("menu");
var navCon = document.querySelector(".nav-content");
menu.addEventListener("click", () => {
  navCon.classList.toggle("nav-active");
});
