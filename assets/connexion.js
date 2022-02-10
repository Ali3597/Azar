import "./styles/connexion.css";
console.log("papa");
let flashs = document.querySelectorAll(".flash");
if (flashs) {
  console.log("heheheh");
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
