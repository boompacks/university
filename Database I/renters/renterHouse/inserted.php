<head>
    <title>AccaHousingME - Inserted</title>
    <link rel="stylesheet" href="../../styles/styles.css">
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
            $accomodationId = $_POST['accomodation_id'];
            $renterId = $_POST['renter_id'];
            $acquisitionDate = $_POST['acquisition_date'];
            if (isset($_POST['sale_date'])){
                $saleDate = $_POST['sale_date'];
            }

            $renterCheckQuery = "SELECT ra.renter_id FROM renter_accomodation ra WHERE ra.accomodation_id = ? AND ra.sale_date IS NULL";
            $renterCheck = $conn->prepare($renterCheckQuery);
            $renterCheck->bind_param("i", $accomodationId);

            if ($renterCheck->execute()) {
                $result = $renterCheck->get_result();
                $accomodationHasOwner = $result->num_rows > 0;
                $renterCheck->close();
            } else {
                throw new Exception("".$conn->error);
            }

            if($accomodationHasOwner){
                throw new Exception("This accomodation has already an owner");
            }
            
            if ($saleDate){
                $insertQuery = "INSERT INTO renter_accomodation(renter_id, accomodation_id, acquisition_date, sale_date) VALUES (?, ?, ?, ?)";
            }
            else {
                $insertQuery = "INSERT INTO renter_accomodation(renter_id, accomodation_id, acquisition_date) VALUES (?, ?, ?)";
            }
            
            $stmt = $conn->prepare($insertQuery);

            if ($saleDate){
                $stmt->bind_param("iiss", $renterId, $accomodationId, $acquisitionDate, $saleDate);
            }
            else {
                $stmt->bind_param("iis", $renterId, $accomodationId, $acquisitionDate);
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

    <?php
        include '../../coreComponents/footer.php'
    ?>
</body>


