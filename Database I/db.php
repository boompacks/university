<?php
    $servername = "";
    $username = "";
    $password = "";
    $dbname = "";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->mysqli_errno) {
        die("Connection failed: " . $conn->mysqli_error);
    }
?>