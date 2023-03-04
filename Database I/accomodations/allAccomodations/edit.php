<html>
    <head>
        <title>AccaHousingME - Edit user</title>
        <link rel='stylesheet' href='../../styles/styles.css'>
        <link rel='stylesheet' href='../../styles/form.css'>
        <script src="../../scripts/contacts.js" defer></script>
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
                $query = "SELECT a.* FROM accomodation a WHERE a.accomodation_id = ?;";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $_POST['accomodation_id']);

                if($stmt->execute()){
                    $stmt->bind_result($accomodationId, $size, $rent, $fullAddress, $area);
                    $stmt->fetch();

                    $arrayAddress = explode(", ", $fullAddress);
                    $address = $arrayAddress[0];
                    $nAcc = $arrayAddress[1];
                    $cap = $arrayAddress[2];

                    echo "<div class='form-wrapper'>
                        <p class='parameters'>Edit the current user</p><hr>
                        <form action='updated.php' method='POST'>
                            <div class='input-flex'>
                                <div>
                                    <label for='accomodation_id' class='form-label'> Accomodation ID </label>
                                    <input type='text' name='accomodation_id' id='accomodation_id' value='". $accomodationId ."' class='form-input' readonly/>
                                </div>

                                <div>
                                    <label for='size' class='form-label'> Size </label>
                                    <input type='text' name='size' id='size' value='". $size ."' class='form-input' required/>
                                </div>
                            </div>

                            <div class='input-flex'>
                                <div>
                                    <label for='monthly_rent' class='form-label'> Rent </label>
                                    <input type='text' name='monthly_rent' id='monthly_rent' value='". $rent ."' class='form-input' required/>
                                </div>

                                <div>
                                    <label class='form-label'>Area</label>

                                    <select class='form-input' name='area' id='area' required>
                                        <option value='". $area ."' selected>". $area ."</option>
                                        <option value='Centro'>Centro</option>
                                        <option value='Papardo'>Papardo</option>
                                        <option value='Policlinico'>Policlinico</option>
                                        <option value='Annunziata'>Annunziata</option>
                                    </select>
                                </div>
                            </div>


                            <div class='mb-3'>
                                <label for='address' class='form-label'> Address </label>
                                <input type='text' name='address' id='address' class='form-input' value='". htmlspecialchars($address, ENT_QUOTES) ."' pattern='[a-zA-Z' ]*' required>
                            </div>

                            <div class='input-flex'>
                                <div>
                                    <label for='n_acc' class='form-label'> Number </label>
                                    <input type='number' name='n_acc' id='n_acc' class='form-input' value='". $nAcc ."' required>
                                </div>
                                <div>
                                    <label for='cap' class='form-label'> CAP </label>
                                    <input type='number' name='cap' id='cap' class='form-input' value='". $cap ."' min='98121' max='98168' step='1' required>
                                </div>
                            </div>
                            

                            <input type='submit' value='Save' class='btn'>
                        </form>
                    </div>";
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