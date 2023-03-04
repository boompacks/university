const selectRenter = document.getElementById("renter_id");

selectRenter.addEventListener('change', () => {
    const renterId = selectRenter.value;

    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'getRenter.php?renter_id=' + renterId);
    xhr.onload = function() {
    	if (xhr.status === 200) {
        	const response = JSON.parse(xhr.responseText);
			console.log(response[0]);

			const renterData = response[0];
      		const name = document.getElementById("renter_name");
			name.value = renterData.renter_name.charAt(0).toUpperCase() + renterData.renter_name.slice(1);
         
			const type = document.getElementById("renter_type");
			type.value = renterData.renter_type.charAt(0).toUpperCase() + renterData.renter_type.slice(1);
      }
    };
    xhr.send();
});