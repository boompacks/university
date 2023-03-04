<head>
    <title>AccaHousingME</title>
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

            $query = "SELECT r.* FROM renter r";
            $additionalParameters = false;
            $params = array();
            $types = array();

            foreach ($_POST as $key => $value) {
                if (!empty($value)) {
                    if ($key == 'accomodation_id' || $key == 'area' || $key == 'address'){
                        continue;
                    }
                    if ($key == 'renter_name' || $key == 'renter_surname'){
                        $value = strtolower($value);
                    }
                    
                    if ($additionalParameters) {
                        $query .= " AND r." . $key . " = ?";
                    } else {
                        $query .= " WHERE r." . $key . " = ?";
                        $additionalParameters = true;
                    }

                    $types[] = "s";
                    $params[] = $value;
                }
            }
            $stmt = $conn->prepare($query);
            if ($additionalParameters) {
                $stmt->bind_param(implode($types, ""), ...$params);
            }

            $stmt->execute();
            $res = $stmt->get_result();

            if ($res->num_rows >= 0) {
                echo "<div class='extraButtons'>
                            <a href='search.php'><i class='fa-solid fa-magnifying-glass search'></i></a>
                            <a href='insert.php'><i class='fa-solid fa-plus search'></i></a>
                      </div>";
                echo "<table>";
                echo "<thead>
                        <tr>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Renter ID</th>
                            <th>Surname</th>
                            <th>Corporate structure</th>
                            <th>Accomodation ID</th>
                            <th>Area</th>
                            <th>Actions</th>
                        </tr>
                       </thead>";
                echo "<tbody>";
                while($row = $res->fetch_assoc()){
                    $houseQuery = "SELECT DISTINCT a.accomodation_id, a.area FROM renter_accomodation ar, accomodation a WHERE ar.accomodation_id = a.accomodation_id AND ar.renter_id = ? AND sale_date IS NULL ";
                    $houseParams[0] = $row['renter_id'];
                    $types = "i";
                    $search = false;

                    foreach ($_POST as $key => $value) {
                        if (!empty($value)) {
                            if ($key == 'area' || $key == 'address' || $key == 'accomodation_id') {
                                $houseQuery .= " AND a." . $key . " = ?";
                                $houseParams[] = $value;
                                $search = true;
                                if ($key == 'area' || $key == 'address'){
                                    $types .= "s";
                                }
                                else{
                                    $types .= "i";
                                }
                            }
                            else {
                                continue;
                            }
                        }
                    }

                    $stmt = $conn->prepare($houseQuery);                                
                    $stmt->bind_param($types, ...$houseParams);
                    if (!$stmt) {
                        echo ($stmt->error);
                    }
                    $stmt->execute();
                    $houseRes = $stmt->get_result();
                    $houseParams = array();
                    $types = "";

                    $search == true ? $operation = $houseRes->num_rows > 0 : $operation = $houseRes->num_rows >= 0;

                    if($operation){
                        echo "<tr>
                            <td>". ucwords($row['renter_name']) ."</td>
                            <td>". ucwords($row['renter_type']) ."</td>
                            <td>". $row['renter_id'] ."</td>
                            <td>". $row['renter_surname'] ."</td>
                            <td>". $row['corporate_structure'] ."</td>";

                            $accomodationIds = array();
                            $accomodationAreas = array();
                            while ($houseRow = $houseRes->fetch_assoc()){
                                $accomodationIds[] = $houseRow['accomodation_id'];
                                $accomodationAreas[] = $houseRow['area'];
                            }

                            echo "<td>";
                            for($i = 0; $i < count($accomodationIds); $i++){
                                echo $accomodationIds[$i]."<br>";
                            }
                            echo "</td>";

                            echo "<td style='text-align:left'>";
                            for($i = 0; $i < count($accomodationAreas); $i++){
                                echo $accomodationAreas[$i]."<br>";
                            }
                            echo "</td>";


                        echo  "<td class='actions'>
                                        <form method='POST' action='edit.php'>
                                            <input type='hidden' name='renter_id' id='renter_id' value='". $row['renter_id'] ."' />
                                            <button type='submit'>
                                                <i class='fa-solid fa-pen-to-square edit'></i>
                                            </button>
                                        </form>
                                        <form method='POST' action='delete.php'>
                                            <input type='hidden' name='renter_id' id='renter_id' value='". $row['renter_id'] ."' />
                                            <button type='submit'>
                                                <i class='fa-solid fa-trash delete'></i>
                                            </button>
                                        </form>
                                    </td>
                               </tr>";
                    }
                    else{
                        echo $conn->error;
                    }
                }
                echo "</tbody>
                      </table>";
            } else{
                echo $conn->error;
            }
            

            $conn->close()
        ?>
    </div>

    <?php
        include '../../coreComponents/footer.php'
    ?>
</body>
