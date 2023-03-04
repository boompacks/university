const select = document.getElementById("student_id");

select.addEventListener('change', () => {
    const studentId = select.value;

    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'getStudent.php?id=' + studentId);
    xhr.onload = function() {
    	if (xhr.status === 200) {
        	const response = JSON.parse(xhr.responseText);

			const studentData = response[0];
        	const name = document.getElementById("name");
			name.value = studentData.name.charAt(0).toUpperCase() + studentData.name.slice(1);
         
			const surname = document.getElementById("surname");
			surname.value = studentData.surname.charAt(0).toUpperCase() + studentData.surname.slice(1);

			const gender = document.getElementById("gender");
			gender.value = studentData.gender.charAt(0).toUpperCase() + studentData.gender.slice(1);

			const birthDate = document.getElementById("birth_date");
			birthDate.value = studentData.birth_date.charAt(0).toUpperCase() + studentData.birth_date.slice(1);

			const country = document.getElementById("country");
			country.value = studentData.country.charAt(0).toUpperCase() + studentData.country.slice(1);
        }
      };
    xhr.send();
});