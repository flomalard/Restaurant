"use strict";

import Error from "./error.js";

class SetRequests {
  constructor(name, description, price) {
    // L'appel aux méthodes se fait ici
    this._name = this.validateName("name", name);
    this._description = this.validateDescription("description", description);
    this._price = this.validatePrice("price", price);
  }

  // Valider l'ensemble du formulaire
  validateForm() {
    if (
      this._name !== null &&
      this._description !== null &&
      this._price !== null &&
      this.testName(this._name) &&
      this.testDescription(this._description) &&
      this.testPrice(this._price)
    ) {
      return true;
      // Le formulaire est valide
    } else {
      return false;
      // Le formulaire n'est pas valide
    }
  }

  // Valider les champs
  validateName(propertyName, value) {
    let error = new Error(propertyName, "Le champ ne doit pas être vide");
    error.clearErrors();
    if (value === null || value.trim() === "") {
      error.errorElements();
    } else if (!this.testName(value)) {
      error.setMessage(
        "Vous utilisez des caractères interdits (caractères spéciaux limités)"
      );
      error.errorElements();
    } else {
      return value;
    }
  }

  validateDescription(propertyDescription, value) {
    let error = new Error(propertyDescription, "Le champ ne doit pas être vide");
    error.clearErrors();
    if (value === null || value.trim() === "") {
      error.errorElements();
    } else if (!this.testDescription(value)) {
      error.setMessage(
        "Vous utilisez des caractères interdits (caractères spéciaux limités)"
      );
      error.errorElements();
    } else {
      return value;
    }
  }

  validatePrice(propertyPrice, price) {
    let error = new Error(propertyPrice, "Le champ ne doit pas être vide");
    error.clearErrors();
    if (price === null || price.trim() === "") {
      error.errorElements();
    } else if (!this.testPrice(price)) {
      error.setMessage(
        "Vous devez entrer un nombre avec au maximum 2 chiffres après le point"
      );
      error.errorElements();
    } else {
      return price;
    }
  }

  // REGEX
  testName(name) {
    return /^[A-Za-z0-9\s\-',.!?À-ÖØ-öø-ÿ]+$/u.test(name);
  }

  testDescription(description) {
    return /^[A-Za-z0-9\s\-',.!?À-ÖØ-öø-ÿ]+$/u.test(description);
  }

  testPrice(price) {
    return /^\d+(\.\d{1,2})?$/.test(price);
  }
}

export default SetRequests;