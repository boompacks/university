<html>
    <head>
        <title>AccaHousingME - Edit user</title>
        <link rel='stylesheet' href='../../styles/styles.css'>
        <link rel='stylesheet' href='../../styles/form.css'>
        <script src="../../scripts/contacts.js" defer></script>
        <link rel='preconnect' href='https://fonts.googleapis.com'>
        <link rel='preconnect' href='https://fonts.gstatic.com' crossorigin>
        <link href='https://fonts.googleapis.com/css2?family=Source+Sans+Pro&display=swap' rel='stylesheet'>
    </head>

    <body>
        <div class='content'>
            <?php 
                    include '../../coreComponents/header3.php';
                    include '../../db.php';
            ?>

            <?php
                $query = "SELECT s.* FROM student s WHERE s.student_id = ?;";

                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $_POST['student_id']);

                if($stmt->execute()){
                    $stmt->bind_result($studentId, $name, $surname, $birthDate, $country, $gender);
                    $stmt->fetch();

                    echo "<div class='form-wrapper'>
                        <p class='parameters'>Edit the current user</p><hr>
                        <form action='updated.php' method='POST'>
                            <div class='input-flex'>
                                <div>
                                    <label for='name' class='form-label'> First Name </label>
                                    <input type='text' name='name' id='name' value='". ucwords($name) ."' class='form-input'/>
                                </div>

                                <div>
                                    <label for='surname' class='form-label'> Last Name </label>
                                    <input type='text' name='surname' id='surname' value='". ucwords($surname) ."' class='form-input' />
                                </div>
                            </div>

                            <div class='input-flex'>
                                <div>
                                    <label for='student_id' class='form-label'> Student's ID </label>
                                    <input type='text' name='student_id' id='student_id' value='". $studentId ."' class='form-input' readonly/>
                                </div>

                                <div>
                                    <label class='form-label'>Gender</label>

                                    <select class='form-input' name='gender' id='gender'>
                                        <option value='". $gender ."' selected>". $gender ."</option>
                                        <option value='Male'>Male</option>
                                        <option value='Female'>Female</option>
                                        <option value='Others'>Others</option>
                                    </select>
                                </div>
                            </div>


                            <div class='mb-3'>
                                <label for='birth_date' class='form-label'> Birth Date </label>
                                <input type='date' name='birth_date' id='birth_date' class='form-input' value='". $birthDate ."'>
                            </div>

                            <div class='mb-3'>
                                <label for='country' class='form-label'> Country of Birth </label>
                
                                <select class='form-input' name='country' id='country'>";
                                    
                                
                                        $countryList = ['Afghanistan','Albania','Algeria','Andorra','Angola','Anguilla','Antigua &amp; Barbuda','Argentina','Armenia','Aruba','Australia','Austria','Azerbaijan','Bahamas','Bahrain','Bangladesh','Barbados','Belarus','Belgium','Belize','Benin','Bermuda','Bhutan','Bolivia','Bosnia &amp; Herzegovina','Botswana','Brazil','British Virgin Islands','Brunei','Bulgaria','Burkina Faso','Burundi','Cambodia','Cameroon','Cape Verde','Cayman Islands','Chad','Chile','China','Colombia','Congo','Cook Islands','Costa Rica','Cote D Ivoire','Croatia','Cruise Ship','Cuba','Cyprus','Czech Republic','Denmark','Djibouti','Dominica','Dominican Republic','Ecuador','Egypt','El Salvador','Equatorial Guinea','Estonia','Ethiopia','Falkland Islands','Faroe Islands','Fiji','Finland','France','French Polynesia','French West Indies','Gabon','Gambia','Georgia','Germany','Ghana','Gibraltar','Greece','Greenland','Grenada','Guam','Guatemala','Guernsey','Guinea','Guinea Bissau','Guyana','Haiti','Honduras','Hong Kong','Hungary','Iceland','India','Indonesia','Iran','Iraq','Ireland','Isle of Man','Israel','Italy','Jamaica','Japan','Jersey','Jordan','Kazakhstan','Kenya','Kuwait','Kyrgyz Republic','Laos','Latvia','Lebanon','Lesotho','Liberia','Libya','Liechtenstein','Lithuania','Luxembourg','Macau','Macedonia','Madagascar','Malawi','Malaysia','Maldives','Mali','Malta','Mauritania','Mauritius','Mexico','Moldova','Monaco','Mongolia','Montenegro','Montserrat','Morocco','Mozambique','Namibia','Nepal','Netherlands','Netherlands Antilles','New Caledonia','New Zealand','Nicaragua','Niger','Nigeria','Norway','Oman','Pakistan','Palestine','Panama','Papua New Guinea','Paraguay','Peru','Philippines','Poland','Portugal','Puerto Rico','Qatar','Reunion','Romania','Russia','Rwanda','Saint Pierre &amp; Miquelon','Samoa','San Marino','Satellite','Saudi Arabia','Senegal','Serbia','Seychelles','Sierra Leone','Singapore','Slovakia','Slovenia','South Africa','South Korea','Spain','Sri Lanka','St Kitts &amp; Nevis','St Lucia','St Vincent','St. Lucia','Sudan','Suriname','Swaziland','Sweden','Switzerland','Syria','Taiwan','Tajikistan','Tanzania','Thailand','Timor L\'Este','Togo','Tonga','Trinidad &amp; Tobago','Tunisia','Turkey','Turkmenistan','Turks &amp; Caicos','Uganda','Ukraine','United Arab Emirates','United Kingdom','Uruguay','Uzbekistan','Venezuela','Vietnam','Virgin Islands (US)','Yemen','Zambia','Zimbabwe'];
                                        foreach($countryList as $value){
                                            if ($value == $country){
                                                echo "<option value='". $country ."' selected>". $country ."</option>";
                                            }
                                            else{
                                                echo "<option value='". $value ."'>". $value ."</option>";
                                            }
                                            
                                        }
                                    
                                echo "</select>
                            </div><hr>";
                            $studentId = $conn->insert_id;
                            $stmt->close();

                            $existingContacts =  "SELECT DISTINCT type, value FROM student_contact c, student s WHERE c.student_id = ?;";
                            $stmt = $conn->prepare($existingContacts);
                            $stmt->bind_param("i", $studentId);

                            if ($stmt->execute()){
                                $result = $stmt->get_result();
                                $numRows = $result->num_rows;
                                if ($numRows > 0){
                                    $types = array();
                                    $values = array();
                                    while($contactsRow = $result->fetch_assoc()){
                                        $types[] = $contactsRow['type'];
                                        $values[] = $contactsRow['value'];
                                    }

                                    
                                    for ($i = 0; $i < count($types); $i++) {
                                        echo "<div class='input-flex'>";
                                        echo "<div>
                                                <label for='type_".$i."' class='form-label'> Type </label>
                                                <input type='text' name='type_".$i."' id='type_".$i."' value='". $types[$i] ."' class='form-input' readonly/>
                                            </div>
                                            <div>
                                                <label for='value_".$i."' class='form-label'> Value </label>
                                                <input type='text' name='value_".$i."' id='value_".$i."' value='". $values[$i] ."' class='form-input' readonly/>
                                            </div>
                                        </div>";
                                    }
                                }
                            }

                            

                            echo "<div class='mb-3'>
                                <label for='ncontacts' class='form-label'> How many contacts do you want to add </label>
                
                                <select class='form-input' name='ncontacts' id='ncontacts'>
                                    <option value='' selected >0</option>";
                                        for($i = 1; $i < 10; $i++){
                                            echo "<option value='". $i ."'>". $i ."</option>";
                                        }
                                echo "</select>
                            </div>

                            <div id='contactsWrapper'>

                            </div>

                            <input type='submit' value='Save' class='btn'>
                        </form>
                    </div>";
                }
                else{
                    die("Error: ".$conn->error);
                }
                ?>
            </div>;                                                   
        <?php
            include '../../coreComponents/footer.php'
        ?>
    </body>
</html>