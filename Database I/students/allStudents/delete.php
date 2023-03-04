<html>
    <head>
        <title>AccaHousingME - Edit user</title>
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
                $query = "DELETE FROM student WHERE student_id = ?;";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $_POST['student_id']);

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