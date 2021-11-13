import "./styles/admin/bande.css";

let Sortable = function (element, scrollable, hop = null) {
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
  if (hop != null) {
    element.style.height = this.item_height * this.items.length + "px";
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

let toSortBandes = document.querySelector(".bandes");
new Sortable(toSortBandes,  toSortBandes, true);
let createDivWithClass = function (className) {
  let div = document.createElement("div");
  div.setAttribute("class", className);
  return div;
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
let cross = `
 <i class="fas fa-times"></i>
 `;
let produitSelects = `<div  class="selectNewElement">
<select onchange="ChangeProduitOnCategoryHigh(this) "  id="highCategory">
  <option value="">--Choisis une Haute categorie--</option>
</select>
    <select onchange="ChangeProduitOnCategoryLow(this) "  id="lowCategory">
  <option  value="">--Choisis une sous categorie--</option>
</select>
    <select id="element">
  <option value="">--Choisis Un Produit--</option>
</select>
    
</div>
<button onclick="addThisElement(this,'produit')">Ajoutez ce nouveau produit a la bande</button>`;

let produitAddNew = `<button onclick="newproduit(this)">Rajoutez une nouveau produit</button>`;

let articleSelects = `<div  class="selectNewElement">
<select  id="element">
  <option value="">--Choisis un article--</option>
  </select>
</div>
<button onclick="addThisElement(this,'article')">Ajoutez ce nouveau article la bande</button>`;

let articleAddNew = `<button onclick="newarticle(this)">Rajoutez une nouveau article</button>`;

let marqueSelects = `<div  class="selectNewElement">
<select  id="element">
  <option value="">--Choisis un article--</option>
  </select>
</div>
<button onclick="addThisElement(this,'marque')">Ajoutez ce nouveau article la bande</button>`;

let marqueAddNew = `<button onclick="newmarque(this)">Rajoutez une nouvelle marque</button>`;

let categorySelects = `<div  class="selectNewElement">
<select  id="element">
  <option value="">--Choisis une categorie--</option>
  </select>
</div>
<button onclick="addThisElement(this,'category')">Ajoutez ce nouvelle categorie</button>`;

let categoryAddNew = `<button onclick="newcategory(this)">Rajoutez une nouvelle category</button>`;

let promoSelects = `<div  class="selectNewElement">
<select  id="element">
  <option value="">--Choisis une promo--</option>
  </select>
</div>
<button onclick="addThisElement(this,'promo')">Ajoutez ce nouvelle promo</button>`;

let promoAddNew = `<button onclick="newpromo(this)">Rajoutez une nouvelle promo</button>`;

let creatBande = `<div onclick="removeAddbande(this)" class="cross">
<i class="fas fa-times"></i>
</div>
<select id="bandeType">
<option value= "no">--Choisis un type de bande--</option>
<option value="product">Produit</option>
<option value="marque">Marque</option>
<option value="promo">Promo</option>
<option value="article">Article</option>
<option value="category">Category</option>
<option value="categoryTitle">Titre de Category</option>
</select>
<button onclick="confirmNewBande(this)">Valider</button>`;

let bandeCommun = `
<div onclick="deleteBande(this)" class="cross">
  <i class="fas fa-times"></i>
</div>
<div class="details">
						<label  for="Visible">Visible :</label>
						<input id="visible" type="number" name='Visible'>
						<label for="scroll">
							scroll:</label>
						<input id="scroll" type="number"  name='scroll'>
						<p>
							
						</p>
            <p class= "error"></p>
					</div>
<div class="subdetails">
<label for="title">
  Titre</label>
<input id="title" type="text" name='title' placeholder="placer le titre">
<label for="subTitle">
  Sous-Titre</label>
<input id="subtitle" type="text" name='subTitle' placeholder="placer le titre">
<p class= "error"></p>
</div>
<div class="elements" data-sortable=".element">

</div>
<p class= "error"></p>
<div class="addnew">
</div>

`;

let plus = `<i class="fas fa-2x fa-plus"></i>`;

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

let newpromo =   function (element) {
  let div = element.parentNode;
  axios
    .get("/admin/getPromos")
    .then((response) => {
      console.log(response.data);
      div.innerHTML = promoSelects;
      fillSelect(
        div.querySelector("#element"),
        response.data.promos,
        "--Choisis une promo--"
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
      fillSelect(div.querySelector("#element"), [], "--Choisis un produit--");
    })
    .catch((err) => {
      console.log(err);
    });
};

let ChangeProduitOnCategoryLow = function (element) {
  let value = element.value;
  let div = element.parentNode;
  axios
    .post("/admin/getProducts", { value })
    .then((response) => {
      console.log(response.data);
      fillSelect(
        div.querySelector("#element"),
        response.data.categories,
        "--Choisis un produit--"
      );
    })
    .catch((err) => {
      console.log(err);
    });
};

let addThisElement = function (element, type) {
  let id = element.parentNode.querySelector("#element").value;
  if (!isNaN(parseInt(id))) {
    let productName =
      element.parentNode.querySelector("#element").selectedOptions[0].innerHTML;
    let filename = element.parentNode
      .querySelector("#element")
      .selectedOptions[0].getAttribute("filename");
    let toInsertAfter =
      element.parentNode.parentNode.querySelector(".subdetails");
    let contenant = element.parentNode.parentNode
      .querySelector(".elements")
      .cloneNode(true);
    element.parentNode.parentNode.querySelector(".elements").remove();
    let elementsNumber = contenant.querySelectorAll(".element").length;
    let div = createDivWithClass("element");

    div.setAttribute("data-position", elementsNumber);
    div.setAttribute("data-id", id);
    let deleteCross = createDivWithClass("cross");
    deleteCross.onclick = function () {
      removeElement(this);
    };
    deleteCross.innerHTML = cross;
    div.appendChild(deleteCross);
    let img = document.createElement("img");
    img.src = "/images/properties/" + filename;
    img.style.width = "80%";
    img.style.height = "80%";
    div.appendChild(img);
    let p1 = document.createElement("p");
    p1.innerHTML = productName;
    div.appendChild(p1);
    contenant.appendChild(div);
    insertAfter(contenant, toInsertAfter);
    new Sortable(contenant, contenant);
    if (type == "category") {
      reloadNewCategory(contenant);
    } else if (type == "marque") {
      reloadNewMarque(contenant);
    } else if (type == "article") {
      reloadNewarticle(contenant);
    } else if (type == "product") {
      reloadNewProduct(contenant);
    }else if (type == "promo"){
      reloadNewPromo(contenant)
    }
  } else {
    //todoooo errooooor
  }
};

let reloadNewarticle = function (element) {
  let toChange = element.parentNode.querySelector(".addnew");
  toChange.innerHTML = articleAddNew;
};

let reloadNewPromo = function (element){
  let toChange = element.parentNode.querySelector(".addnew");
  toChange.innerHTML = promoAddNew;
}

let reloadNewCategory = function (element) {
  let toChange = element.parentNode.querySelector(".addnew");
  toChange.innerHTML = categoryAddNew;
};

let reloadNewMarque = function (element) {
  let toChange = element.parentNode.querySelector(".addnew");
  toChange.innerHTML = marqueAddNew;
};

let reloadNewProduct = function (element) {
  let toChange = element.parentNode.querySelector(".addnew");
  toChange.innerHTML = produitAddNew;
};

let removeElement = function (element) {
  console.log("element");
  console.log(element);
  console.log(element.parentNode);
  let myElementParent = element.parentNode.parentNode;
  let toInsertAfter =
    element.parentNode.parentNode.parentNode.querySelector(".subdetails");
  element.parentNode.remove();
  let contenant = myElementParent.cloneNode(true);
  myElementParent.remove();
  let myElements = contenant.querySelectorAll(".element");
 
    for (let i = 0; i < myElements.length; i++) {
      myElements[i].setAttribute("data-position", i);
    }
    insertAfter(contenant, toInsertAfter);
    if (myElements.length > 0) {
    new Sortable(contenant, contenant);
  } else {
    //TODOOOOOO delete bande
  }
};

let deleteBande = function (element) {
  console.log(element.parentNode);
  let myElementParent = element.parentNode.parentNode;
  let toInsertAfter = myElementParent.parentNode.querySelector("h1");
  element.parentNode.remove();
  let contenant = myElementParent.cloneNode(true);
  myElementParent.remove();
  let myElements = contenant.querySelectorAll(".bande");
  if (myElements.length > 0) {
    for (let i = 0; i < myElements.length; i++) {
      myElements[i].setAttribute("data-position", i);
    }
    insertAfter(contenant, toInsertAfter);
    new Sortable(contenant, contenant);
  } else {
    //TODOOOOOO delete bande
  }
};

let newarticle = function (element) {
  let div = element.parentNode;
  axios
    .get("/admin/getArticles")
    .then((response) => {
      div.innerHTML = articleSelects;
      console.log(div);
      fillSelect(
        div.querySelector("#element"),
        response.data.articles,
        "--Choisis un artcile --"
      );
    })
    .catch((err) => {
      console.log(err);
    });
};

let newmarque = function (element) {
  let div = element.parentNode;
  axios
    .get("/admin/getMarques")
    .then((response) => {
      div.innerHTML = marqueSelects;
      console.log(div);
      fillSelect(
        div.querySelector("#element"),
        response.data.marques,
        "--Choisis une marque --"
      );
    })
    .catch((err) => {
      console.log(err);
    });
};

let newcategory = function (element) {
  let div = element.parentNode;
  if (element.parentNode.parentNode.querySelectorAll(".element").length < 6) {
    axios
      .get("/admin/getHighCategories")
      .then((response) => {
        div.innerHTML = categorySelects;
        console.log(div);
        fillSelect(
          div.querySelector("#element"),
          response.data.categories,
          "--Choisis une categorie--"
        );
      })
      .catch((err) => {
        console.log(err);
      });
  }
};

let addBande = function (element) {
  let div = createDivWithClass("createBande");
  div.innerHTML = creatBande;
  insertAfter(div,document.querySelector('.bandes'))
  element.remove();
};

let removeAddbande = function (element) {
  console.log(element.parentNode)
  let div = createDivWithClass("more");
  div.innerHTML = plus;
  div.onclick = function () {
    addBande(this);
  };
  insertAfter(div,document.querySelector('.bandes'))
  element.parentNode.remove();
};

let confirmNewBande = function (element) {
  
  let bandType = element.parentNode.querySelector("#bandeType").value;
  console.log(bandType)
  if (bandType !== "no") {
    let div = createDivWithClass("bande");
    let bandeNumbers = document.querySelectorAll(".bande").length;
    div.setAttribute("data-position", bandeNumbers);
    div.innerHTML = bandeCommun;
    if (bandType == "Category") {
      reloadNewCategory(div.querySelector(".addnew"));
    } else if (bandType == "marque") {
      reloadNewMarque(div.querySelector(".addnew"));
    } else if (bandType == "article") {
      reloadNewarticle(div.querySelector(".addnew"));
    } else if (bandType == "product") {
      reloadNewProduct(div.querySelector(".addnew"));
    }else if (bandType == "promo"){
      reloadNewPromo(div.querySelector(".addnew"))
    }
    let p = div.querySelector(".details p");
    p.innerHTML = bandType;
    let bandes = document.querySelector(".bandes");
    let bandeSubstitute = bandes.cloneNode(true);
    bandeSubstitute.appendChild(div);
    bandes.remove();
    let toInsertAfter = document.querySelector(".content h1");
    insertAfter(bandeSubstitute, toInsertAfter);
    new Sortable(bandeSubstitute, bandeSubstitute, true);
    let toSort = document.querySelectorAll(".elements");
    for (let i = 0; i < toSort.length -1; i++) {
      new Sortable(toSort[i], toSort[i]);
    }
    removeAddbande(element)
  }
};



let verifyDetails = function(element , error)
{
  let numberElements =  element.querySelectorAll('.element').length
  console.log("soisis")
  console.log(numberElements)
  if (numberElements >0){
  let messageError= ""
 let visible = element.querySelector("#visible").value
 let scroll = element.querySelector("#scroll").value
 if (visible >= numberElements || visible < 1){
  messageError = "l'element visble ne correspond pas . "
  error +=1
 }
 if (scroll > numberElements- visible || scroll < 1){
   messageError += "L'element scroll ne correspond pas."
   error += 1;
 }
 let pError = element.querySelector('.details .error')
 pError.innerHTML = messageError
}
 return error;
}

let verifySubDetails =  function(element, error){
  let lengthTitle = element.querySelector("#title").value.length
  let messageError = ""
  let pError = element.querySelector('.subdetails .error')
  let lenghSubtitle = element.querySelector("#subtitle")
  if (lengthTitle <1 || lengthTitle> 255){
    messageError += "Vous avez une erreur dans le titre . "
    error += 1
  }
  if (lenghSubtitle> 255){
    messageError += "Vous avez une erreur dans le sous-titre ."
    error += 1
  }
  pError.innerHTML = messageError
  return error
}



let verifyElements  = function (element,error) {
  let numberelements = element.querySelectorAll('.element').length
  if (numberelements ==0){
    console.log("ya rrrrrrrr")
    let pError = element.querySelector('.errorElement')
    console.log(pError)
    pError.innerHTML = "Vous n'avez aucun élément dans cette bande"
    error +=1
  }
  return error
}
let validAll = function(){
  let  error = 0
  let bandesToSendHttp = []
 let bandes = document.querySelectorAll(".bande")
 for (let i = 0 ; i < bandes.length ; i++){
  
  error = verifyDetails(bandes[i],error)
   error = verifySubDetails(bandes[i],error)
  error = verifyElements(bandes[i],error)
 }
 console.log(error)
 if(error== 0){
   
   for (let i = 0 ; i < bandes.length ; i++){
     let mySquares = bandes[i].querySelectorAll(".element") 
     let array  = []
     for(let j=0 ; j< mySquares.length ; j++){
      array[j] = mySquares[j].getAttribute('data-id')
      console.log(mySquares[j].getAttribute('data-id'))
    }

      bandesToSendHttp[i]= {
        type : bandes[i].querySelector('.details p').innerHTML.replace(/\n/g, '').replace(/\t/g, ''),
        visible : bandes[i].querySelector("#visible").value,
        scroll : bandes[i].querySelector("#scroll").value,
        title : bandes[i].querySelector("#title").value,
        subtitle  : bandes[i].querySelector("#subtitle").value,
        position : bandes[i].dataset.position,
        elements :array
   }
   

   }
   console.log(bandesToSendHttp)
   window.location.href = '/admin'
   axios
   .post("/admin/validNewBandes",{bandesToSendHttp})
   .then((response) => {
     console.log(response.data)
    // window.location.href = '/admin/bandes'
   })
   .catch((err) => {
     console.log(err);
   });
 }
}

window.newpromo = newpromo
window.validAll = validAll;
window.confirmNewBande = confirmNewBande;
window.removeAddbande = removeAddbande;
window.addBande = addBande;
window.newcategory = newcategory;
window.newmarque = newmarque;
window.newarticle = newarticle;
window.deleteBande = deleteBande;
window.removeElement = removeElement;
window.addThisElement = addThisElement;
window.ChangeProduitOnCategoryHigh = ChangeProduitOnCategoryHigh;
window.ChangeProduitOnCategoryLow = ChangeProduitOnCategoryLow;
window.newproduit = newproduit;