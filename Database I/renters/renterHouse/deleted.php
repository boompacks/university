<html>
    <head>
        <title>AccaHousingME - Deleted</title>
        <link rel='stylesheet' href='../../styles/styles.css'>
        <link rel='stylesheet' href='../../styles/form.css'>
        <link rel='preconnect' href='https://fonts.googleapis.com'>
        <link rel='preconnect' href='https://fonts.gstatic.com' crossorigin>
        <link href='https://fonts.googleapis.com/css2?family=Source+Sans+Pro&display=swap' rel='stylesheet'>
    </head>

    <body>
        <div class='content'>
            <?php 
                    include '../../coreComponents/header3.php';
                    include '../../db.php';
            ?>

            <?php
                $accomodationId = $_POST['accomodation_id'];
                $renterId = $_POST['renter_id'];
            
                $query = "DELETE FROM renter_accomodation WHERE accomodation_id = ? AND renter_id = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("ii", $accomodationId, $renterId);

                if($stmt->execute()){
                    echo "<script>location.href = 'landing.php';</script>";
                }
                else{
                    die($conn->error);
                }
            ?>
        </div>;                                                   
        <?php
            include '../../coreComponents/footer.php'
        ?>
    </body>
</html>