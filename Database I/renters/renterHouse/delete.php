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
                $query = "SELECT r.* FROM renter r WHERE r.renter_id = ?;";

                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $_POST['renter_id']);

                if($stmt->execute()){
                    $stmt->bind_result($renterId, $name, $surname, $corpotareStructure, $renterType);
                    $stmt->fetch();

                    echo "<div class='form-wrapper'>
                        <p class='parameters'>Delete a renter from the current user<hr></p>
                        <form>
                            <div class='input-flex'>
                                <div>
                                    <label for='renter_name' class='form-label'> Name </label>
                                    <input type='text' name='renter_name' id='renter_name' value='". ucwords($name) ."' class='form-input'readonly/>
                                </div>";
                            
                            if(!empty($surname)){
                                echo"<div>
                                    <label for='renter_surname' class='form-label'> Last Name </label>
                                    <input type='text' name='renter_surname' id='renter_surname' value='". ucwords($surname) ."' class='form-input' readonly/>
                                </div>
                            </div>";
                            } else{
                                echo"<div>
                                    <label for='renter_surname' class='form-label'> Last Name </label>
                                    <input type='text' name='renter_surname' id='renter_surname' value='' class='form-input' readonly/>
                                </div>
                            </div>";
                            }
                                
                            echo"<div class='input-flex'>
                                <div>
                                    <label for='renter_id' class='form-label'> Renter's ID </label>
                                    <input type='text' name='renter_id' id='renter_id' value='". $renterId ."' class='form-input' readonly/>
                                </div>

                                <div>
                                    <label for='renter_type' class='form-label'>Gender</label>
                                    <input type='text' name='renter_type' id='renter_type' value='". $renterType ."' class='form-input' readonly/>
                                </div>
                            </div>";

                            if(!empty($coporateStructure)){
                                echo"<div class='mb-3'>
                                <label for='corporate_structure' class='form-label'> Corporate Structure </label>
                                <input type='text' name='corporate_structure' id='corporate_structure' class='form-input' value='". $corporateStructure ."' readonly>
                                </div></form><hr>";
                            } else {
                                echo"<div class='mb-3'>
                                <label for='corporate_structure' class='form-label'> Corporate Structure </label>
                                <input type='text' name='corporate_structure' id='corporate_structure' class='form-input' value='' readonly>
                                </div></form><hr>";
                            }
                            
                            $stmt->close();

                            $allHouses =  "SELECT DISTINCT a.accomodation_id, a.area, a.address FROM renter_accomodation ra, accomodation a WHERE ra.accomodation_id = a.accomodation_id AND ra.renter_id = ? AND ra.sale_date IS NULL";
                            $stmt = $conn->prepare($allHouses);
                            $stmt->bind_param("i", $renterId);

                            if ($stmt->execute()){
                                $result = $stmt->get_result();
                                $numRows = $result->num_rows;
                                if ($numRows > 0){
                                    $ids = array();
                                    $accomodationAreas = array();
                                    $accomodationAddresses = array();
                                    while($houseRow = $result->fetch_assoc()){
                                        $ids[] = $houseRow['accomodation_id'];
                                        $accomodationAreas[] = $houseRow['area'];
                                        $accomodationAddresses[] = $houseRow['address'];
                                    }

                                    
                                    for ($i = 0; $i < count($ids); $i++) {
                                        echo "<div class='input-flex'>";
                                        echo "<div>
                                                <label for='ex_acc_id".$i."' class='form-label'> Accomodation ID </label>
                                                <input type='text' name='ex_acc_id".$i."' id='ex_acc_id".$i."' value='". $ids[$i] ."' class='form-input' readonly/>
                                            </div>
                                            <div>
                                                <label for='ex_area".$i."' class='form-label'> Accomodation's Area </label>
                                                <input type='text' name='ex_area".$i."' id='ex_area".$i."' value='". $accomodationAreas[$i] ."' class='form-input' readonly/>
                                            </div>
                                            <div>
                                                <label for='ex_addr".$i."' class='form-label'> Referent's Type </label>
                                                <input type='text' name='ex_addr".$i."' id='ex_addr".$i."' value='". $accomodationAddresses[$i] ."' class='form-input' readonly/>
                                            </div>
                                                <div class='deleteButtons'>
                                                    <form method='POST' action='deleted.php'>
                                                        <input type='hidden' name='accomodation_id' value='". $ids[$i] ."' />
                                                        <input type='hidden' name='renter_id' value='". $renterId ."' />
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