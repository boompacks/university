const selectReferent = document.getElementById("referent_id");

selectReferent.addEventListener('change', () => {
    const referentId = selectReferent.value;

    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'getReferent.php?referent_id=' + referentId);
    xhr.onload = function() {
    	if (xhr.status === 200) {
        	const response = JSON.parse(xhr.responseText);

          const referentData = response[0];
          
          const name = document.getElementById("referent_name");
          name.value = referentData.referent_name.charAt(0).toUpperCase() + referentData.referent_name.slice(1);
            
          const surname = document.getElementById("referent_surname");
          surname.value = referentData.referent_surname.charAt(0).toUpperCase() + referentData.referent_surname.slice(1);

        }
      };
    xhr.send();
});