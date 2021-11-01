import "./styles/admin/design.css";


let Sortable = function (element, scrollable,hop=null) {
  this.element = element;
  let self = this;
  if (scrollable == null) {
    scrollable = document.body;
  }
  this.scrollable = scrollable;
  this.items = this.element.querySelectorAll(this.element.dataset.sortable);
  let rect = this.items[0].getBoundingClientRect();
  this.item_width = Math.floor(rect.width);
  this.item_height = Math.floor(rect.height);
  this.cols = Math.floor(this.element.offsetWidth / this.item_width);
  if(hop != null){
    element.style.height= this.item_height * this.items.length +"px"
  }
  for (let i = 0; i < this.items.length; i++) {
    let item = this.items[i];
    item.style.position = "absolute";
    item.style.top = "0px";
    item.style.lef = "0px";
    this.moveItem(item, item.dataset.position);
  }
  interact(this.element.dataset.sortable, {
    context: this.element,
  })
    .draggable({
      inertia: false,
      manualStart: false,
      autoScroll: {
        container: scrollable,
        margin: 150,
        speed: 600,
      },
      onmove: function (e) {
        self.move(e);
      },
    })
    .on("dragstart", function (e) {
      let r = e.target.getBoundingClientRect();
      e.target.classList.add("is-dragged");
      self.startPosition = e.target.dataset.position;
      self.offset = {
        x: e.clientX - r.left,
        y: e.clientY - r.top,
      };
      self.scrollTopStart = self.scrollable.scrollTop;
    })
    .on("dragend", function (e) {
      e.target.classList.remove("is-dragged");
      self.moveItem(e.target, e.target.dataset.position);
    });
};
Sortable.prototype.move = function (e) {
  let p = this.getXY(this.startPosition);
  let x = p.x + e.clientX - e.clientX0;
  let y =
    p.y +
    e.clientY -
    e.clientY0 +
    this.scrollable.scrollTop -
    this.scrollTopStart;
  e.target.style.transform = "translate3D(" + x + "px," + y + "px,0)";
  let oldPosition = e.target.dataset.position;
  let newPosition = this.guessPosition(x + this.offset.x, y + this.offset.y);
  if (oldPosition != newPosition) {
    this.swap(oldPosition, newPosition);
    e.target.dataset.position = newPosition;
  }
  this.guessPosition(x, y);
};

Sortable.prototype.getXY = function (position) {
  let x = this.item_width * (position % this.cols);
  let y = this.item_height * Math.floor(position / this.cols);
  return {
    x: x,
    y: y,
  };
};

Sortable.prototype.guessPosition = function (x, y) {
  let col = Math.floor(x / this.item_width);
  if (col >= this.cols) {
    col = this.cols - 1;
  }
  if (col <= 0) {
    col = 0;
  }
  let row = Math.floor(y / this.item_height);
  if (row <= 0) {
    row = 0;
  }
  let position = col + row * this.cols;
  if (position >= this.items.length) {
    return this.items.length - 1;
  }
  return position;
};
Sortable.prototype.swap = function (start, end) {
  for (let i = 0; i < this.items.length; i++) {
    let item = this.items[i];
    if (!item.classList.contains("is-dragged")) {
      let position = parseInt(item.dataset.position, 10);
      if (position >= end && position < start && end < start) {
        this.moveItem(item, position + 1);
      } else if (position <= end && position > start && start < end) {
        this.moveItem(item, position - 1);
      }
    }
  }
};
Sortable.prototype.moveItem = function (item, position) {
  let p = this.getXY(position);
  item.style.transform = "translate3D(" + p.x + "px," + p.y + "px, 0)";
  item.dataset.position = position;
};

let toSort = document.querySelectorAll(".elements");
for (let i = 0; i < toSort.length; i++) {
  new Sortable(toSort[i], toSort[i]);
}

let toSortBandes = document.querySelector(".bandes")
new Sortable(toSortBandes,toSortBandes,true)

// let sortable = new Sortable(document.querySelector(".bandes"),document.querySelector(".content"));
let createDivWithClass = function (className) {
  let div = document.createElement("div");
  div.setAttribute("class", className);
  return div;
};

let choice = `<div onclick="stopNewBande(this)" class="cross" >
<i class="fas fa-times"></i>
</div>
<select>
<option value="">--Choisis un nouveau type de bande--</option>
<option value="">Produit</option>
<option value="">Promo</option>
<option value="">Article</option>
<option value="">Category</option>
<option value="">Category Titre</option>
<option value="">Marque</option>
</select>
<button> Valider</button>`
let plus = `
<i class="fas fa-2x fa-plus"></i>
`
let addBande = function (element) {
 let parent = element.parentNode
  let div = createDivWithClass("selectNewBande");
  div.innerHTML = choice;
  element.remove()
  parent.appendChild(div);
};

let stopNewBande = function(element) {
  console.log(element.parentNode)
  let parent = element.parentNode.parentNode
  let div = createDivWithClass("more");
  div.innerHTML = plus;
  div.onclick= function(){addBande(this)}
  div.classList.add('more')
  element.parentNode.remove()
  parent.appendChild(div);
}
let ChooseType = function () {
  let choose = document.querySelector(".choose");
  console.log(choose);
  let mene = choose.querySelector(".mene");
  console.log(mene.value);
};

let fillSelect = function (elementToFill, array, option) {
  elementToFill.innerHTML = "";
  let defaults = document.createElement("option");
  defaults.value = " ";
  defaults.innerHTML = option;
  elementToFill.appendChild(defaults);
  array.forEach((element) => {
    let opt = document.createElement("option");
    opt.value = element.id;
    opt.innerHTML = element.name;

    if (element.filename != null) {
      console.log("il ya un filenamee");
      opt.setAttribute("filename", element.filename);
    }
    elementToFill.appendChild(opt);
  });
};

