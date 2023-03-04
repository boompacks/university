<html>
    <head>
        <title>AccaHousingME - Insert</title>
        <link rel="stylesheet" href="../../styles/styles.css">
        <link rel="stylesheet" href="../../styles/form.css">
        <script src="../../scripts/renterData.js" defer></script>
        <script src="../../scripts/accomodationData.js" defer></script>
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
                <p class="parameters">Assign an accomodation to a renter</p><hr>
                <form action="inserted.php" method="POST">
                    <div class="mb3">
                        <div>
                            <label for="renter_id" class="form-label"> Renter's ID </label>
                            <select class="form-input" name="renter_id" id="renter_id" required>
                                <option selected hidden disabled>Choose Renter's Id</option>
                            <?php 
                                $query = "SELECT r.renter_id FROM renter r;";
                                $res = $conn->query($query);
                                while ($row = $res->fetch_assoc()) {
                                    echo "<option value='". $row['renter_id'] ."'>". $row['renter_id'] ."</option>";
                                }
                                
                                include 'getRenter.php';
                            ?>
                            </select>
                        </div>
                    </div>

                    <div class="input-flex">
                        <div>
                            <label for="renter_type" class="form-label"> Type </label>
                            <input type="text" name="renter_type" id="renter_type" placeholder="Renter's type" class="form-input" readonly/>
                        </div>

                        <div>
                            <label for="name" class="form-label">  Name </label>
                            <input type="text" name="renter_name" id="renter_name" placeholder="Renter's name" class="form-input" readonly/>
                        </div>
                    </div>


                    <div class="mb-3">
                        <label for="renter_id" class="form-label"> Accomodation's ID </label>
                        <select class="form-input" name="accomodation_id" id="accomodation_id" required>
                            <option selected hidden disabled>Choose Accomodation's Id</option>
                        <?php 
                            $query = "SELECT a.accomodation_id FROM accomodation a;";
                            $res = $conn->query($query);
                            while ($row = $res->fetch_assoc()) {
                                echo "<option value='". $row['accomodation_id'] ."'>". $row['accomodation_id'] ."</option>";
                            }
                            
                            include 'getRenter.php';
                        ?>
                        </select>
                    </div>

                    <div class="input-flex">
                        <div>
                            <label for="area" class="form-label"> Accomodation area </label>
                            <input type="text" name="area" id="area" class="form-input" placeholder="Accomodation's area" readonly/>
                        </div>

                        <div>
                            <label for="address" class="form-label"> Accomodation address </label>
                            <input type="text" name="address" id="address" class="form-input" placeholder="Accomodation's address" readonly/>
                        </div>
                    </div>

                    <div class="input-flex">
                        <div>
                            <label for="acquisition_date" class="form-label"> Acquisition Date </label>
                            <input type="date" name="acquisition_date" id="acquisition_date" class="form-input" placeholder="Acquisition Date"/>
                        </div>

                        <div>
                            <label for="sale_date" class="form-label"> Sale Date </label>
                            <input type="date" name="sale_date" id="sale_date" class="form-input" placeholder="Sale Date"/>
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