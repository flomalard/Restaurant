"use strict"

import Error from "./error.js";

class SetRequests {
  constructor(
    mail,
    pass
  ) {
    //L'appel aux méthodes se fait ici
    this._mail = this.validateMail("mail", mail);
    this._pass = this.validatePass("pass", pass)
  }


  // Valider l'ensemble du formulaire
  
  validateForm() {
    if (
      this._mail !== null &&
      this._pass !== null &&
      this.testMail(this._mail) &&
      this.testPass(this._pass)
    ) {
      return true; 
      // Le formulaire est valide
    } else {
      return false; 
      // Le formulaire n'est pas valide
    }
  }
  
  
  //Valider les champs

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

  validatePass(propertyPass,pass) {
    let error = new Error(propertyPass, "Le champ ne doit pas être vide");
    error.clearErrors();
    if (pass === null || pass.trim() === "") {
      error.errorElements();
    } else if (!this.testPass(pass)) {
      error.setMessage(
        'Veuillez respectez la forme "une lettre majuscule, une lettre minuscule, un chiffre et au moin huit caractères" '
      );
      error.errorElements();
    }
    else 
    {
      return pass;
    }
  }

  // REGEX
  testMail(mail) {
    return /^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/.test(mail);
  }

  testPass(pass) {
    return /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/.test(pass);
  }
}

export default SetRequests;