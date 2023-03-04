<?php
    include '../../db.php';

    $accomodationId = $_GET['accomodation_id'];

    $query = "SELECT a.area, a.address FROM accomodation a WHERE a.accomodation_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $accomodationId);
    $stmt->execute();

    $result = $stmt->get_result();

    $accomodationData = array();
    while ($row = $result->fetch_assoc()) {
        $accomodationData[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($accomodationData);
?>

