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

            try{
                $renterQuery = "UPDATE renter SET renter_name = ?, renter_surname = ?, corporate_structure = ?, renter_type = ? WHERE renter_id = ?";
                
            
                $name = $_POST['renter_name'];
                $surname = $_POST['renter_surname'];
                $corporateStructure = $_POST['corporate_structure'];
                $renterType = $_POST['renter_type'];
                $renterId = $_POST['renter_id'];

                $stmt = $conn->prepare($renterQuery);
                $stmt->bind_param("ssssi", $name, $surname, $corporateStructure, $renterType, $referentId);
                
                
                if (($stmt->execute())) {
                    $stmt->close();
                } 
                else {
                    throw new Exception($conn->error);
                }

                $contactQuery = "INSERT INTO renter_contact VALUES(?, ?, ?)";
                $stmt = $conn->prepare($contactQuery);
               
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
                                throw new Exception("". $conn->error);
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
                        $stmt->bind_param("ssi", $contactValue, $type, $renterId);
                        if (!($stmt->execute())) {
                            throw new Exception($conn->error);
                        } 
                    }
                }
                
                $conn->commit();
                $stmt->close();
                echo "<script>location.href = 'landing.php';</script>";
            }
            catch (Exception $e){
                $conn->rollback();
                echo "<div class='error'>
                            Exception: ".$e->getMessage().". <br> 
                            <form method='POST' action='edit.php'>
                                <input type='hidden' name='referent_id' id='referent_id' value=". $referentId .">
                                <input type='submit' class='btn red' value='Go back to the form'>
                            </form>
                     </div>";
            }
            
        ?>
    </div>

    <?php
        include '../../coreComponents/footer.php'
    ?>
</body>
