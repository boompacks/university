<html>
    <head>
        <title>AccaHousingME - Insert</title>
        <link rel="stylesheet" href="../../styles/styles.css">
        <link rel="stylesheet" href="../../styles/form.css">
        <script src="../../scripts/studentData.js" defer></script>
        <script src="../../scripts/referentData.js" defer></script>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro&display=swap" rel="stylesheet">
    </head>

    <body>
        <div class="content" id="content">
                <?php 
                    include '../../coreComponents/header3.php';
                    include '../../db.php';
                ?>
            <div class="form-wrapper">
                <p class="parameters">Assign a student to a new referent</p><hr>
                <form action="inserted.php" method="POST">
                    <div class="input-flex">
                        <div>
                            <label for="student_id" class="form-label"> Student's ID </label>
                            <select class="form-input" name="student_id" id="student_id" required>
                                <option selected hidden disabled>Choose Student's Id</option>
                            <?php 
                                $query = "SELECT s.student_id FROM student s;";
                                $res = $conn->query($query);
                                while ($row = $res->fetch_assoc()) {
                                    echo "<option value='". $row['student_id'] ."'>". $row['student_id'] ."</option>";
                                }
                                
                                include 'getStudent.php';
                            ?>
                            </select>
                        </div>

                        <div>
                            <label for="birth_date" class="form-label"> Birth Date </label>
                            <input type="text" name="birth_date" id="birth_date" class="form-input" placeholder="Student's birth date" readonly />
                        </div>
                    </div>

                    <div class="input-flex">
                        <div>
                            <label for="name" class="form-label"> First Name </label>
                            <input type="text" name="name" id="name" placeholder="Student's name" class="form-input" pattern="[a-zA-Z]*" readonly/>
                        </div>

                        <div>
                            <label for="surname" class="form-label"> Last Name </label>
                            <input type="text" name="surname" id="surname" placeholder="Student's last name" class="form-input" pattern="[a-zA-Z]*" readonly/>
                        </div>
                    </div>

                    <div class="input-flex">
                        <div>
                            <label class="form-label">Gender</label>
                            <input type="text" name="gender" id="gender" placeholder="Student's gender" class="form-input" readonly/>
                        </div>

                        <div>
                            <label for="country" class="form-label"> Country of Birth </label>
                            <input type="text" name="country" id="country" class="form-input" placeholder="Student's country" readonly />
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="referent_id" class="form-label"> Referent's ID </label>
                        <select class="form-input" name="referent_id" id="referent_id" required>
                            <option selected hidden disabled>Choose Referent's Id</option>
                        <?php 
                            $query = "SELECT r.referent_id FROM referent r;";
                            $res = $conn->query($query);
                            while ($row = $res->fetch_assoc()) {
                                echo "<option value='". $row['referent_id'] ."'>". $row['referent_id'] ."</option>";
                            }
                            
                            include 'getStudent.php';
                            include 'getReferent.php';
                        ?>
                        </select>
                    </div>

                    <div class="input-flex">
                        <div>
                            <label for="referent_name" class="form-label"> Referent Name </label>
                            <input type="text" name="referent_name" id="referent_name" class="form-input" placeholder="Referent's name" readonly/>
                        </div>

                        <div>
                            <label for="referent_surname" class="form-label"> Referent Surname </label>
                            <input type="text" name="referent_surname" id="referent_surname" class="form-input" placeholder="Referent's surname" readonly/>
                        </div>
                    </div>
                
                    <input type="submit" value="Insert" class="btn">
                    <input type="reset" value="Reset" class="btn red" id="reset">
                </form>
            </div>
        </div>                        

        <?php
            include '../../coreComponents/footer.php'
        ?>
    </body>
</html>