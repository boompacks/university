<html>
    <head>
        <title>AccaHousingME - Edit user</title>
        <link rel='stylesheet' href='../../styles/styles.css'>
        <link rel='stylesheet' href='../../styles/form.css'>
        <link rel='stylesheet' href='../../styles/table.css'>
        <link rel='preconnect' href='https://fonts.googleapis.com'>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
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
                $query = "SELECT s.* FROM student s WHERE s.student_id = ?;";

                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $_POST['student_id']);

                if($stmt->execute()){
                    $stmt->bind_result($studentId, $name, $surname, $birthDate, $country, $gender);
                    $stmt->fetch();

                    echo "<div class='form-wrapper'>
                        <p class='parameters'>Delete an accomodation from the current user<hr></p>
                        <form>
                            <div class='input-flex'>
                                <div>
                                    <label for='name' class='form-label'> First Name </label>
                                    <input type='text' name='name' id='name' value='". ucwords($name) ."' class='form-input'readonly/>
                                </div>

                                <div>
                                    <label for='surname' class='form-label'> Last Name </label>
                                    <input type='text' name='surname' id='surname' value='". ucwords($surname) ."' class='form-input' readonly/>
                                </div>
                            </div>

                            <div class='input-flex'>
                                <div>
                                    <label for='student_id' class='form-label'> Student's ID </label>
                                    <input type='text' name='student_id' id='student_id' value='". $studentId ."' class='form-input' readonly/>
                                </div>

                                <div>
                                    <label class='form-label'>Gender</label>
                                    <input type='text' name='gender' id='gender' value='". $gender ."' class='form-input' readonly/>
                                </div>
                            </div>


                            <div class='mb-3'>
                                <label for='birth_date' class='form-label'> Birth Date </label>
                                <input type='text' name='birth_date' id='birth_date' class='form-input' value='". $birthDate ."'>
                            </div>

                            <div class='mb-3'>
                                <label for='country' class='form-label'> Country of Birth </label>
                                <input type='text' name='country' id='country' class='form-input' value='". $country ."'>
                            </div><hr></form>";
                            $stmt->close();

                            $allReferents =  "SELECT sr.referent_id, r.referent_name, r.referent_surname FROM referent r, student_referent sr WHERE r.referent_id = sr.referent_id AND sr.student_id = ?;";
                            $stmt = $conn->prepare($allReferents);
                            $stmt->bind_param("i", $studentId);

                            if ($stmt->execute()){
                                $result = $stmt->get_result();
                                $numRows = $result->num_rows;
                                if ($numRows > 0){
                                    $ids = array();
                                    $referentNames = array();
                                    $referentSurnames = array();
                                    while($referentRow = $result->fetch_assoc()){
                                        $ids[] = $referentRow['referent_id'];
                                        $referentNames[] = $referentRow['referent_name'];
                                        $referentSurnames[] = $referentRow['referent_surname'];
                                    }

                                    
                                    for ($i = 0; $i < count($ids); $i++) {
                                        echo "<div class='input-flex'>";
                                        echo "<div>
                                                <label for='ex_ref_id".$i."' class='form-label'> Referent ID </label>
                                                <input type='text' name='ex_ref_id".$i."' id='ex_ref_id".$i."' value='". $ids[$i] ."' class='form-input' readonly/>
                                            </div>
                                            <div>
                                                <label for='ex_ref_name".$i."' class='form-label'> Referent's Name </label>
                                                <input type='text' name='ex_ref_name".$i."' id='ex_ref_name".$i."' value='". $referentNames[$i] ."' class='form-input' readonly/>
                                            </div>
                                            <div>
                                                <label for='ex_ref_surname".$i."' class='form-label'> Referent's Surname </label>
                                                <input type='text' name='ex_ref_surname".$i."' id='ex_ref_surname".$i."' value='". $referentSurnames[$i] ."' class='form-input' readonly/>
                                            </div>
                                                <div class='deleteButtons'>
                                                    <form method='POST' action='deleted.php'>
                                                        <input type='hidden' name='student_id' value='". $studentId ."' />
                                                        <input type='hidden' name='referent_id' value='". $ids[$i] ."' />
                                                        <button type='submit'>
                                                            <i class='fa-solid fa-trash delete'></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>";
                                    }
                                }
                            }
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