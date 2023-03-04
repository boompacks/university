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
            $query = "SELECT s.* FROM student s ";
            $additionalParameters = false;

            foreach ($_POST as $key => $value) {
                if (!empty($value)) {
                    if ($key == 'start_date' || $key == 'end_date' || $key == 'area') {
                        continue;
                    }
                    if ($key == 'name' || $key == 'surname') {
                        $value = strtolower($value);
                    }
                    if ($key == 'birth_date') {
                        $value = date("Y-m-d", strtotime($value));
                    }

                    if ($additionalParameters) {
                        $query .= " AND s." . $key . " = ?";
                    } else {
                        $query .= " WHERE s." . $key . " = ?";
                        $additionalParameters = true;
                    }

                    $params[] = $value;
                }
            }
            $stmt = $conn->prepare($query);
            if ($additionalParameters) {
                $types = str_repeat("s", count($params));
                $stmt->bind_param($types, ...$params);
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
                            <th>Surname</th>
                            <th>Student ID</th>
                            <th>Gender</th>
                            <th>Date of birth</th>
                            <th>Country</th>
                            <th>Accomodation</th>
                            <th>Area</th>
                            <th>Start period</th>
                            <th>End period</th>
                            <th>Actions</th>
                        </tr>
                       </thead>";
                echo "<tbody>";
                while($row = $res->fetch_assoc()){
                    $accomodationQuery = "SELECT DISTINCT a.accomodation_id, a.area, sa.start_date, sa.end_date FROM accomodation a, student s, student_accomodation sa WHERE a.accomodation_id = sa.accomodation_id AND sa.student_id = ? ";
                    $accomodationParams[0] = $row['student_id'];
                    $accomodationTypes[0] = "i";

                    foreach ($_POST as $key => $value) {
                        if (!empty($value)) {
                            if ($key == 'start_date' || $key == 'end_date' || $key == 'area') {
                                if($key == 'area') {
                                    $accomodationQuery .= " AND a." . $key . " = ?";
                                    $accomodationParams[] = $value;
                                }
                                else {
                                    $accomodationQuery .= " AND sa." . $key . " = ?";
                                    $accomodationParams[] = date("Y-m-d", strtotime($value));
                                }

                                $accomodationTypes[] = "s";
                            }
                            else {
                                continue;
                            }
                        }
                    }

                    $stmt = $conn->prepare($accomodationQuery);
                    $stmt->bind_param(implode($accomodationTypes, ""), ...$accomodationParams);
                    $stmt->execute();
                    $accomodationRes = $stmt->get_result();

                    $accomodationParams = array();
                    $accomodationTypes = array();

                    if($accomodationRes->num_rows >= 0){
                        echo "<tr>
                            <td>". ucwords($row['name']) ."</td>
                            <td>". ucwords($row['surname']) ."</td>
                            <td>". $row['student_id'] ."</td>
                            <td>". $row['gender'] ."</td>
                            <td>". $row['birth_date'] ."</td>
                            <td>". $row['country'] ."</td>";

                            $accomodationIds = array();
                            $accomodationAreas = array();
                            $startDates = array();
                            $endDates = array();
                            while ($accomodationRow = $accomodationRes->fetch_assoc()){
                                $accomodationIds[] = $accomodationRow['accomodation_id'];
                                $accomodationAreas[] = $accomodationRow['area'];
                                $startDates[] = $accomodationRow['start_date'];
                                if (isset($accomodationRow['end_date'])) {
                                    $endDates[] = $accomodationRow['end_date'];
                                }
                                else {
                                    $endDates[] = " - ";
                                }
                            }
                            echo "<td>";
                            for($i = 0; $i < count($accomodationIds); $i++){
                                echo $accomodationIds[$i]. "<br>";
                            }
                            echo "</td>";

                            echo "<td>";
                            for($i = 0; $i < count($accomodationAreas); $i++){
                                echo $accomodationAreas[$i] ."<br>";
                            }
                            echo "</td>";

                            echo "<td>";
                            for($i = 0; $i < count($startDates); $i++){
                                echo $startDates[$i] ."<br>";
                            }
                            echo "</td>";

                            echo "<td>";
                            for($i = 0; $i < count($endDates); $i++){
                                echo $endDates[$i] ."<br>";
                            }
                            echo "</td>";
                        echo  "
                                    <td class='actions'>
                                        <form method='POST' action='edit.php'>
                                            <input type='hidden' name='student_id' id='student_id' value='". $row['student_id'] ."' />
                                            <button type='submit'>
                                                <i class='fa-solid fa-pen-to-square edit'></i>
                                            </button>
                                        </form>
                                        <form method='POST' action='delete.php'>
                                            <input type='hidden' name='student_id' id='student_id' value='". $row['student_id'] ."' />
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
