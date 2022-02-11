class sectionOneView {
  _parentElementClass = ".main__section-one";
  _parentElement = document.querySelector(this._parentElementClass);
  _formElementClass = "#section-one__form";

  constructor() {}

  // add buttons handler
  //   zaimplementuj update method przy rerendowoaniu buttonów i textu
  //   w formie ma być input text i submit

  render() {
    /** Check if there is something, if so delete it */
    this._checkContainerEmpty() && this._clearContainer();

    /** Get HTML */
    const html = this._getHTML();
    /** Render HTML */
    this._renderHTML(html);
  }

  addHandlerSubmit(handler) {
    this._parentElement.addEventListener("submit", handler.bind(this));
  }

  _getHTML() {
    const plainFormId = this._formElementClass.slice(1);
    return `
        <form action="" id="${plainFormId}">
            <label for="text">Text:</label>
            <input type="text" name="text" id="text" value="TEST"/>
            <input type="submit" value="Send" />
        </form>
    `;
  }

  _renderHTML(html) {
    this._parentElement.insertAdjacentHTML("beforeend", html);
  }

  _clearContainer() {
    this._parentElement.innerHTML = "";
  }

  _checkContainerEmpty() {
    // Return boolean of parent element child nodes length
    return Boolean(this._parentElement.childNodes.length);
  }

  _getFormData() {
    const formElement = document.querySelector(this._formElementClass);
    const formData = new FormData(formElement);
    return formData;
  }
}

export default new sectionOneView();
