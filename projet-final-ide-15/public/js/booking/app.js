"use strict"

import SetRequests from "./setRequest.js";

document.addEventListener("DOMContentLoaded", function () {
  const submit = document.getElementById("submit");

  submit.addEventListener("click", (e) => {
    console.log("Le bouton a été cliqué !");
    const date = document.getElementById("date").value;
    const hour = document.getElementById("hour").value;
    const minute = document.getElementById("minute").value;
    const customersNumber = document.getElementById("customersNumber").value;

    const setRequest = new SetRequests(
      date,
      customersNumber
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
