"use strict";

(async function () {
  // Reference usefull elements
  const outputContainer = document.querySelector(".output");
  const form = document.querySelector(".form");

  class App {
    constructor() {
      // Clear output element
      this._clearContainer(outputContainer);

      // Publisher subscriber pattern, add event listener
      this._addHandlerSubmitForm(form);
    }

    // Clear container element
    _clearContainer(container) {
      container.innerHTML = "";
    }

    // Function that adds event listener to the form element
    _addHandlerSubmitForm(container) {
      // Assign event listener to the form
      container.addEventListener("submit", this._handleForm.bind(this));
    }

    // Handle form function
    _handleForm(e) {
      // Prevent default action
      e.preventDefault();

      // Clear output element
      this._clearContainer(outputContainer);

      // Get FormData of form element in array format
      const formDataArr = this._formDataToArray(e.currentTarget);

      // Get FormData of form element in object format
      const formDataObject = this._formDataToObject(formDataArr);

      // Display form data in output element
      this._displayFormData(formDataObject);
    }

    // Transform FormData to array
    _formDataToArray(form) {
      return [...new FormData(form)];
    }

    // Transform FormData array to object
    _formDataToObject(arr) {
      return Object.fromEntries(arr);
    }

    // Display form data in output element
    _displayFormData(obj) {
      for (const [key, value] of Object.entries(obj)) {
        outputContainer.textContent += `${key}: ${value} | `;
      }
    }
  }

  // Initialize App
  const app = new App();
})();
