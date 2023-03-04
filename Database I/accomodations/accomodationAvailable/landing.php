<head>
    <title>AccaHousingME - All students' data</title>
    <link rel="stylesheet" href="../../styles/styles.css">
    <link rel="stylesheet" href="../../styles/table.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro&display=swap" rel="stylesheet">
</head>

<body>
    <div class="content">    
        <?php
            include '../../coreComponents/header2.php';
            include '../../db.php';
            $query = "SELECT a.* FROM accomodation a WHERE a.accomodation_id NOT IN (SELECT DISTINCT sa.accomodation_id FROM student_accomodation sa)";

            $stmt = $conn->prepare($query);
            $stmt->execute();
            $res = $stmt->get_result();

            if ($res->num_rows >= 0) {
                $rows = $res->fetch_all(MYSQLI_ASSOC);
                echo "<table>";
                echo "<thead>
                        <tr>
                            <th>ID</th>
                            <th>Size</th>
                            <th>Monthly Rent</th>
                            <th>Address</th>
                            <th>Area</th>
                        </tr>
                       </thead>";
                echo "<tbody>";
                foreach($rows as $row){
                        echo "<tr>
                                <td>". $row['accomodation_id'] ."</td>
                                <td>". $row['size'] ."</td>
                                <td>". $row['monthly_rent'] ."</td>
                                <td style='text-align:left;'>". $row['address'] ."</td>
                                <td>". $row['area'] ."</td>
                            </tr>";
                }
                echo "</tbody>
                      </table>";
            } else{
                die($conn->error);
            }
            $stmt->close();
            $conn->close();
        ?>
    </div>

    <?php
        include '../../coreComponents/footer.php'
    ?>
</body>
