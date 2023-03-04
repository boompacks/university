<html>
    <head>
        <title>AccaHousingME - Insert</title>
        <link rel="stylesheet" href="../../styles/styles.css">
        <link rel="stylesheet" href="../../styles/form.css">
        <script src="../../scripts/contacts.js" defer></script>
        <script src="../../scripts/disableInput.js" defer></script>
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
                <p class="parameters">Insert the data of the new renter</p><hr>
                <form action="inserted.php" method="POST">
                    <div class="input-flex">
                        <div>
                            <label for="renter_name" class="form-label"> Name </label>
                            <input type="text" name="renter_name" id="renter_name" placeholder="Renter's name" class="form-input" required/>
                        </div>

                        <div>
                            <label for="renter_surname" class="form-label"> Last Name </label>
                            <input type="text" name="renter_surname" id="renter_surname" placeholder="Renter's last name" class="form-input" pattern="[a-zA-Z]*" disabled/>
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
                
                    <div class="input-flex">
                        <div>
                            <label for="corporate_structure" class="form-label"> Corporate Structure </label>
                            <input type="text" name="corporate_structure" id="corporate_structure" placeholder="Corporate Structure" class="form-input" disabled/>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="ncontacts" class="form-label"> How many contacts </label>
        
                        <select class="form-input" name="ncontacts" id="ncontacts">
                            <option value="" selected >0</option>
                            <?php
                                for($i = 1; $i < 10; $i++){
                                    echo "<option value='". $i ."'>". $i ."</option>";
                                }
                            ?>
                        </select>
                    </div>

                    <div id="contactsWrapper">

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