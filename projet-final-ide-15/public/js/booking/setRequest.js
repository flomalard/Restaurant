"use strict"

import Error from "./error.js";

class SetRequests {
  constructor(
    date,
    customersNumber
  ) {
    //Appel aux méthodes
    this._date = this.validateDate("date", date);
    this._customersNumber = this.validateCustomersNumber("customersNumber", customersNumber);
  }



  // Valider l'ensemble du formulaire
  
  validateForm() {
    if (
      this._date !== null &&
      this._customersNumber !== null &&
      this.testDate(this._date) &&
      this.testCustomersNumber(this._customersNumber)
    ) {
      return true; 
    }
    else
    {
      return false; 
    }
  }
  
  
  
  //Valider les champs
  
  validateDate(propertyDate, value)
  {
    let error = new Error(propertyDate, "Vous devez choisir une date");
    error.clearErrors();
    if (this.testDate(value))
    {
      return value;
    } 
    else {
      error.errorElements();
    }
  }
  
  validateCustomersNumber(propertyCustomersNumber, value)
  {
    let error = new Error(propertyCustomersNumber, "Le champ ne doit pas être vide");
    value = parseInt(value, 10);
    error.clearErrors();
    if (this.testCustomersNumber(value)) {
      return value;
    }
    else if (value <= 0)
    {
      error.setMessage("Vous devez saisir un nombre positif");
      error.errorElements();
    }
    else if (value > 20)
    {
      error.setMessage("Nous ne proposons pas de table pour plus de 20 personnes");
      error.errorElements();
    }
    else
    {
      error.errorElements();
    }
  }

  // REGEX
  
  testDate(date)
  {
    return /^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/.test(date)
  }
  
  testCustomersNumber(number)
  {
    return /^(?:[0-9]|1[0-9]|20)$/.test(number)
  }

}

export default SetRequests;