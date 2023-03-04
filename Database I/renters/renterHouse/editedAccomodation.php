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

                $updateQuery = "UPDATE renter_accomodation ra SET ra.renter_id = ?, ra.accomodation_id = ?, ra.acquisition_date = ?, ra.sale_date = ? WHERE ra.renter_id = ? AND ra.accomodation_id = ?";
                $stmt = $conn->prepare($updateQuery);
                $stmt->bind_param("iissii", $renterId, $accomodationId, $acquisitionDate, $saleDate, $renterId, $accomodationId);

                
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
