"use strict"

import SetRequests from "./setRequest.js";

document.addEventListener("DOMContentLoaded", function () {
  const submit = document.getElementById("submit");

  submit.addEventListener("click", (e) => {
    console.log("Le bouton a été cliqué !");
    const firstName = document.getElementById("firstName").value;
    const lastName = document.getElementById("lastName").value;
    const address = document.getElementById("address").value;
    const city = document.getElementById("city").value;
    const pass = document.getElementById("pass").value;
    const passConfirm = document.getElementById("passConfirm").value;
    const mail = document.getElementById("mail").value;
    const postalCode = document.getElementById("postalCode").value;
    const phone = document.getElementById("phone").value;
    const birthdate = document.getElementById("birthdate").value;

    const setRequest = new SetRequests(
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
    );
    
    //console.log(setRequest);
    
    if (setRequest.validateForm()) 
    {
      // e.preventDefault();
      console.log('ok');
    } else 
    {
      e.preventDefault();
      console.log('oups');
    }
  });
});
