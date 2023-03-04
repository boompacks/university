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
            $referentId = $_POST['referent_id'];
            $studentId = $_POST['student_id'];

            $studentReferentCheckQuery = "SELECT sr.student_id, sr.referent_id FROM student_referent sr WHERE student_id = ? AND referent_id = ?;";
            $studentReferentCheck = $conn->prepare($studentReferentCheckQuery);
            $studentReferentCheck->bind_param("ii", $studentId, $referentId);

            if ($studentReferentCheck->execute()) {
                $result = $studentReferentCheck->get_result();
                $studentReferentExists = $result->num_rows > 0;
                $studentReferentCheck->close();
            } else {
                throw new Exception($conn->error);
            }
            
            if($studentReferentExists){
                throw new Exception("Student has already been assigned to this referent");
            }
            
            $insertQuery = "INSERT INTO student_referent (student_id, referent_id) VALUES (?, ?);";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param("ii", $studentId, $referentId);
    
            if (!($stmt->execute())) {
                throw new Exception($stmt->error);
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


