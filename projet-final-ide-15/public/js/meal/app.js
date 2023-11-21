"use strict"

import SetRequests from "./setRequest.js";

document.addEventListener("DOMContentLoaded", function () {
  const submit = document.getElementById("submit");

  submit.addEventListener("click", (e) => {
    console.log("Le bouton a été cliqué !");
    const name = document.getElementById("name").value;
    const description = document.getElementById("description").value;
    const price = document.getElementById("price").value;

    const setRequest = new SetRequests(
      name,
      description,
      price
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
