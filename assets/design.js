import "./styles/admin/design.css";

let color = document.querySelector(".bandecolor input");
let bande = document.querySelector(".high-showoff");
color.addEventListener("change", (e) => {
  console.log("ok");
  bande.style.backgroundColor = color.value;
});
