import "./styles/admin/design.css";

console.log("le design il baise ");

let Sortable = function (element,scrollable) {
  this.element = element;
  let self = this;
  if(scrollable == null){
      scrollable= document.body
  }
  this.scrollable = scrollable
  this.items = this.element.querySelectorAll(this.element.dataset.sortable);
  let rect = this.items[0].getBoundingClientRect();
  this.item_width = Math.floor(rect.width);
  this.item_height = Math.floor(rect.height);
  this.cols = Math.floor(this.element.offsetWidth / this.item_width);
  this.element.style.height =
    this.item_height * Math.ceil(this.items.length / this.cols) + "px";
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
      autoScroll : {
          container: scrollable,
          margin:150,
          speed: 600

      },
      onmove: function (e) {
        self.move(e);
      },
    })
    .on("dragstart", function (e) {
        let r = e.target.getBoundingClientRect()
      e.target.classList.add("is-dragged");
      self.startPosition = e.target.dataset.position
      self.offset = {
          x: e.clientX - r.left,
          y: e.clientY - r.top,
      };
      self.scrollTopStart = self.scrollable.scrollTop
    })
    .on("dragend", function (e) {
      e.target.classList.remove("is-dragged");
      self.moveItem(e.target,e.target.dataset.position)
    });
};
Sortable.prototype.move = function (e) {
  let p = this.getXY(this.startPosition);
  let x = p.x + e.clientX - e.clientX0;
  let y = p.y + e.clientY - e.clientY0 +this.scrollable.scrollTop - this.scrollTopStart;
  e.target.style.transform = "translate3D(" + x + "px," + y + "px,0)";
  let oldPosition = e.target.dataset.position;
  let newPosition = this.guessPosition(x + this.offset.x, y + this.offset.y);
  if (oldPosition != newPosition) {
    this.swap(oldPosition, newPosition);
    e.target.dataset.position = newPosition
  }
  this.guessPosition(x,y)
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
    if (!item.classList.contains('is-dragged')){
        let position = parseInt(item.dataset.position,10 );
        if (position >= end && position <start && end < start) {
          this.moveItem(item, position + 1);
        }else if (position <= end && position > start && start < end){
            this.moveItem(item,position-1)
        }
    }
    
  }
};
Sortable.prototype.moveItem = function (item, position) {
  let p = this.getXY(position);
  item.style.transform = "translate3D(" + p.x + "px," + p.y + "px, 0)";
  item.dataset.position= position
};

let sortable = new Sortable(document.querySelector(".elements"));
let createDivWithClass = function (className) {
  let div = document.createElement("div");
  div.setAttribute("class", className);
  return div;
};
let choice = `
<select name="pets" class="mene">
    <option value="">--Choisis Un type de Bande--</option>
    <option value="dog">Dog</option>
    <option value="cat">Cat</option>
    <option value="hamster">Hamster</option>
    <option value="parrot">Parrot</option>
    <option value="spider">Spider</option>
    <option value="goldfish">Goldfish</option>
</select>
<button onclick="ChooseType()">Valider</button>
`;

window.addBande = function () {
  console.log("sisiiiii");
  let bandes = document.querySelector(".bandes");
  let div = createDivWithClass("choose");
  div.innerHTML = choice;
  bandes.appendChild(div);
};

let ChooseType = function () {
  let choose = document.querySelector(".choose");
  console.log(choose);
  let mene = choose.querySelector(".mene");
  console.log(mene.value);
};

window.ChooseType = ChooseType;
console.log("le design il knjvroikfprol ");
