"use strict";

function sendOrderToServer(event) {
  event.preventDefault();

  panier = localStorage.getItem("panier");

  if (panier == null) {
    panier = [];
  } else {
    panier = JSON.parse(panier);
  }

  // Envoyez les données de la commande au serveur via une requête AJAX
  fetch("index.php?action=valideOrder", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body:
      "orderData=" +
      encodeURIComponent(JSON.stringify(panier)) +
      "&totalPrice=" +
      totalPrice,
  })
    .then(handleResponse)
    .then(clearStorage)
    // J'ajoute le message de validation
    .then(validationMessage)
    .catch(handleError);
}

function selectNameChange() {
  IDMeal = selectElement.value;

  fetch("index.php?action=Meals", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: "mealID=" + encodeURIComponent(IDMeal),
  })
    .then(handleResponse)
    .then(displayMeals)
    .catch(handleError);
}

function handleResponse(response) {
  // console.log(response.text());
  if (!response.ok) {
    throw new Error("La requête a échoué avec le statut : " + response.status);
  }
  return response.json();
}

function displayMeals(mealDetails) {
  if (mealDetails) {
    descriptionElement.textContent = mealDetails.description;
    priceElement.textContent = mealDetails.price;
    imageElement.src = "public/images/meals/" + mealDetails.image;
    imageElement.alt = mealDetails.description;
  } else {
    descriptionElement.textContent = "";
    priceElement.textContent = "";
    imageElement.src = "";
    imageElement.alt = "";
  }
}

function handleError(error) {
  console.error("Une erreur est survenue lors de la requête : " + error);
}

function selectName() {
  selectElement = document.getElementById("category");
  selectElement.addEventListener("change", selectNameChange);
  selectNameChange();

  // On vérifi si un panier existe
  if (localStorage.getItem("panier") === null) {
    //Non, on ajoute une class hidden (avec display:none)
    recapFieldset.classList.add("hidden");
    submit.classList.add("hidden");
    clear.classList.add("hidden");
  } else {
    //Oui, on retire la class hidden
    recapFieldset.classList.remove("hidden");
    submit.classList.remove("hidden");
    clear.classList.remove("hidden");
  }
  add.addEventListener("click", clearTable);
  add.addEventListener("click", addLocalStorage);
  add.addEventListener("click", getLocalStorage);
  clear.addEventListener("click", clearStorage);
  submit.addEventListener("click", sendOrderToServer);
}

//------LOCAL STORAGE------//

function addLocalStorage() {
  // On initie l'affichage
  if (isNaN(quantity.value) || quantity.value <= 0) {
  } else {
    // DESCRIPTION
    //PRODUIT
    panier = localStorage.getItem("panier");

    if (panier == null) {
      panier = [];
    } else {
      panier = JSON.parse(panier);
    }

    const selectElement = document.getElementById("category");
    const selectedOption = selectElement.options[selectElement.selectedIndex];
    //PRIX UNITAIRE
    const priceUnitaire = priceElement;

    const selectedOptionText = selectedOption.textContent;

    // On vérifi si le produit existe déjà dans le panier --> s'il n'existe pas, findIndex renverra -1
    const existingProductIndex = panier.findIndex(
      (item) => item.selectedMealID === selectedOptionText
    );

    if (existingProductIndex !== -1) {
      // S'il existe, on met à jour
      panier[existingProductIndex].quantity += Number(quantity.value);
    } else {
      // Si le produit n'existe pas encore, ajoutez-le
      panier.push({
        description: descriptionElement.textContent,
        selectedMealID: selectedOptionText,
        quantity: Number(quantity.value),
        priceUnitaire: priceUnitaire.textContent,
        IDMeal: IDMeal,
      });
    }

    panier = localStorage.setItem("panier", JSON.stringify(panier));

    // Si le panier était vide, on retire les class hidden
    recapFieldset.classList.remove("hidden");
    submit.classList.remove("hidden");
    clear.classList.remove("hidden");

    // On permet au panier de se mettre à jour
    updatePanier();
  }
}

function updatePanier() {
  const tableBody = document.querySelector("tbody");
  totalPrice = 0;

  // Effacez le contenu actuel du récapitulatif
  clearTable();

  for (let i = 0; i < panier; i++) {
    const tr = document.createElement("tr");

    const tdQuantity = document.createElement("td");
    tdQuantity.innerHTML = panier[i].quantity;

    const tdProduit = document.createElement("td");
    tdProduit.innerHTML = panier[i].selectedMealID;

    const tdDescription = document.createElement("td");
    tdDescription.innerHTML = panier[i].description;

    const tdPrice = document.createElement("td");
    tdPrice.innerHTML = panier[i].priceUnitaire + "€";

    totalPrice += parseFloat(panier[i].priceUnitaire) * panier[i].quantity;

    totalPriceTD.innerHTML = totalPrice.toFixed(2) + "€";

    tr.appendChild(tdQuantity);
    tr.appendChild(tdProduit);
    tr.appendChild(tdDescription);
    tr.appendChild(tdPrice);

    tableBody.appendChild(tr);
  }
}
function getLocalStorage() {
  panier = localStorage.getItem("panier");

  if (panier == null) {
    panier = [];
  } else {
    panier = JSON.parse(panier);
  }

  const tableBody = document.querySelector("tbody");
  totalPrice = 0;

  for (let i = 0; i < panier.length; i++) {
    const tr = document.createElement("tr");

    const tdQuantity = document.createElement("td");
    tdQuantity.innerHTML = panier[i].quantity;

    const tdProduit = document.createElement("td");
    tdProduit.innerHTML = panier[i].selectedMealID;

    const tdDescription = document.createElement("td");
    tdDescription.innerHTML = panier[i].description;

    const tdPrice = document.createElement("td");
    tdPrice.innerHTML = panier[i].priceUnitaire + "€";

    totalPrice += parseFloat(panier[i].priceUnitaire * panier[i].quantity);

    totalPriceTD.innerHTML = totalPrice.toFixed(2) + "€";

    tr.appendChild(tdQuantity);
    tr.appendChild(tdProduit);
    tr.appendChild(tdDescription);
    tr.appendChild(tdPrice);

    tableBody.appendChild(tr);
  }
}

function clearTable() {
  const tbody = document.querySelector("tbody");
  const tdElements = tbody.querySelectorAll("td");
  tdElements.forEach((td) => {
    td.remove();
  });
  const trElements = tbody.querySelectorAll("tr");
  trElements.forEach((tr) => {
    tr.remove();
  });

  totalPriceTD.textContent = "";
}

function fixQuantity(input) {
  let quantity = input.value;

  if (quantity <= "0") {
    input.value = "1";
  }
}

function clearStorage() {
  localStorage.removeItem("panier");
  selectName();
  clearTable();
}

function validationMessage() {
  const validationMsg = document.getElementById("validationMessage");
  validationMsg.textContent =
    "Votre commande pour un montant de " +
    totalPrice +
    "€ est en cours de préparation.Vous allez être redirigé vers la page d'accueil";
  setTimeout(() => {
    window.location.href = "index.php";
  }, 3000);
}

document.addEventListener("DOMContentLoaded", selectName);
document.addEventListener("DOMContentLoaded", getLocalStorage);

let panier = [];
let selectElement;
let IDMeal;
let totalPrice = 0;
const descriptionElement = document.getElementById("description");
const quantity = document.getElementById("quantity");
const priceElement = document.getElementById("price");
const imageElement = document.getElementById("image");
const nameOption = document.getElementById("nameOption");
const totalPriceTD = document.getElementById("totalPrice");
const recapFieldset = document.getElementById("recapFieldset");
