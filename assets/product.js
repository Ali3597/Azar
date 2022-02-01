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


				<p>Afficher plus</p>
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
  console.log(element.offsetHeight);
  if (element.offsetHeight > 295) {
    element.append(div);
  }
  element.querySelector(".reel").classList.add("long");
  div.addEventListener("click", () => {
    element.parentNode.classList.toggle("taille");
  });
});

//aside
let putAsideThisItem = function (element) {
  let id = element.getAttribute("data-id");
  console.log(id);
  axios
    .get("/putAsideItem/" + id)
    .then((response) => {
      console.log(response.data);
      /// to do flash
    })
    .catch((err) => {
      console.log(err);
    });
};

window.putAsideThisItem = putAsideThisItem;
