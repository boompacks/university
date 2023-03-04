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
            $checkQuery = "SELECT a.* FROM accomodation a WHERE a.size = ? AND a.monthly_rent = ? AND a.address = ? AND a.area = ?";
            $stmt = $conn->prepare($checkQuery);
            
            $size = trim($_POST['size']);
            $rent = $_POST['monthly_rent'];
            $address = trim($_POST['address']);
            $number = $_POST['n_acc'];
            $cap = $_POST['cap'];
            $fullAddress = $address.", ". $number .", ". $cap;
            $area = $_POST['area'];

            $stmt->bind_param("siss", $size, $rent, $fullAddress, $area);

            if ($stmt->execute()) {
                $result = $stmt->get_result();
                $accomodationExists = $result->num_rows > 0;
                $stmt->close();
            } else {
                throw new Exception($conn->error);
            }

            if($accomodationExists){
                throw new Exception("Accomodation already exists.");
            }
            $insertQuery = "INSERT INTO accomodation (size, monthly_rent, address, area) VALUES (?, ?, ?, ?);";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param("ssss", $size, $rent, $fullAddress, $area);
    
            if (!($stmt->execute())) {
                throw new Exception($conn->error);
            } 
            
            $stmt->close();
            $conn->commit();
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


