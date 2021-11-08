
import './styles/home.css';

import { Carousel } from './carousel';
import { CarouselTouchPlugin } from './carousel';

let carousels = document.querySelectorAll('.carouselSelect')

for (let i = 0 ; i< carousels.length; i++){
    new Carousel(carousels[i], {
        slidesToScroll: carousels[i].getAttribute("data-scroll"),
        slidesVisible:  carousels[i].getAttribute("data-visible"),
        pagination :  carousels[i].getAttribute("data-pagination"),
        loop: false,  
    })

}