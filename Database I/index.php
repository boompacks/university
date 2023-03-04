<html>
    <head>
        <title>AccaHousingME</title>
        <link rel="stylesheet" href="styles/styles.css">
        <script src="/scripts/header.js"></script>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro&display=swap" rel="stylesheet">
    </head>

    <body>
        <?php
            include 'coreComponents/header.php';

        ?>
        
        <div class="content">
            <div class="banner">
                <div class="welcome">
                    <div class="textColumn">
                        <div>
                            <h2 id="welcomeText">Welcome to AccaHousingME</h2>
                        </div>
                        <div class="text">
                            <p>Through this website, you will be able to perform some queries regarding housing for UniMe students, which are grouped by section to make the process clearer</p>
                        </div>
                    </div>
                    <div class="imageColumn">
                        <img src="images/welcome.jpg" alt="welcomehouse" class="welcomehouse">
                    </div>
                </div>
            </div>

            <div class="section">
                <div class="textColumn">
                    <div>
                        <h2>Students</h2>
                    </div>
                    <div class="choices">
                        <ul>
                            <li><a href="students/allStudents/landing.php">View, search, modify, insert and delete data for students and their contacts</a></li>
                            <li><a href="students/studentHouse/landing.php">Check and insert to which house each student is assigned</a></li>
                            <li><a href="students/studentReferent/landing.php">Check to which referents each student is assigned</a>
                        </ul>
                    </div>
                </div>
                <div class="imageColumn">
                    <img src="images/students.jpeg" alt="students" class="students">
                </div>
            </div>

            <div class="section">
                <div class="imageColumn">
                    <img src="images/referent.jpg" alt="referent" class="referent">
                </div>

                <div class="textColumn">
                    <div>
                        <h2>Referents</h2>
                    </div>
                    <div class="choices">
                        <ul>
                            <li><a href="referents/allReferents/landing.php">View, search, modify, insert and delete data for UniMe referents</a></li>
                            <li><a href="referents/referentRenter/landing.php">Check which renter each referent is contact with</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="section">
                <div class="textColumn">
                    <div>
                        <h2>Renters</h2>
                    </div>
                    <div class="choices">
                        <ul>
                            <li><a href="renters/allRenters/landing.php">View, search, modify, insert and delete data for the renters</a></li>
                            <li><a href="renters/renterHouse/landing.php">Check all the accomodations owned by each renter</a></li>
                        </ul>
                    </div>
                </div>
                <div class="imageColumn">
                    <img src="images/renter.jpg" alt="renter" class="renter">
                </div>
            </div>

            <div class="section">
                <div class="imageColumn">
                    <img src="images/house.jpg" alt="house" class="house">
                </div>

                <div class="textColumn">
                    <div>
                        <h2>Accomodations</h2>
                    </div>
                    <div class="choices">
                        <ul>
                            <li><a href="accomodations/allAccomodations/landing.php">View, search, modify, insert and delete data for the houses</a></li>
                            <li><a href="accomodations/accomodationAvailable/landing.php">Check which rooms are currently available</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <?php
            include 'coreComponents/footer.php';
        ?>
    </body>
</html>