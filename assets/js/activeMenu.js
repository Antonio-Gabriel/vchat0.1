const links = document.querySelectorAll(".navbar-nav .nav-item .nav-link");

links.forEach((element) => {
  element.addEventListener("click", () => {
    resetLinks();
    element.classList.add("active");
  });
});

function resetLinks() {
  links.forEach((element) => element.classList.remove("active"));
}
