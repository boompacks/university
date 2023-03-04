const select = document.getElementById("ncontacts");
const container = document.getElementById("contactsWrapper");
const reset = document.getElementById("reset")


select.addEventListener("change", function() {
  const numberOfInputs = select.value;
  container.innerHTML = "";

  for (let i = 0; i < numberOfInputs; i++) {
    const inputContainer = document.createElement("div");
    inputContainer.classList.add('input-flex')
    inputContainer.innerHTML = `
        <div>
          <label class="form-label">Type</label>
          <select class="form-input" name="type${i}" id="type${i}" required>
            <option value="" selected disabled hidden>Choose type of contact</option>
            <option value="Email">Email</option>
            <option value="Phone">Phone</option>
          </select>
        </div>

        <div>
          <label for="value" class="form-label"> Contact </label>
          <input type="text" name="value${i}" id="value${i}" placeholder="Contact" class="form-input" required/>
        </div>
    `;
    container.appendChild(inputContainer);
  }
});


reset.addEventListener("click", function() {
  container.innerHTML = "";
});