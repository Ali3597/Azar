import "./styles/basket.css";

let changeQuantitydefaults = document.querySelectorAll(".changeQuantity");
for (let i = 0; i < changeQuantitydefaults.length; i++) {
  changeQuantitydefaults[i].addEventListener("click", (e) => {
    e.stopPropagation();
  });
}

let DeplierDefault = document.querySelectorAll(".quantityBasket");

for (let i = 0; i < DeplierDefault.length; i++) {
  DeplierDefault[i].addEventListener("click", (e) => {
    e.stopPropagation();
  });
}

let numbersItem = document.querySelectorAll("#number");

for (let i = 0; i < numbersItem.length; i++) {
  if (parseInt(numbersItem[i].innerHTML) < 10) {
    let toactivate =
      numbersItem[i].parentNode.parentNode.querySelector(".quantityBasket");
    toactivate.classList.add("active");
    let nbr = toactivate.parentNode.getAttribute("data-nbr");
    let listQuantity = toactivate.querySelectorAll(".changeQuantity p");
    listQuantity[nbr].classList.add("active");
  } else {
    numbersItem[i].parentNode.parentNode
      .querySelector(".inputquantity")
      .classList.add("active");
  }
}

let changeBasketNumber = function (number) {
  let numberElement = document.querySelector(".number_panier_header");

  let originalNumber = parseInt(numberElement.innerHTML);

  let newNumber = originalNumber + parseInt(number);

  numberElement.innerHTML = newNumber;
};

let deplierQuantity = function (element) {
  let depliant = element.querySelector(".changeQuantity");
  if (!depliant.classList.contains("active")) {
    depliant.classList.add("active");
  }
};
let adjustQuantity = function (nbr, element) {
  element.innerHTML = nbr;
};

let closeDepliant = function (element) {
  let depliant = element.querySelector(".changeQuantity");
  depliant.classList.remove("active");
};

let changeQuantity = function (element) {
  let orginalNbr = parseInt(
    element.parentNode.parentNode.parentNode.querySelector("#number").innerHTML
  );
  let id =
    element.parentNode.parentNode.parentNode.parentNode.parentNode.getAttribute(
      "data-id"
    );

  let nbr = parseInt(element.innerHTML);
  let listSelect = element.parentNode.querySelectorAll("p");
  listSelect[orginalNbr].classList.remove("active");
  closeDepliant(element.parentNode.parentNode.parentNode.parentNode);
  if (nbr == 10) {
    activeInputBasket(element);
  } else {
    listSelect[nbr].classList.add("active");
    element.parentNode.parentNode.parentNode.setAttribute("data-nbr", nbr);
    let nbrProducts = nbr - orginalNbr;
    changeBasketNumber(nbrProducts);

    if (nbr == 0) {
      deleteItem(element);
    }
    adjustQuantity(
      nbr,
      element.parentNode.parentNode.parentNode.querySelector("#number")
    );
    axios
      .post("/panier/add/" + id, { nbrProducts })
      .then((response) => {
        console.log(response.data["nbr"]);
      })
      .catch((err) => {
        console.log(err);
      });
  }
};

let activeInputBasket = function (element) {
  let selectItem =
    element.parentNode.parentNode.parentNode.querySelector(".quantityBasket");
  selectItem.classList.remove("active");
  let inputItem =
    element.parentNode.parentNode.parentNode.querySelector(".inputquantity");
  inputItem.classList.add("active");
  inputItem.focus();
  inputItem.dispatchEvent(new Event("input"));
  inputItem.value =
    element.parentNode.parentNode.parentNode.getAttribute("data-nbr");
};

let deleteItem = function (element) {
  element.parentNode.parentNode.parentNode.parentNode.parentNode.remove();
};

window.addEventListener("click", () => {
  let items = document.querySelectorAll(".changeQuantity");
  if (items !== null) {
    for (let i = 0; i < items.length; i++) {
      if (items[i].classList.contains("active")) {
        items[i].classList.remove("active");
      }
    }
  }
});

let activeUpdateItesmBasket = function (element) {
  let update = element.parentNode.querySelector(".update");
  if (!update.classList.contains("active")) {
    update.classList.add("active");
  }
};

let unactiveUpdateItesmBasket = function (element) {
  let update = element.parentNode.querySelector(".update");
  if (update.classList.contains("active")) {
    update.classList.remove("active");
  }
};

let typeItemBasket = function (element) {
  let str = element.value.toString();
  if (element.value.length == 4) {
    element.value = str.substring(0, str.length - 1);
  } else if (
    element.value.length == 2 &&
    str.substring(0, str.length - 1) == "0"
  ) {
    element.value = str.substring(1, str.length);
  } else if (element.value.length == 0) {
    unactiveUpdateItesmBasket(element);
  } else if (element.value.length == 1) {
    activeUpdateItesmBasket(element);
  }
};

let updateTheInput = function (element) {
  let newNumber = parseInt(
    element.parentNode.querySelector(".inputquantity").value
  );
  let originalNumber = element.parentNode.getAttribute("data-nbr");
  let nbrProducts = newNumber - originalNumber;
  let id = element.parentNode.parentNode.parentNode.getAttribute("data-id");
  element.parentNode.setAttribute("data-nbr", newNumber);
  element.classList.remove("active");
  if (newNumber < 10) {
    activeSelectBasket(element);
  }
  changeBasketNumber(nbrProducts);

  axios
    .post("/panier/add/" + id, { nbrProducts })
    .then((response) => {
      console.log(response.data["nbr"]);
    })
    .catch((err) => {
      console.log(err);
    });
};

let activeSelectBasket = function (element) {
  element.parentNode.querySelector(".inputquantity").classList.remove("active");
  let nbr = element.parentNode.getAttribute("data-nbr");

  let select = element.parentNode.parentNode.querySelector(".quantityBasket");
  select.classList.add("active");
  let selectChoices = select.querySelectorAll(".changeQuantity p");
  selectChoices[nbr].classList.add("active");
  select.querySelector("#number").innerHTML = nbr;
};

let deleteThisItem = function (element) {
  let nbr = element.parentNode.getAttribute("data-nbr");
  let nbrProducts = -nbr;
  let id = element.parentNode.parentNode.parentNode.getAttribute("data-id");
  element.parentNode.parentNode.parentNode.remove();
  axios
    .post("/panier/add/" + id, { nbrProducts })
    .then((response) => {
      console.log(response.data["nbr"]);
    })
    .catch((err) => {
      console.log(err);
    });
};

window.activeUpdateItesmBasket = activeUpdateItesmBasket;
window.typeItemBasket = typeItemBasket;
window.updateTheInput = updateTheInput;
window.deleteThisItem = deleteThisItem;
window.changeQuantity = changeQuantity;
window.deplierQuantity = deplierQuantity;
