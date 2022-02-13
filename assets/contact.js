import "./styles/contact.css";
let color = document.querySelector(".contact").getAttribute("data-color");
let loader = `<div id="ctn">
<div style=" border-top: 3px solid ${color}; "  id="loader"></div>
</div>`;
console.log("hello");
let activeLoader = function () {
  let toFill = document.querySelector(".toFill");
  toFill.innerHTML = loader;
};
window.activeLoader = activeLoader;
