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
                $updateQuery = "UPDATE accomodation a SET a.size = ?, a.monthly_rent = ?, a.address = ?, a.area = ? WHERE a.accomodation_id = ?";
            
                $size = $_POST['size'];
                $rent = $_POST['monthly_rent'];
                $address = trim($_POST['address']);
                $number = $_POST['n_acc'];
                $cap = $_POST['cap'];
                $fullAddress = $address.", ". $number .", ". $cap;
                $area = $_POST['area'];
                $accomodationId = $_POST['accomodation_id'];

                $stmt = $conn->prepare($updateQuery);
                $stmt->bind_param("sissi", $size, $rent, $fullAddress, $area, $accomodationId);
                
                
                if (($stmt->execute())) {
                    $stmt->close();
                } 
                else {
                    throw new Exception($conn->error);
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
