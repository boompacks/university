<?php
    include '../../db.php';

    $renterId = $_GET['renter_id'];

    $query = "SELECT renter_name, renter_type FROM renter rt WHERE rt.renter_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $renterId);
    $stmt->execute();

    $result = $stmt->get_result();

    $renterData = array();
    while ($row = $result->fetch_assoc()) {
        $renterData[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($renterData);
?>

