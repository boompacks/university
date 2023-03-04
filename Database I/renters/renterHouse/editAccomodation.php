<html>
    <head>
        <title>AccaHousingME - Edit</title>
        <link rel='stylesheet' href='../../styles/styles.css'>
        <link rel='stylesheet' href='../../styles/form.css'>
        <link rel='stylesheet' href='../../styles/table.css'>
        <script src='../../scripts/accomodationData.js' defer></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
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
                $query = "SELECT acquisition_date, sale_date FROM renter_accomodation ra WHERE ra.renter_id = ? AND ra.accomodation_id = ?;";

                $renterId = $_POST['renter_id'];
                $accomodationId = $_POST['accomodation_id'];

                $stmt = $conn->prepare($query);
                $stmt->bind_param("ii", $renterId, $accomodationId);

                if($stmt->execute()){
                    $stmt->bind_result($acquisitionDate, $saleDate);
                    $stmt->fetch();

                    echo "<div class='form-wrapper'>
                        <p class='parameters'>Edit the data for the current accomodation<hr></p>
                        <form action='editedAccomodation.php' method='POST'>
                            <div class='input-flex'>
                                <div>
                                    <label for='renter_id' class='form-label'> Renter ID </label>
                                    <input type='text' name='renter_id' id='renter_id' value='". $renterId ."' class='form-input' />
                                </div>

                                <div>
                                    <label for='accomodation_id' class='form-label'> Accomodation ID </label>
                                    <input type='text' name='accomodation_id' id='accomodation_id' value='". $accomodationId ."' class='form-input'/>
                                </div>
                            </div>

                            <div class='input-flex'>
                                <div>
                                    <label for='acquisition_date' class='form-label'> Acquisition Date </label>
                                    <input type='date' name='acquisition_date' id='acquisition_date' value='". $acquisitionDate ."' class='form-input'/>
                                </div>

                                <div>
                                    <label class='form-label'>Sale Date</label>
                                    <input type='date' name='sale_date' id='sale_date' value='". $saleDate ."' class='form-input'/>
                                </div>
                            </div>";

                            $stmt->close();

                            
                        echo "<input type='submit' value='Save' class='btn'>
                        </form>";
                        echo "</div>";
                }
                else{
                    die("Error: ".$conn->error);
                }
                ?>
            </div>;                                                   
        <?php
            include '../../coreComponents/footer.php'
        ?>
    </body>
</html>