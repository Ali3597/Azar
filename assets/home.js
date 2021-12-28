import "./styles/home.css";

import { Carousel } from "./carousel";
import { CarouselTouchPlugin } from "./carousel";

let carousels = document.querySelectorAll(".carouselSelect");

for (let i = 0; i < carousels.length; i++) {
  new Carousel(carousels[i], {
    slidesToScroll: parseInt(carousels[i].getAttribute("data-scroll")),
    style: carousels[i].getAttribute("data-type"),
    slidesVisible: parseInt(carousels[i].getAttribute("data-visible")),
    loop: false,
    pagination: true,
  });
}
