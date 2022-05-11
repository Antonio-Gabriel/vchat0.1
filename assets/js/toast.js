const button = document.querySelector(".button");
const toast = document.querySelector(".custom-toast");
const closeIcon = document.querySelector(".check");
const progress = document.querySelector(".custom-progress");

function handleShowToastPopup() {
  toast.classList.add("active");
  progress.classList.add("active");

  unShowToastPopup();
}

function unShowToastPopup() {
  setTimeout(() => {
    toast.classList.remove("active");
  }, 5000); // 1s = 1000 miliseconds

  setTimeout(() => {
    progress.classList.remove("active");
  }, 5300);
}

closeIcon.addEventListener("click", () => {
  toast.classList.remove("active");

  setTimeout(() => {
    progress.classList.remove("active");
  }, 300);
});
