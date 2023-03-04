<html>
    <head>
        <title>AccaHousingME - Insert</title>
        <link rel="stylesheet" href="../../styles/styles.css">
        <link rel="stylesheet" href="../../styles/form.css">
        <script src="../../scripts/studentData.js" defer></script>
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
                <p class="parameters">Assign a student to a new house</p><hr>
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
                        <label for="accomodation_id" class="form-label"> Accomodation's ID </label>
                        <select class="form-input" name="accomodation_id" id="accomodation_id" required>
                            <option selected hidden disabled>Choose Accomodation's Id</option>
                        <?php 
                            $query = "SELECT a.accomodation_id FROM accomodation a;";
                            $res = $conn->query($query);
                            while ($row = $res->fetch_assoc()) {
                                echo "<option value='". $row['accomodation_id'] ."'>". $row['accomodation_id'] ."</option>";
                            }
                            
                            include 'getStudent.php';
                        ?>
                        </select>
                    </div>

                    <div class="input-flex">
                        <div>
                            <label for="start_date" class="form-label"> Start Date </label>
                            <input type="date" name="start_date" id="start_date" class="form-input" required/>
                        </div>

                        <div>
                            <label for="end_date" class="form-label"> End Date </label>
                            <input type="date" name="end_date" id="end_date" class="form-input" required/>
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