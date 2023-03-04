<?php
    include '../../db.php';

    $referentId = $_GET['referent_id'];

    $query = "SELECT referent_name, referent_surname FROM referent r WHERE r.referent_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $referentId);
    $stmt->execute();

    $result = $stmt->get_result();

    $referentData = array();
    while ($row = $result->fetch_assoc()) {
        $referentData[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($referentData);
?>

