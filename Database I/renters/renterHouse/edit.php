<html>
    <head>
        <title>AccaHousingME - Edit</title>
        <link rel='stylesheet' href='../../styles/styles.css'>
        <link rel='stylesheet' href='../../styles/form.css'>
        <link rel='stylesheet' href='../../styles/table.css'>
        <script src='../../scripts/accomodationData.js' defer></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
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
                    $stmt->bind_result($renterId, $name, $surname, $corporateStructure, $renterType);
                    $stmt->fetch();

                    echo "<div class='form-wrapper'>
                        <p class='parameters'>Edit the current user referent data<hr></p>
                        <form action='updated.php' method='POST'>
                            <div class='input-flex'>
                                <div>
                                    <label for='renter_name' class='form-label'> First Name </label>
                                    <input type='text' name='renter_name' id='renter_name' value='". ucwords($name) ."' class='form-input'readonly/>
                                </div>

                                <div>
                                    <label for='renter_surname' class='form-label'> Last Name </label>
                                    <input type='text' name='renter_surname' id='renter_surname' value='". ucwords($surname) ."' class='form-input' readonly/>
                                </div>
                            </div>

                            <div class='input-flex'>
                                <div>
                                    <label for='renter_id' class='form-label'> Renter's ID </label>
                                    <input type='text' name='renter_id' id='renter_id' value='". $renterId ."' class='form-input' readonly/>
                                </div>

                                <div>
                                    <label class='form-label'>Type</label>
                                    <input type='text' name='renter_type' id='renter_type' value='". $renterType ."' class='form-input' readonly/>
                                </div>
                            </div>


                            <div class='mb-3'>
                                <label for='corporate_structure' class='form-label'> Corporate Structure </label>
                                <input type='text' name='corporate_structure' id='corporate_structure' class='form-input' value='". $corporateStructure ."'>
                            </div>";
                            $stmt->close();

                            echo "<hr><p>Insert a new accomodation below</p>";
                            echo "<div class='input-flex'>";
                                        
                                        echo "<div>
                                                <label for='accomodation_id' class='form-label'> Accomodation ID </label>
                                                <select name='accomodation_id' id='accomodation_id' class='form-input'>
                                                    <option selected hidden disabled>Choose Accomodation's ID</option>";
                                                
                                                $allRenters =  "SELECT DISTINCT accomodation_id FROM accomodation;";
                                                $stmt = $conn->prepare($allRenters);
                                                $stmt->bind_result($id);

                                                if ($stmt->execute()){
                                                    while($stmt->fetch()){ 
                                                        echo "<option value='". $id ."'>". $id ."</option>";
                                                    }
                                                }
                                                include 'getAccomodation.php';

                                                echo "</select>
                                            </div>
                                            <div>
                                                <label for='area' class='form-label'> Area </label>
                                                <input type='text' name='area' id='area' placeholder='Area' class='form-input'/>
                                            </div>
                                    </div>";
                                    echo "<div class='input-flex'>";
                                        echo "<div>
                                                <label for='acquisition_date' class='form-label'> Acquisition Date </label>
                                                <input type='date' name='acquisition_date' id='acquisition_date' placeholder='Acquisition Date' class='form-input'/>
                                            </div>
                                            <div>
                                                <label for='sale_date' class='form-label'> Sale Date </label>
                                                <input type='date' name='sale_date' id='sale_date' placeholder='Sale Date' class='form-input'/>
                                            </div>
                                            </div>";

                                                

                                    echo "<input type='submit' value='Save' class='btn'>
                                        </form><hr>";





                            $allHouses =  "SELECT DISTINCT ra.accomodation_id, ra.acquisition_date, ra.sale_date FROM renter_accomodation ra WHERE ra.sale_date IS NULL AND ra.renter_id = ?;";
                            $stmt = $conn->prepare($allHouses);
                            $stmt->bind_param("i", $renterId);

                            if ($stmt->execute()){
                                $result = $stmt->get_result();
                                $numRows = $result->num_rows;
                                if ($numRows > 0){
                                    $ids = array();
                                    $acquisitionDates = array();
                                    $saleDates = array();
                                    while($houseRow = $result->fetch_assoc()){
                                        $ids[] = $houseRow['accomodation_id'];
                                        $acquisitionDates[] = $houseRow['acquisition_date'];
                                        $saleDates[] = $houseRow['sale_date'];
                                    }

                                    
                                    for ($i = 0; $i < count($ids); $i++) {
                                        echo "<div class='input-flex'>";
                                            echo "<div>
                                                    <label for='ex_acc_id".$i."' class='form-label'> Accomodation ID </label>
                                                    <input type='text' name='ex_acc_id".$i."' id='ex_acc_id".$i."' value='". $ids[$i] ."' class='form-input' readonly/>
                                                </div>
                                                <div>
                                                    <label for='ex_acq_date".$i."' class='form-label'> Acquisition Date </label>
                                                    <input type='text' name='ex_acq_date".$i."' id='ex_acq_date".$i."' value='". $acquisitionDates[$i] ."' class='form-input' readonly/>
                                                </div>
                                                <div>
                                                    <label for='ex_sale_date".$i."' class='form-label'> Sale Date </label>
                                                    <input type='text' name='ex_sale_date".$i."' id='ex_sale_date".$i."' value='". $saleDates[$i] ."' class='form-input' readonly/>
                                                </div>
                                                
                                                <div class='deleteButtons'>
                                                        <form method='POST' action='editAccomodation.php'>
                                                            <input type='hidden' name='renter_id' value='". $renterId ."' />
                                                            <input type='hidden' name='accomodation_id' value='". $ids[$i] ."' />
                                                            <button type='submit'>
                                                                <i class='fa-solid fa-pen-to-square edit'></i>
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