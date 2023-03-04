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
            $studentCheckQuery = "SELECT * FROM student WHERE name = ? AND surname = ? AND birth_date = ? AND country = ? AND gender = ?;";
            $studentCheck = $conn->prepare($studentCheckQuery);
            
            $name = trim($_POST['name']);
            $surname = trim($_POST['surname']);
            $gender = trim($_POST['gender']);
            $birthDate = date("Y-m-d", strtotime($_POST['birth_date']));
            $country = trim($_POST['country']);

            $studentCheck->bind_param("sssss", $name, $surname, $birthDate, $country, $gender);

            if ($studentCheck->execute()) {
                $result = $studentCheck->get_result();
                $studentExists = $result->num_rows > 0;
                $studentCheck->close();
            } else {
                throw new Exception("Error: " . $conn->error);
            }

            if($studentExists){
                throw new Exception("Error: Student already exists.");
            }
            $studentsQuery = "INSERT INTO student (name, surname, birth_date, country, gender) VALUES (?, ?, ?, ?, ?);";
            $stmt = $conn->prepare($studentsQuery);
            $stmt->bind_param("sssss", $name, $surname, $birthDate, $country, $gender);
    
            if (!($stmt->execute())) {
                throw new Exception($conn->error);
            } 
            $stmt->close();

    
            $studentId = $conn->insert_id;
            $contactsQuery = "INSERT INTO student_contact (value, type, student_id) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($contactsQuery);
    
            for($i = 0; isset($_POST['type'.$i]); $i++){
                $type = trim($_POST['type'.$i]);
                $contactValue = trim($_POST['value'.$i]);
        
                if ($type == 'Email') {
                    $pattern = "/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/";
                    if (preg_match($pattern, $contactValue)) {
                        $emailCheckQuery = "SELECT * FROM student_contact WHERE value = ?";
                        $emailCheck = $conn->prepare($emailCheckQuery);
                        $emailCheck->bind_param("s", $contactValue);

                        if ($emailCheck->execute()) {
                            $result = $emailCheck->get_result();
                            $emailExists = $result->num_rows > 0;
                            $emailCheck->close();
                        } else {
                            throw new Exception($conn->error);
                        }
            
                        if ($emailExists) {
                            throw new Exception("Email already exists.");
                        }
                    } 
                    else {
                        throw new Exception("Email must be in the right format.");
                    }
                }
                else {
                    if(!(preg_match('/^[0-9]{10}+$/', $contactValue))) {
                        throw new Exception("Phone number must be in the right format.");
                    }

                    $phoneCheckQuery = "SELECT * FROM student_contact WHERE value = ?";
                    $phoneCheck = $conn->prepare($phoneCheckQuery);
                    $phoneCheck->bind_param("s", $contactValue);

                    if ($phoneCheck->execute()) {
                        $result = $phoneCheck->get_result();
                        $phoneExists = $result->num_rows > 0;
                        $phoneCheck->close();
                    } else {
                        throw new Exception($conn->error);
                    }
        
                    if ($phoneExists) {
                        throw new Exception("Phone already exists.");
                    }
                }
        
                if(isset($type) && isset($contactValue)){
                    $stmt->bind_param("ssi", $contactValue, $type, $studentId);
                    if (!($stmt->execute())) {
                        throw new Exception($conn->error);
                    } 
                }
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


