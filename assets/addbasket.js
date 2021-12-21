let addBasket = function (element) {
  let idProduct = element.getAttribute("data-id");
  let nbrProducts = element.parentNode.querySelector(
    ".surquantity input "
  ).value;
  let nameProduct = element.getAttribute("data-name");
  console.log("anis");
  changeBasketNumber(nbrProducts);
  axios
    .post("/panier/add/" + idProduct, { nbrProducts })
    .then((response) => {
      console.log(response.data["nbr"]);
    })
    .catch((err) => {
      console.log(err);
    });
};

let changeBasketNumber = function (number) {
  let numberElement = document.querySelector(".number_panier_header");
  let originalNumber = parseInt(numberElement.innerHTML);

  let newNumber = originalNumber + parseInt(number);
  numberElement.innerHTML = newNumber;
};

window.addBasket = addBasket;
