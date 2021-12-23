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

document.addEventListener("DOMContentLoaded", onReady);

let afficherPlus = document.querySelector(".afficher-plus");
afficherPlus.addEventListener("click", () => {
  afficherPlus.parentNode.querySelector(".reel").classList.toggle("taille");
});
