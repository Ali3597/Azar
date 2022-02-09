let categoryParent = document.querySelector("#produit_categoryParent");

categoryParent.addEventListener("change", function () {
  let form = this.closest("form");
  let data = this.name + "=" + this.value;

  fetch(form.action, {
    method: form.getAttribute("method"),
    body: data,
    headers: {
      "Content-Type": "application/x-www-form-urlencoded;charset:UTF-8",
    },
  })
    .then((response) => response.text())
    .then((html) => {
      let content = document.createElement("html");
      content.innerHTML = html;

      let nouveauSelect = content.querySelector("#produit_category");

      document.querySelector("#produit_category").replaceWith(nouveauSelect);
    })
    .catch((e) => {});
});
