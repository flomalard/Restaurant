"use strict"

class Error {
  constructor(champ, text) {
    this._champ = champ;
    this._text = text;
  }

  errorElements() {
    const targetElement = document.getElementById(this._champ);
    if (targetElement) {
      let span = document.createElement("span");
      span.id = this._champ + "Error";
      span.classList.add("error");
      span.innerHTML = this._text;
      targetElement.parentElement.appendChild(span);
    }
  }

  clearErrors() {
    const errorElement = document.getElementById(this._champ + "Error");
    if (errorElement) {
      errorElement.remove();
    }
  }

  setMessage(text) {
    this._text = text;
  }
}

export default Error;
