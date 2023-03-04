<html>
    <head>
        <title>AccaHousingME - Edit</title>
        <link rel='stylesheet' href='../../styles/styles.css'>
        <link rel='stylesheet' href='../../styles/form.css'>
        <script src='../../scripts/renterData.js' defer></script>
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
                $query = "SELECT r.* FROM referent r WHERE r.referent_id = ?;";

                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $_POST['referent_id']);

                if($stmt->execute()){
                    $stmt->bind_result($referentId, $name, $surname, $birthDate, $gender);
                    $stmt->fetch();

                    echo "<div class='form-wrapper'>
                        <p class='parameters'>Edit the current user referent data<hr></p>
                        <form action='updated.php' method='POST'>
                            <div class='input-flex'>
                                <div>
                                    <label for='referent_name' class='form-label'> First Name </label>
                                    <input type='text' name='referent_name' id='referent_name' value='". ucwords($name) ."' class='form-input'readonly/>
                                </div>

                                <div>
                                    <label for='referent_surname' class='form-label'> Last Name </label>
                                    <input type='text' name='referent_surname' id='referent_surname' value='". ucwords($surname) ."' class='form-input' readonly/>
                                </div>
                            </div>

                            <div class='input-flex'>
                                <div>
                                    <label for='referent_id' class='form-label'> Referent's ID </label>
                                    <input type='text' name='referent_id' id='referent_id' value='". $referentId ."' class='form-input' readonly/>
                                </div>

                                <div>
                                    <label class='form-label'>Gender</label>
                                    <input type='text' name='referent_gender' id='referent_gender' value='". $gender ."' class='form-input' readonly/>
                                </div>
                            </div>


                            <div class='mb-3'>
                                <label for='referent_birth_date' class='form-label'> Birth Date </label>
                                <input type='text' name='referent_birth_date' id='referent_birth_date' class='form-input' value='". $birthDate ."'>
                            </div>";
                            $stmt->close();

                            $allRenters =  "SELECT DISTINCT rr.renter_id, r.renter_name, r.renter_type FROM referent_renter rr, renter r WHERE rr.renter_id = r.renter_id AND rr.referent_id = ?;";
                            $stmt = $conn->prepare($allRenters);
                            $stmt->bind_param("i", $referentId);

                            if ($stmt->execute()){
                                $result = $stmt->get_result();
                                $numRows = $result->num_rows;
                                if ($numRows > 0){
                                    $ids = array();
                                    $renterNames = array();
                                    $renterTypes = array();
                                    while($renterRow = $result->fetch_assoc()){
                                        $ids[] = $renterRow['renter_id'];
                                        $renterNames[] = $renterRow['renter_name'];
                                        $renterTypes[] = $renterRow['renter_type'];
                                    }

                                    
                                    for ($i = 0; $i < count($ids); $i++) {
                                        echo "<div class='input-flex'>";
                                        echo "<div>
                                                <label for='ex_renter_id".$i."' class='form-label'> Renter ID </label>
                                                <input type='text' name='ex_renter_id".$i."' id='ex_renter_id".$i."' value='". $ids[$i] ."' class='form-input' readonly/>
                                            </div>
                                            <div>
                                                <label for='ex_renter_name".$i."' class='form-label'> Renter Name </label>
                                                <input type='text' name='ex_renter_name".$i."' id='ex_renter_name".$i."' value='". $renterNames[$i] ."' class='form-input' readonly/>
                                            </div>
                                            <div>
                                                <label for='ex_renter_type".$i."' class='form-label'> Renter Type </label>
                                                <input type='text' name='ex_renter_type".$i."' id='ex_renter_type".$i."' value='". $renterTypes[$i] ."' class='form-input' readonly/>
                                            </div>
                                        </div>";
                                    }
                                }
                            }

                            
                            echo "<hr><p>Insert the new renter below</p>";
                            echo "<div class='input-flex'>";
                                        
                                        echo "<div>
                                                <label for='renter_id' class='form-label'> Renter ID </label>
                                                <select name='renter_id' id='renter_id' class='form-input'>
                                                    <option selected hidden disabled>Choose Renter's ID</option>";
                                                
                                                $allRenters =  "SELECT DISTINCT renter_id FROM renter;";
                                                $stmt = $conn->prepare($allRenters);
                                                $stmt->bind_result($id);

                                                if ($stmt->execute()){
                                                    while($stmt->fetch()){ 
                                                        echo "<option value='". $id ."'>". $id ."</option>";
                                                    }
                                                }
                                                include 'getRenter.php';

                                                echo "</select>
                                            </div>
                                            <div>
                                                <label for='renter_name' class='form-label'> Renter Name </label>
                                                <input type='text' name='renter_name' id='renter_name' placeholder='Renter's Name' class='form-input'/>
                                            </div>
                                            <div>
                                                <label for='renter_type' class='form-label'> Renter Type </label>
                                                <input type='text' name='renter_type' id='renter_type' placeholder='Renter's Type' class='form-input'/>
                                            </div>
                                        </div>";
                                        

                            echo "<input type='submit' value='Save' class='btn'>
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