let insertAfter = function (newNode, existingNode) {
  existingNode.parentNode.insertBefore(newNode, existingNode.nextSibling);
};

let produitSelects = `<div  class="selectNewProduct">
<select onchange="ChangeProduitOnCategoryHigh(this) "  id="highCategory">
  <option value="">--Choisis une Haute categorie--</option>
</select>
    <select onchange="ChangeProduitOnCategoryLow(this) "  id="lowCategory">
  <option  value="">--Choisis une sous categorie--</option>
</select>
    <select id="produit">
  <option value="">--Choisis Un Produit--</option>
</select>
    
</div>
<button onclick="addThisProduct(this)">Ajoutez ce nouveau produit a la bande</button>`;

let newproduit = function (element) {
  let div = element.parentNode;
  axios
    .get("/admin/getHighCategories")
    .then((response) => {
      console.log(response.data);
      div.innerHTML = produitSelects;
      fillSelect(
        div.querySelector("#highCategory"),
        response.data.categories,
        "--Choisis une Haute categorie--"
      );
    })
    .catch((err) => {
      console.log(err);
    });
};

let ChangeProduitOnCategoryHigh = function (element) {
  let value = element.value;
  let div = element.parentNode;
  axios
    .post("/admin/getLowCategories", { value })
    .then((response) => {
      console.log(response.data);
      fillSelect(
        div.querySelector("#lowCategory"),
        response.data.categories,
        "--Choisis une sous categorie--"
      );
      fillSelect(div.querySelector("#produit"), [], "--Choisis un produit--");
    })
    .catch((err) => {
      console.log(err);
    });
};

let ChangeProduitOnCategoryLow = function (element) {
  let value = element.value;
  console.log(value);
  let div = element.parentNode;
  axios
    .post("/admin/getProducts", { value })
    .then((response) => {
      console.log(response.data);
      fillSelect(
        div.querySelector("#produit"),
        response.data.categories,
        "--Choisis un produit--"
      );
    })
    .catch((err) => {
      console.log(err);
    });
};

let addThisProduct = function (element) {
  // console.log(element.parentNode.querySelector("#produit").selectedOptions[0])
  let id = element.parentNode.querySelector("#produit").value;
  let subCategoryName =
    element.parentNode.querySelector("#lowCategory").selectedOptions[0]
      .innerHTML;
  let productName =
    element.parentNode.querySelector("#produit").selectedOptions[0].innerHTML;
  let filename = element.parentNode
    .querySelector("#produit")
    .selectedOptions[0].getAttribute("filename");
  console.log(element.parentNode.parentNode.querySelector(".elements"));
  let toInsertAfter =
    element.parentNode.parentNode.querySelector(".subdetails");
  let contenant = element.parentNode.parentNode
    .querySelector(".elements")
    .cloneNode(true);

  element.parentNode.parentNode.querySelector(".elements").remove();
  let elementsNumber = contenant.querySelectorAll(".element").length;
  console.log(contenant.querySelectorAll(".elements"));
  console.log(elementsNumber);
  let div = createDivWithClass("element");
  div.setAttribute("data-position", elementsNumber);
  div.setAttribute("data-id", id);
  let img = document.createElement("img");
  img.src = "/images/properties/" + filename;
  img.style.width = "80%";
  img.style.height = "80%";
  div.appendChild(img);
  let p1 = document.createElement("p");
  p1.innerHTML = productName;
  div.appendChild(p1);
  let p2 = document.createElement("p");
  p2.innerHTML = subCategoryName;
  div.appendChild(p2);
  console.log(div);
  contenant.appendChild(div);

  insertAfter(contenant, toInsertAfter);
  new Sortable(contenant, contenant);
  // element.parentNode.parentNode.appendChild(contenant)
  // element.parentNode.parentNode.querySelector(".elements").innerHTML = contenant.innerHTML
};

let removeElement = function (element) {
  console.log(element)
  let myElementParent = element.parentNode.parentNode;
  let toInsertAfter =
    element.parentNode.parentNode.parentNode.querySelector(".subdetails");
  element.parentNode.remove();
  let contenant = myElementParent.cloneNode(true);
  myElementParent.remove();
  let myElements = contenant.querySelectorAll(".element");
  if (myElements.length >0) {
    for (let i = 0; i < myElements.length; i++) {
      myElements[i].setAttribute("data-position", i);
    }

    insertAfter(contenant, toInsertAfter);
    new Sortable(contenant, contenant);
  }else {

    //TODOOOOOO delete bande
  }
};

let deleteBande = function (element) {
  console.log(element.parentNode)
  let myElementParent = element.parentNode.parentNode;
  let toInsertAfter = myElementParent.parentNode.querySelector("h1");
    element.parentNode.remove();
    let contenant = myElementParent.cloneNode(true);
    myElementParent.remove();
    let myElements = contenant.querySelectorAll(".bande");
    if (myElements.length >0) {
      for (let i = 0; i < myElements.length; i++) {
        myElements[i].setAttribute("data-position", i);
      }
      insertAfter(contenant, toInsertAfter);
      new Sortable(contenant, contenant);
    }else {
  
      //TODOOOOOO delete bande
    }
}


window.deleteBande = deleteBande
window.stopNewBande = stopNewBande
window.addBande = addBande
window.removeElement = removeElement;
window.addThisProduct = addThisProduct;
window.ChangeProduitOnCategoryHigh = ChangeProduitOnCategoryHigh;
window.ChangeProduitOnCategoryLow = ChangeProduitOnCategoryLow;
window.newproduit = newproduit;
window.ChooseType = ChooseType;
