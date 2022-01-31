const addTagFormDeleteLink = (item) => {
  const removeFormButton = document.createElement("button");
  removeFormButton.innerHTML = '<i class="fas fa-minus-circle"></i>';

  item.append(removeFormButton);

  removeFormButton.addEventListener("click", (e) => {
    e.preventDefault();

    item.remove();
  });
};

document.querySelectorAll("ul.itemList li").forEach((tag) => {
  addTagFormDeleteLink(tag);
});
document.querySelectorAll("ul.itemAdviceList li").forEach((tag) => {
  addTagFormDeleteLink(tag);
  console.log(tag.innerHTML);
});

const addFormToCollection = (e) => {
  const collectionHolder = document.querySelector(
    "." + e.currentTarget.dataset.collectionHolderClass
  );
  console.log(collectionHolder);
  const item = document.createElement("li");
  item.innerHTML = collectionHolder.dataset.prototype.replace(
    /__name__/g,
    collectionHolder.dataset.index
  );
  collectionHolder.appendChild(item);
  collectionHolder.dataset.index++;
  addTagFormDeleteLink(item);
};

document.querySelectorAll(".add_item_link").forEach((btn) => {
  btn.addEventListener("click", addFormToCollection);
  console.log(btn);
});
