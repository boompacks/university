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
            $referentCheckQuery = "SELECT * FROM referent WHERE referent_name = ? AND referent_surname = ? AND referent_birth_date = ? AND referent_gender = ?;";
            $referentCheck = $conn->prepare($referentCheckQuery);
            
            $name = trim($_POST['referent_name']);
            $surname = trim($_POST['referent_surname']);
            $gender = trim($_POST['referent_gender']);
            $birthDate = date("Y-m-d", strtotime($_POST['referent_birth_date']));

            $referentCheck->bind_param("ssss", $name, $surname, $birthDate, $gender);

            if ($referentCheck->execute()) {
                $result = $referentCheck->get_result();
                $referentExists = $result->num_rows > 0;
                $referentCheck->close();
            } else {
                throw new Exception("Error: " . $conn->error);
            }

            if($referentExists){
                throw new Exception("Error: referent already exists.");
            }
            $referentsQuery = "INSERT INTO referent (referent_name, referent_surname, referent_birth_date, referent_gender) VALUES (?, ?, ?, ?);";
            $stmt = $conn->prepare($referentsQuery);
            $stmt->bind_param("ssss", $name, $surname, $birthDate, $gender);
    
            if (!($stmt->execute())) {
                throw new Exception("Error: " . $conn->error);
            } 
            
            $stmt->close();
    
            $referentId = $conn->insert_id;
            $contactsQuery = "INSERT INTO referent_contact (value, type, referent_id) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($contactsQuery);
    
            for($i = 0; isset($_POST['type'.$i]); $i++){
                $type = trim($_POST['type'.$i]);
                $contactValue = trim($_POST['value'.$i]);
        
                if ($type == 'Email') {
                    $pattern = "/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/";
                    if (preg_match($pattern, $contactValue)) {
                        $emailCheckQuery = "SELECT * FROM referent_contact WHERE value = ?";
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

                    $phoneCheckQuery = "SELECT * FROM referent_contact WHERE value = ?";
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
                    $stmt->bind_param("ssi", $contactValue, $type, $referentId);
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


