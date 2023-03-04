<html>
    <head>
        <title>AccaHousingME - Insert</title>
        <link rel="stylesheet" href="../../styles/styles.css">
        <link rel="stylesheet" href="../../styles/form.css">
        <script src="../../scripts/fullReferentData.js" defer></script>
        <script src="../../scripts/renterData.js" defer></script>
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
                <p class="parameters">Assign a referent to a new renter</p><hr>
                <form action="inserted.php" method="POST">
                    <div class="input-flex">
                        <div>
                            <label for="referent_id" class="form-label"> Referent's ID </label>
                            <select class="form-input" name="referent_id" id="referent_id" required>
                                <option selected hidden disabled>Choose Referent's Id</option>
                            <?php 
                                $query = "SELECT r.referent_id FROM referent r;";
                                $res = $conn->query($query);
                                while ($row = $res->fetch_assoc()) {
                                    echo "<option value='". $row['referent_id'] ."'>". $row['referent_id'] ."</option>";
                                }
                                
                                include 'getReferent.php';
                            ?>
                            </select>
                        </div>

                        <div>
                            <label for="referent_birth_date" class="form-label"> Birth Date </label>
                            <input type="text" name="referent_birth_date" id="referent_birth_date" class="form-input" placeholder="Referent's birth date" readonly />
                        </div>
                    </div>

                    <div class="input-flex">
                        <div>
                            <label for="name" class="form-label"> First Name </label>
                            <input type="text" name="referent_name" id="referent_name" placeholder="Referent's name" class="form-input" readonly/>
                        </div>

                        <div>
                            <label for="referent_surname" class="form-label"> Last Name </label>
                            <input type="text" name="referent_surname" id="referent_surname" placeholder="Referent's last name" class="form-input" readonly/>
                        </div>
                    </div>

                    <div class="input-flex">
                        <div>
                            <label class="form-label">Gender</label>
                            <input type="text" name="referent_gender" id="referent_gender" placeholder="Referent's gender" class="form-input" readonly/>
                        </div>
                    </div><hr>

                    <div class="mb-3">
                        <label for="renter_id" class="form-label"> Renter's ID </label>
                        <select class="form-input" name="renter_id" id="renter_id" required>
                            <option selected hidden disabled>Choose Renter's Id</option>
                        <?php 
                            $query = "SELECT rt.renter_id FROM renter rt;";
                            $res = $conn->query($query);
                            while ($row = $res->fetch_assoc()) {
                                echo "<option value='". $row['renter_id'] ."'>". $row['renter_id'] ."</option>";
                            }
                            
                            include 'getRenter.php';
                        ?>
                        </select>
                    </div>

                    <div class="input-flex">
                        <div>
                            <label for="renter_name" class="form-label"> Renter Name </label>
                            <input type="text" name="renter_name" id="renter_name" class="form-input" placeholder="Renter's name" readonly/>
                        </div>

                        <div>
                            <label for="renter_type" class="form-label"> Referent Type </label>
                            <input type="text" name="renter_type" id="renter_type" class="form-input" placeholder="Renter's surname" readonly/>
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