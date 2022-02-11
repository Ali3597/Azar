import "./styles/aboutUs.css";

console.log("voill");
let readMore = document.querySelector(".contentAboutUs");
console.log(readMore.clientHeight);
const affPlus = `Affichez <span>plus</span>`;
if (readMore.offsetHeight > 210) {
  // read more
  let div = document.createElement("div");
  div.classList.add("readMore", "flex");
  div.innerHTML = affPlus;
  document.querySelector(".content").append(div);
  // height
  readMore.classList.add("reel");
  //addeventlistener
  div.addEventListener("click", () => {
    if (readMore.classList.contains("taille")) {
      readMore.classList.remove("taille");
      setTimeout(() => {
        document.querySelector(".readMore span").innerHTML = "plus";
      }, 300);
    } else {
      readMore.classList.add("taille");
      setTimeout(() => {
        document.querySelector(".readMore span").innerHTML = "moins";
      }, 300);
    }
  });
}
//
