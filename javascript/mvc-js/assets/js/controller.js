"use strict";

/** Import polyfills  */
import "core-js/stable";
import "regenerator-runtime/runtime";
import { async } from "regenerator-runtime";

/** Helpers */
import {formDataToObject} from "./helpers";

/** Import model */
import * as model from "./models/mainModel";

/** Import views */
import sectionOneView from "./views/sectionOneView";

/** Parcel hot module replacement */
if (module.hot) {
  module.hot.accept();
}

(async () => {
  const controlSubmitForm = async function (e) {
    return new Promise((resolve, reject) => {
      try {
        e.preventDefault();
        
        // Get form data
        const formData = this._getFormData();

        // Transform form data into object 
        const formDataObject = formDataToObject(formData);

        model.addFormData(formDataObject);

        console.log(model.state.formData);
        /**
         * umiesc to w state ale to w modelu juz bedzie jakas method
         */
        resolve();
      } catch (err) {
        reject(err);
      }
    });
  };

  const init = async function () {
    //   Render sectionOneView buttons
    sectionOneView.render();

    await sectionOneView.addHandlerSubmit(controlSubmitForm);
  };
  // render buttons of sectionOne
  // add handler on click render
  init();
})();
