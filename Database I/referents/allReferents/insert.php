<html>
    <head>
        <title>AccaHousingME - Insert</title>
        <link rel="stylesheet" href="../../styles/styles.css">
        <link rel="stylesheet" href="../../styles/form.css">
        <script src="../../scripts/contacts.js" defer></script>
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
                <p class="parameters">Insert the data of the new referent</p><hr>
                <form action="inserted.php" method="POST">
                    <div class="input-flex">
                        <div>
                            <label for="referent_name" class="form-label"> First Name </label>
                            <input type="text" name="referent_name" id="referent_name" placeholder="Referent's name" class="form-input" pattern="[a-zA-Z]*" required/>
                        </div>

                        <div>
                            <label for="referent_surname" class="form-label"> Last Name </label>
                            <input type="text" name="referent_surname" id="referent_surname" placeholder="Referent's last name" class="form-input" pattern="[a-zA-Z]*" required/>
                        </div>
                    </div>

                    <div class="input-flex">
                        <div>
                            <label for="referent_id" class="form-label"> Referent's ID </label>
                            <input type="text" name="referent_id" id="referent_id" placeholder="Referent's ID" class="form-input" pattern="[0-9]*"/>
                        </div>

                        <div>
                            <label class="form-label">Gender</label>

                            <select class="form-input" name="referent_gender" id="referent_gender" required>
                                <option value="" selected disabled hidden>Choose gender</option>
                                <option value=""></option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Others">Others</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="referent_birth_date" class="form-label"> Birth Date </label>
                        <input type="date" name="referent_birth_date" id="referent_birth_date" class="form-input" required />
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