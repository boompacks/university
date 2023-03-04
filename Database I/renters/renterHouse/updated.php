<head>
    <title>AccaHousingME - Updated</title>
    <link rel="stylesheet" href="../../styles/styles.css">
    <link rel="stylesheet" href="../../styles/form.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro&display=swap" rel="stylesheet">
</head>

<body>
    <div class="content">    
        <?php
            include '../../coreComponents/header3.php';
            include '../../db.php';

            $conn->begin_transaction();
            try {
                $renterId = $_POST['renter_id'];
                $accomodationId = $_POST['accomodation_id'];
                $acquisitionDate = $_POST['acquisition_date'];
                $saleDate = $_POST['sale_date'];
                
                $checkQuery = "SELECT ra.renter_id, ra.accomodation_id FROM renter_accomodation ra WHERE ra.accomodation_id = ? AND ra.renter_id = ?;";
                $stmtCheck = $conn->prepare($checkQuery);
                $stmtCheck->bind_param("ii", $accomodationId, $renterId);

                if ($stmtCheck->execute()) {
                    $result = $stmtCheck->get_result();
                    $houseAlreadyOwned = $result->num_rows > 0;
                    $stmtCheck->close();
                } else {
                    throw new Exception($conn->error);
                }

                if($houseAlreadyOwned){
                    throw new Exception("This house has already got an owner");
                }
                
                if(isset($_POST['sale_date']) && !empty($_POST['sale_date'])){
                    $insertQuery = "INSERT INTO renter_accomodation(accomodation_id, renter_id, acquisition_date, sale_date) VALUES (?, ?, ?, ?);";
                }
                else {
                    $insertQuery = "INSERT INTO renter_accomodation(accomodation_id, renter_id, acquisition_date, sale_date) VALUES (?, ?, ?, NULL);";
                }
                
                $stmt = $conn->prepare($insertQuery);

                if(isset($_POST['sale_date']) && !empty($_POST['sale_date'])){
                    $stmt->bind_param("iiss", $accomodationId, $renterId, $acquisitionDate, $saleDate);
                }
                else {
                    $stmt->bind_param("iis", $accomodationId, $renterId, $acquisitionDate);
                }
                
        
                if (!($stmt->execute())) {
                    throw new Exception($conn->error);
                } 
                
                $conn->commit();
                $stmt->close();
                echo "<script>location.href = 'landing.php';</script>";
            } 
            catch (Exception $e) {
                $conn->rollback();
                echo "<div class='error'>
                            Exception: ".$e->getMessage().". <br> <a href='insert.php' class='black'>Go back to the form</a>
                    </div>";
            }
        ?>
    </div>

    <?php
        include '../../coreComponents/footer.php'
    ?>
</body>
