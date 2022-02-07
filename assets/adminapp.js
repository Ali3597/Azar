import "./styles/admin/app.css";
let flashs = document.querySelectorAll(".flash");
console.log(flashs);
if (flashs) {
  flashs.forEach((element) => {
    if (element.classList.contains("active")) {
      element.classList.remove("active");
    }
    element.classList.add("active");
    setTimeout(() => {
      element.classList.remove("active");
    }, 2000);
  });
}
