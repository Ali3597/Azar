import "./styles/product.css";

import { Carousel } from "./carousel";
import { CarouselTouchPlugin } from "./carousel";

let onReady = function () {
  new Carousel(document.querySelector("#carousel1"), {
    slidesToScroll: 1,
    slidesVisible: 1,
    pagination: true,
    loop: false,
    style: "produit",
  });
};
let affPlus = `


				<p class="flex">Afficher <span>plus</span></p>
				<span>
					<i class="fas fa-arrow-down"></i>
				</span>

		
`;

document.addEventListener("DOMContentLoaded", onReady);

let afficherPlus = document.querySelectorAll(".produit-description");

afficherPlus.forEach((element) => {
  let div = document.createElement("div");
  div.classList.add("afficher-plus", "flex");
  div.innerHTML = affPlus;

  if (element.offsetHeight > 295) {
    element.append(div);
  }
  element.querySelector(".reel").classList.add("long");
  div.addEventListener("click", () => {
    if (element.parentNode.classList.contains("taille")) {
      element.parentNode.classList.remove("taille");
      setTimeout(() => {
        document.querySelector(".afficher-plus span").innerHTML = "plus";
      }, 300);
    } else {
      element.parentNode.classList.add("taille");
      setTimeout(() => {
        document.querySelector(".afficher-plus span").innerHTML = "moins";
      }, 300);
    }
  });
});

//aside
let putAsideThisItem = function (element) {
  let id = element.getAttribute("data-id");

  axios
    .get("/profile/putAsideItem/" + id, {
      headers: { "X-Requested-With": "XMLHttpRequest" },
    })
    .then((response) => {
      popup("Votre produit a bien était mis de coté ");
    })
    .catch((err) => {});
};

window.putAsideThisItem = putAsideThisItem;
