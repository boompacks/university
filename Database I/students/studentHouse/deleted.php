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
                $query = "DELETE FROM student_accomodation WHERE student_id = ? AND accomodation_id = ? AND start_date = ?;";
                $stmt = $conn->prepare($query);

                $studentId = $_POST['student_id'];
                $accomodationId = $_POST['accomodation_id'];
                $startDate = $_POST['start_date'];



                $stmt->bind_param("iis", $studentId, $accomodationId, $startDate);

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