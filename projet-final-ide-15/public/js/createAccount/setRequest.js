"use strict"

import Error from "./error.js";

class SetRequests {
  constructor(
    firstName,
    lastName,
    address,
    city,
    mail,
    pass,
    passConfirm,
    postalCode,
    phone,
    birthdate
  ) {
    //L'appel aux méthodes se fait ici
    this._firstName = this.validateAndSet("firstName", firstName);
    this._lastName = this.validateAndSet("lastName", lastName);
    this._address = this.validateAddress("address", address);
    this._city = this.validateAndSet("city", city);
    this._mail = this.validateMail("mail", mail);
    this._pass = this.validatePass("pass", pass,passConfirm);
    this._passConfirm = this.validatePass("passConfirm", pass,passConfirm);
    this._postalCode = this.validatePostalCode("postalCode", postalCode);
    this._phone = this.validatePhone("phone", phone);
    this._birthdate = this.validateBirthdate("birthdate", birthdate);
  }



  // Valider l'ensemble du formulaire
  
  validateForm() {
    if (
      this._firstName !== null &&
      this._lastName !== null &&
      this._address !== null &&
      this._city !== null &&
      this._mail !== null &&
      this._pass !== null &&
      this._passConfirm !== null &&
      this._postalCode !== null &&
      this._phone !== null &&
      this._birthdate !== null &&
      this.testLetter(this._firstName) &&
      this.testLetter(this._lastName) &&
      this.testAddress(this._address) &&
      this.testMail(this._mail) &&
      this.testPass(this._pass) &&
      this.testpostalCode(this._postalCode) &&
      this.testPhone(this._phone) &&
      this.testBirthdate(this._birthdate) 
    ) {
      return true; 
      // Le formulaire est valide
    } else {
      return false; 
      // Le formulaire n'est pas valide
    }
  }
  
  
  
  //Valider les champs
  
  validateAndSet(propertyName, value) {
    let error = new Error(propertyName, "Le champ ne doit pas être vide");
    error.clearErrors();
    if (value === null || value.trim() === "") {
      error.errorElements();
    } else if (!this.testLetter(value)) {
      error.setMessage("Champ invalide");
      error.errorElements();
    } else {
      return value;
    }
  }
  
  validateAddress(propertyAddress, value) {
    let error = new Error(propertyAddress, "Le champ ne doit pas être vide");
    error.clearErrors();
    if (value === null || value.trim() === "") {
      error.setMessage("Le champ ne doit pas être vide");
      error.errorElements();
    } else if (!this.testAddress(value)) {
      error.setMessage("Adresse invalide");
      error.errorElements();
    } else {
      return value;
    }
  }

  validateMail(propertyMail, value) {
    let error = new Error(propertyMail, "Le champ ne doit pas être vide");
    error.clearErrors();
    if (value === null || value.trim() === "") {
      error.errorElements();
    } else if (!this.testMail(value)) {
      error.setMessage("Vous devez respecter le format d'un e-mail");
      error.errorElements();
    } else {
      return value;
    }
  }

  validatePass(propertyPass,pass,passConfirm) {
    let error = new Error(propertyPass, "Le champ \"Mot de passe\" ne doit pas être vide");
    error.clearErrors();
    if (pass === null || pass.trim() === "") {
      error.errorElements();
    } else if (!this.testPass(pass)) {
      error.setMessage(
        'Veuillez respectez la forme "une lettre majuscule, une lettre minuscule, un chiffre et au moin huit caractères" '
      );
      error.errorElements();
    }
    else if(pass != passConfirm)
    {
      error.setMessage("Votre mot de passe ne correspond pas");
      error.errorElements();
    }
    else 
    {
      return pass;
    }
  }

  validateConfirmPass(propertyConfirmPass, value) {
    let error = new Error(propertyConfirmPass, "Vous devez saisir une valeur");
    error.clearErrors();
    if (value !== this._pass) {
      error.setMessage("Votre mot de passe ne correspond pas");
      error.errorElements();
    } else if (value === this._pass) {
      return value;
    }
  }
  
  validatePostalCode(propertyPostalCode, value) {
    let error = new Error(propertyPostalCode, "Le champ ne doit pas être vide");
    error.clearErrors();
    if (value === null || value.trim() === "") {
      error.errorElements();
    } else if (!this.testpostalCode(value)) {
      error.setMessage("Veuillez saisir 5 chiffres");
      error.errorElements();
    } else {
      return value;
    }
  }
  
  validatePhone(propertyPhone, value) {
    let error = new Error(propertyPhone, "Le champ ne doit pas être vide");
    error.clearErrors();
    if (value === null || value.trim() === "") {
      error.errorElements();
    } else if (!this.testPhone(value)) {
      error.setMessage("Votre numéro de téléphone n'est pas valide");
      error.errorElements();
    } else {
      return value;
    }
  }

  validateBirthdate(propertyBirthdate, value) {
    let error = new Error(propertyBirthdate, "Le champ ne doit pas être vide");
    error.clearErrors();
    if (this.testBirthdate(value)) {
      return value;
    } else {
      error.errorElements();
    }
  }

  // REGEX
  testMail(mail) {
    return /^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/.test(mail);
  }

  testLetter(chaine) {
    return /^[a-zA-ZÀ-ÿ\-\s]*$/.test(chaine);
  }

  testPass(pass) {
    return /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/.test(pass);
  }

  testpostalCode(postalCode) {
    return /^\d{5}$/.test(postalCode);
  }
  testPhone(phone) {
    return /^(?:(?:\+|00)33|0)\s*[1-9](?:[\s.-]*\d{2}){4}$/.test(phone);
  }

  testAddress(address) {
    return /^[a-zA-Z0-9À-ÿ\s\-]*$/.test(address);
  }
  testBirthdate(date) {
    const datePattern = /^\d{4}-\d{2}-\d{2}$/;
    return datePattern.test(date);
  }
}

export default SetRequests;