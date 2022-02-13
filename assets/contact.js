import "./styles/contact.css";
let color = document.querySelector(".contact").getAttribute("data-color");
let loader = `<div id="ctn">
<div style=" border-top: 5px solid ${color}; "  id="loader"></div>
</div>`;
let activeLoader = function () {
  let toFill = document.querySelector(".toFill");
  toFill.innerHTML = loader;
};
window.activeLoader = activeLoader;
