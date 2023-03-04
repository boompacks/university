const selectAccomodation = document.getElementById("accomodation_id");

selectAccomodation.addEventListener('change', () => {
    const accomodationId = selectAccomodation.value;

    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'getAccomodation.php?accomodation_id=' + accomodationId);
    xhr.onload = function() {
    	if (xhr.status === 200) {
        	const response = JSON.parse(xhr.responseText);

          const accomodationData = response[0];
          
          const accomodationArea = document.getElementById("area");
          accomodationArea.value = accomodationData.area.charAt(0).toUpperCase() + accomodationData.area.slice(1);
            
          const accomodationAddress = document.getElementById("address");
          accomodationAddress.value = accomodationData.address.charAt(0).toUpperCase() + accomodationData.address.slice(1);

        }
      };
    xhr.send();
});