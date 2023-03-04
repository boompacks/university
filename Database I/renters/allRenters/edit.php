<html>
    <head>
        <title>AccaHousingME - Edit user</title>
        <link rel='stylesheet' href='../../styles/styles.css'>
        <link rel='stylesheet' href='../../styles/form.css'>
        <script src="../../scripts/contacts.js" defer></script>
        <script src="../../scripts/disableInput.js" defer></script>
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
                $query = "SELECT r.* FROM renter r WHERE r.renter_id = ?;";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $_POST['renter_id']);

                if($stmt->execute()){
                    $stmt->bind_result($renterId, $name, $surname, $corporateCtructure, $renterType);
                    
                    
                    $stmt->fetch();

                    echo "<div class='form-wrapper'>
                        <p class='parameters'>Edit the current user</p><hr>
                        <form action='updated.php' method='POST'>
                            <div class='input-flex'>
                                <div>
                                    <label for='renter_name' class='form-label'> Name </label>
                                    <input type='text' name='renter_name' id='renter_name' value='". ucwords($name) ."' class='form-input'/>
                                </div>

                                <div>
                                    <label for='referent_surname' class='form-label'> Last Name </label>
                                    <input type='text' name='referent_surname' id='referent_surname' value='". ucwords($surname) ."' class='form-input' readonly/>
                                </div>
                            </div>

                            <div class='input-flex'>
                                <div>
                                    <label for='renter_id' class='form-label'> Renter's ID </label>
                                    <input type='text' name='renter_id' id='renter_id' value='". $renterId ."' class='form-input' readonly/>
                                </div>

                                <div>
                                    <label class='form-label'>Type</label>

                                    <select class='form-input' name='renter_type' id='renter_type'>
                                        <option value='". $renterType ."' selected>". $renterType ."</option>
                                        <option value='Agency'>Agency</option>
                                        <option value='Landlord'>Landlord</option>
                                    </select>
                                </div>
                            </div>

                            <div class='input-flex'>
                                <div>
                                    <label for='corporate_structure' class='form-label'> Corporate Structure </label>
                                    <input type='text' name='corporate_structure' id='corporate_structure' value='". $corporateCtructure ."' class='form-input' readonly/>
                                </div>
                            </div>
                            <hr>";
                            $renterId = $conn->insert_id;
                            $stmt->close();

                            $existingContacts =  "SELECT DISTINCT c.type, c.value FROM renter_contact c, renter r WHERE c.renter_id = ?;";
                            $stmt = $conn->prepare($existingContacts);
                            $stmt->bind_param("i", $renterId);

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