<html>
    <head>
        <title>AccaHousingME - Edit user</title>
        <link rel='stylesheet' href='../../styles/styles.css'>
        <link rel='stylesheet' href='../../styles/form.css'>
        <link rel='stylesheet' href='../../styles/table.css'>
        <link rel='preconnect' href='https://fonts.googleapis.com'>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
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
                        <p class='parameters'>Delete a renter from the current user<hr></p>
                        <form>
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
                                    <label for='referent_id' class='form-label'> Student's ID </label>
                                    <input type='text' name='referent_id' id='referent_id' value='". $referentId ."' class='form-input' readonly/>
                                </div>

                                <div>
                                    <label for='referent_gender' class='form-label'>Gender</label>
                                    <input type='text' name='referent_gender' id='referent_gender' value='". $gender ."' class='form-input' readonly/>
                                </div>
                            </div>


                            <div class='mb-3'>
                                <label for='referent_birth_date' class='form-label'> Birth Date </label>
                                <input type='text' name='referent_birth_date' id='referent_birth_date' class='form-input' value='". $birthDate ."'>
                            </div></form><hr>";
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
                                                <label for='ex_ref_id".$i."' class='form-label'> Renter ID </label>
                                                <input type='text' name='ex_renter_id".$i."' id='ex_renter_id".$i."' value='". $ids[$i] ."' class='form-input' readonly/>
                                            </div>
                                            <div>
                                                <label for='ex_renter_name".$i."' class='form-label'> Renter's Name </label>
                                                <input type='text' name='ex_renter_name".$i."' id='ex_renter_name".$i."' value='". $renterNames[$i] ."' class='form-input' readonly/>
                                            </div>
                                            <div>
                                                <label for='ex_renter_surname".$i."' class='form-label'> Referent's Type </label>
                                                <input type='text' name='ex_renter_surname".$i."' id='ex_renter_surname".$i."' value='". $renterTypes[$i] ."' class='form-input' readonly/>
                                            </div>
                                                <div class='deleteButtons'>
                                                    <form method='POST' action='deleted.php'>
                                                        <input type='hidden' name='referent_id' value='". $referentId ."' />
                                                        <input type='hidden' name='renter_id' value='". $ids[$i] ."' />
                                                        <button type='submit'>
                                                            <i class='fa-solid fa-trash delete'></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>";
                                    }
                                }
                            }
                    echo "</div>";
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