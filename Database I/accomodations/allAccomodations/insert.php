<html>
    <head>
        <title>AccaHousingME - Insert</title>
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
                <p class="parameters">Insert the data of the new accomodation</p><hr>
                <form action="inserted.php" method="POST">
                    <div class="input-flex">
                        <div>
                            <label for="accomodation_id" class="form-label"> Accomodation ID </label>
                            <input type="text" name="accomodation_id" id="accomodation_id" placeholder="Accomodation ID" class="form-input"/>
                        </div>

                        <div>
                            <label for="size" class="form-label"> Size </label>
                            <input type="text" name="size" id="size" placeholder="Size (specify mq)" class="form-input" pattern="\d+mq" required/>
                        </div>
                    </div>

                    <div class="input-flex">
                        <div>
                            <label for="monthly_rent" class="form-label"> Rent </label>
                            <input type="number" name="monthly_rent" id="monthly_rent" placeholder="Rent" class="form-input" required/>
                        </div>

                        <div>
                            <label class="form-label">Area</label>

                            <select class="form-input" name="area" id="area" required>
                                <option value="" selected disabled hidden>Choose area</option>
                                <option value="Centro">Centro</option>
                                <option value="Papardo">Papardo</option>
                                <option value="Annunziata">Annunziata</option>
                                <option value="Policlinico">Policlinico</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label"> Address </label>
                        <input type="text" name="address" id="address" placeholder="Accomodation's address" class="form-input" pattern="[a-zA-Z' ]*" required/>
                    </div>

                    <div class="input-flex">
                        <div>
                            <label for="n_acc" class="form-label"> Address Number </label>
                            <input type="number" name="n_acc" id="n_acc" placeholder="Address number" class="form-input" required/>
                        </div>

                        <div>
                            <label for="cap" class="form-label"> CAP </label>
                            <input type="number" name="cap" id="cap" placeholder="CAP" class="form-input" min="98121" max="98168" step="1" required/>
                        </div>
                    </div>

                    <input type="submit" value="Insert" class="btn">
                    <input type="reset" value="Reset" class="btn red">
                </form>
            </div>
        </div>                        

        <?php
            include '../../coreComponents/footer.php'
        ?>
    </body>
</html>