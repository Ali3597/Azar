import "./styles/admin/design.css";

let color = document.querySelector(".bandecolor input");
let bande = document.querySelector(".high-showoff");
color.addEventListener("change", (e) => {
  bande.style.backgroundColor = color.value;
});
