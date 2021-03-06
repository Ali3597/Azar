import "./styles/basket.css";
let color = document.querySelector(".content").getAttribute("data-color");
let loader = `<div id="ctn">
<div style=" border-top: 10px solid ${color}; "  id="loader"></div>
</div>`;
let loaderValid = `<div >
<div style=" border-top: 5px solid ${color}; "  id="loaderValid"></div>
</div>`;


let startBasket = function () {
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
};
startBasket();
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
      .post(
        "/profile/panier/add/" + id,
        { nbrProducts },
        {
          headers: { "X-Requested-With": "XMLHttpRequest" },
        }
      )
      .then((response) => {})
      .catch((err) => {});
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
  element.parentNode.parentNode.parentNode.parentNode.parentNode.style.opacity =
    "0";
  window.setTimeout(function () {
    element.parentNode.parentNode.parentNode.parentNode.parentNode.remove();
  }, 300);
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
    .post(
      "/profile/panier/add/" + id,
      { nbrProducts },
      {
        headers: { "X-Requested-With": "XMLHttpRequest" },
      }
    )
    .then((response) => {})
    .catch((err) => {
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

  changeBasketNumber(nbrProducts);

  element.parentNode.parentNode.parentNode.style.opacity = "0";
  window.setTimeout(function () {
    element.parentNode.parentNode.parentNode.remove();
  }, 100);
  axios
    .post(
      "/profile/panier/add/" + id,
      { nbrProducts },
      {
        headers: { "X-Requested-With": "XMLHttpRequest" },
      }
    )
    .then((response) => {
      let elements = document.querySelectorAll(".basketItem");
      if (elements.length == 0) {
        fillEmptyLeft();
        fillEmptyButton();
      }
    })
    .catch((err) => {});
};

let goToAsideItems = function () {
  activeAndInactiveItem(1);
  activeLoader();
  ajaxAside();
};
let goToBasketItems = function () {
  activeAndInactiveItem(0);
  activeLoader();
  ajaxBasket();
};
let activeLoader = function () {
  let basketList = document.querySelectorAll(".toFill");
  basketList.forEach((element) => {
    if (!element.classList.contains("none")) {
      element.innerHTML = loader;
    }
  });
};

let activeAndInactiveItem = function (number) {
  let elementsToInactive = document.querySelectorAll(".active");
  elementsToInactive.forEach((element) => {
    element.classList.remove("active");
  });
  let items = document.querySelectorAll(".ensemble_onglet");

  items[number].querySelector("i").classList.add("active");
  items[number].querySelector(".bordure_panier").classList.add("active");
};

let insertAfterAjax = function (toInsert) {
  let container = document.querySelector(".content");
  container.innerHTML = toInsert;
};
let ajaxBasket = function () {
  axios
    .get("/profile/panierAjaxBasket", {
      headers: { "X-Requested-With": "XMLHttpRequest" },
    })
    .then((response) => {
      insertAfterAjax(response.data);
      startBasket();
    })
    .catch((err) => {});
};
let ajaxAside = function () {
  axios
    .get("/profile/panierAjaxAside", {
      headers: { "X-Requested-With": "XMLHttpRequest" },
    })
    .then((response) => {
      insertAfterAjax(response.data);
    })
    .catch((err) => {});
};
let addToBasketFromAside = function (element) {
  let id = element.parentNode.parentNode.parentNode.getAttribute("data-id");
  let nbrProducts = 1;
  axios
    .post(
      "/profile/panier/add/" + id,
      { nbrProducts },
      {
        headers: { "X-Requested-With": "XMLHttpRequest" },
      }
    )
    .then((response) => {
      goToBasketItems();
      changeBasketNumber(1);
    })
    .catch((err) => {});
};

let deleteFromAside = function (element) {
  let elements = document.querySelectorAll(".basketItem");
  if (elements.length == 1) {
    fillEmptyLeft();
    fillEmptyButton();
  }
  let id = element.parentNode.parentNode.parentNode.getAttribute("data-id");
  element.parentNode.parentNode.parentNode.style.opacity = "0";

  window.setTimeout(function () {
    axios
      .get("/profile/aside/delete/" + id, {
        headers: { "X-Requested-With": "XMLHttpRequest" },
      })
      .then((response) => {
        element.parentNode.parentNode.parentNode.remove();
      })
      .catch((err) => {});
  }, 300);
};

let putAsideThisItem = function (element) {
  let id = element.parentNode.parentNode.parentNode.getAttribute("data-id");

  axios
    .get("/profile/putAsideItem/" + id, {
      headers: { "X-Requested-With": "XMLHttpRequest" },
    })
    .then((response) => {
      popup(
        "Ce produit a bien ??t?? rajout?? a votre liste de souhait",
        "success"
      );
    })
    .catch((err) => {});
};

let fillEmptyLeft = function () {
  let basketList = document.querySelector(".basketlist");
  let vide = document.querySelector(".panier_vide");

  basketList.classList.add("none");
  vide.classList.remove("none");
};

let fillEmptyButton = function () {
  let valid = document.querySelector(".validB");
  let noValid = document.querySelector(".novalidB");
  valid.classList.add("none");
  noValid.classList.remove("none");
};

let activeLoaderValid = function () {
  let toFill = document.querySelector(".toFillLoaderValid");
  toFill.innerHTML = loaderValid;
};
window.putAsideThisItem = putAsideThisItem;
window.fillEmptyButton = fillEmptyButton;
window.fillEmptyLeft = fillEmptyLeft;
window.activeLoaderValid = activeLoaderValid;
window.deleteFromAside = deleteFromAside;
window.addToBasketFromAside = addToBasketFromAside;
window.goToBasketItems = goToBasketItems;
window.goToAsideItems = goToAsideItems;
window.activeUpdateItesmBasket = activeUpdateItesmBasket;
window.typeItemBasket = typeItemBasket;
window.updateTheInput = updateTheInput;
window.deleteThisItem = deleteThisItem;
window.changeQuantity = changeQuantity;
window.deplierQuantity = deplierQuantity;
