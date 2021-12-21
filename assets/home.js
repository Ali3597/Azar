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

// products
jQuery(
  '<div class="quantity-nav"><div class="quantity-button quantity-up">+</div><div class="quantity-button quantity-down">-</div></div>'
).insertAfter(".quantity input");
jQuery(".quantity").each(function () {
  var spinner = jQuery(this),
    input = spinner.find('input[type="number"]'),
    btnUp = spinner.find(".quantity-up"),
    btnDown = spinner.find(".quantity-down"),
    min = input.attr("min"),
    max = input.attr("max");

  btnUp.click(function () {
    var oldValue = parseFloat(input.val());
    if (oldValue >= max) {
      var newVal = oldValue;
    } else {
      var newVal = oldValue + 1;
    }
    spinner.find("input").val(newVal);
    spinner.find("input").trigger("change");
  });

  btnDown.click(function () {
    var oldValue = parseFloat(input.val());
    if (oldValue <= min) {
      var newVal = oldValue;
    } else {
      var newVal = oldValue - 1;
    }
    spinner.find("input").val(newVal);
    spinner.find("input").trigger("change");
  });
});
