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
            $renterId = $_POST['renter_id'];
            $referentId = $_POST['referent_id'];

            $renterReferentCheckQuery = "SELECT rr.referent_id, rr.renter_id FROM referent_renter rr WHERE rr.referent_id = ? AND rr.renter_id = ?;";
            $renterReferentCheck = $conn->prepare($renterReferentCheckQuery);
            $renterReferentCheck->bind_param("ii", $referentId, $renterId);

            if ($renterReferentCheck->execute()) {
                $result = $renterReferentCheck->get_result();
                $renterAlreadyAssigned = $result->num_rows > 0;
                $renterReferentCheck->close();
            } else {
                throw new Exception($conn->error);
            }

            if($renterAlreadyAssigned){
                throw new Exception("This renter is already is contact with this referent");
            }
            
            $insertQuery = "INSERT INTO referent_renter(referent_id, renter_id) VALUES (?, ?);";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param("ii", $referentId, $renterId);
    
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


