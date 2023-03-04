const selectRenterType = document.getElementById('renter_type');
const surname = document.getElementById('renter_surname');
const corporateStructure = document.getElementById('corporate_structure');

selectRenterType.addEventListener('change', () => {
  if (selectRenterType.value === 'Agency') {
    surname.disabled = true;
    corporateStructure.disabled = false;

    corporateStructure.value = "";
    surname.disabled = "";
  } else {
    surname.disabled = false;
    corporateStructure.disabled = true;

    corporateStructure.value = "";
    surname.disabled = "";
  }
});
