import "./styles/products.css";
import { productJquery } from "./produitQuery";
let getTheTri = function (element) {
  let triDeplier = element.parentNode.querySelector(".tri-bas");
  let triRotate = element.parentNode.querySelector(".tri-haut");
  triDeplier.classList.toggle("active");
  triRotate.classList.toggle("activeSvg");
};

let adaptMark = function (element) {
  adapt(element, "marque");
};

let adaptCategory = function (element) {
  adapt(element, "categorie");
};
let adapt = function (element, table) {
  window.scrollTo({ top: 0, behavior: "smooth" });
  let urlJava = window.location.href;
  let url = new URL(urlJava);
  let pathname = url.pathname;
  let params = new URLSearchParams(url.search);
  if (element.checked) {
    let inputs = element.parentNode.parentNode.querySelectorAll("input");
    inputs.forEach((input) => {
      if (input !== element && input.checked == true) {
        adaptActiveFilter(-1);
        input.checked = false;
      }
    });
    let slug = element.parentNode.getAttribute("data-slug");
    params.set(table, slug);
    adaptActiveFilter(1);
  } else {
    params.delete(table);
    adaptActiveFilter(-1);
  }
  params.delete("page");
  let newUrl = pathname + "?" + params.toString();
  window.history.replaceState("product", "product", newUrl);
  console.log(newUrl);
  axios
    .get(newUrl, {
      headers: { "X-Requested-With": "XMLHttpRequest" },
    })
    .then((response) => {
      let products = document.querySelector(".right-produits");
      products.innerHTML = response.data;
      productJquery();
    })
    .catch((err) => {
      console.log(err);
    });
};

let adaptActiveFilter = function (number) {
  let filtreNumber = document.querySelector(".filtre span");
  let numberFilter = parseInt(filtreNumber.innerHTML);
  let newNumber = numberFilter + number;
  filtreNumber.innerHTML = newNumber;
  if (newNumber > 0 && !filtreNumber.classList.contains("active")) {
    filtreNumber.classList.add("active");
  } else if (newNumber == 0 && filtreNumber.classList.contains("active")) {
    filtreNumber.classList.remove("active");
  }
};
let adaptTri = function (element) {
  window.scrollTo({ top: 0, behavior: "smooth" });
};
window.getTheTri = getTheTri;
window.adaptCategory = adaptCategory;
window.adaptMark = adaptMark;
window.adaptTri = adaptTri;
