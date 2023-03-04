<html>
    <head>
        <title>AccaHousingME - Search</title>
        <link rel="stylesheet" href="../../styles/styles.css">
        <link rel="stylesheet" href="../../styles/form.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro&display=swap" rel="stylesheet">
    </head>

    <body>
        <div class="content">
                <?php 
                    include '../../coreComponents/header3.php';
                ?>
            <div class="form-wrapper">
                <p class="parameters">Insert some parameters to make a specific search</p><hr>
                <form action="landing.php" method="POST">
                    <div class="input-flex">
                        <div>
                            <label for="renter_name" class="form-label"> Name </label>
                            <input type="text" name="renter_name" id="renter_name" placeholder="Renter's name" class="form-input"/>
                        </div>

                        <div>
                            <label for="renter_surname" class="form-label"> Last Name </label>
                            <input type="text" name="renter_surname" id="renter_surname" placeholder="Renter's last name" class="form-input" pattern="[a-zA-Z]*"/>
                        </div>
                    </div>

                    <div class="input-flex">
                        <div>
                            <label for="renter_id" class="form-label"> Renter's ID </label>
                            <input type="text" name="renter_id" id="renter_id" placeholder="Renter's ID" class="form-input"/>
                        </div>

                        <div>
                            <label class="form-label">Type</label>

                            <select class="form-input" name="renter_type" id="renter_type">
                                <option value="" selected disabled hidden>Choose type</option>
                                <option value=""></option>
                                <option value="Agency">Agency</option>
                                <option value="Landlord">Landlord</option>
                            </select>
                        </div>
                    </div>

                    <input type="submit" value="Research" class="btn">
                    <input type="reset" value="Reset" class="btn red">
                </form>
            </div>
        </div>                        

        <?php
            include '../../coreComponents/footer.php'
        ?>
    </body>
</html>