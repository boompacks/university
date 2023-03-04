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
                $startDate = $_POST['start_date'];
                $endDate = $_POST['end_date'];
                $accomodationId = $_POST['accomodation_id'];
                $studentId = $_POST['student_id'];
    
                if ($startDate > $endDate){
                    throw new Exception("End Date has to be after the Start Date");
                }
    
    
                $studentCheckQuery = "SELECT ac.end_date FROM student_accomodation ac WHERE ac.start_date = (SELECT MAX(start_date) FROM student_accomodation ac1 WHERE ac1.student_id = ?);";
                $studentCheck = $conn->prepare($studentCheckQuery);
                $studentCheck->bind_param("i", $studentId);
    
                if ($studentCheck->execute()) {
                    $result = $studentCheck->get_result();
                    $lastEndDate = $result->fetch_assoc();
                    $studentHasAccomodation = $lastEndDate['end_date'] > $_POST['start_date'];
                    $studentCheck->close();
                } else {
                    throw new Exception($conn->error);
                }
    
                if($studentHasAccomodation){
                    throw new Exception("Student has already been assigned to an accomodation");
                }

                $houseCheckQuery = "SELECT ac.* 
                FROM student_accomodation ac 
                WHERE ac.accomodation_id = ? 
                AND (ac.start_date <= ? AND ac.end_date >= ?)";
                
                $houseCheck = $conn->prepare($houseCheckQuery);
                $houseCheck->bind_param("iss", $accomodationId, $startDate, $endDate);

                if ($houseCheck->execute()) {
                    $result = $houseCheck->get_result();
                    $houseIsOccupied = $result->num_rows;
                    $houseCheck->close();
                } else {
                    throw new Exception($conn->error);
                }

                if($houseIsOccupied){
                    throw new Exception("This accomodation is occupied");
                }

                
                $insertQuery = "INSERT INTO student_accomodation (student_id, accomodation_id, start_date, end_date) VALUES (?, ?, ?, ?);";
                $stmt = $conn->prepare($insertQuery);
                $stmt->bind_param("iiss", $studentId, $accomodationId, $startDate, $endDate);
        
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
                            Exception: ".$e->getMessage().". <br> <a href='landing.php' class='black'>Go back to the table view</a>
                      </div>";
            }
        ?>
    </div>

    <?php
        include '../../coreComponents/footer.php'
    ?>
</body>
