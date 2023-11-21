"use strict"

import SetRequests from "./setRequest.js";

document.addEventListener("DOMContentLoaded", function () {
  const submit = document.getElementById("login");

  submit.addEventListener("click", (e) => {
    console.log("Le bouton a été cliqué !");
    const mail = document.getElementById("mail").value;
    const pass = document.getElementById("pass").value;

    const setRequest = new SetRequests(
      mail,
      pass
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
