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
                            <label for="accomodation_id" class="form-label"> Accomodation ID </label>
                            <input type="text" name="accomodation_id" id="accomodation_id" placeholder="Accomodation ID" class="form-input"/>
                        </div>

                        <div>
                            <label for="size" class="form-label"> Size </label>
                            <input type="text" name="size" id="size" placeholder="Size (specify mq)" class="form-input" pattern="\d+mq"/>
                        </div>
                    </div>

                    <div class="input-flex">
                        <div>
                            <label for="monthly_rent" class="form-label"> Rent </label>
                            <input type="text" name="monthly_rent" id="monthly_rent" placeholder="Rent" class="form-input" pattern="\d"/>
                        </div>

                        <div>
                            <label class="form-label">Area</label>

                            <select class="form-input" name="area" id="area">
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
                        <input type="text" name="address" id="address" placeholder="Accomodation's address" class="form-input" pattern="[a-zA-Z]*"/>
                    </div>

                    <input type="submit" value="Research" class="btn">
                    <input type="reset" value="Reset" class="btn red">
                </form>
            </div>
        </div>                        

        <?php
            include '../../coreComponents/footer.php';
        ?>
    </body>
</html>