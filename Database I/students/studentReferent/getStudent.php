<?php
    include '../../db.php';

    $studentId = $_GET['id'];

    $query = "SELECT name, surname, birth_date, country, gender FROM student s WHERE s.student_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $studentId);
    $stmt->execute();

    $result = $stmt->get_result();

    $studentData = array();
    while ($row = $result->fetch_assoc()) {
        $studentData[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($studentData);
?>

