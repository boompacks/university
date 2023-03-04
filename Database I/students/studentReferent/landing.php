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
                    if ($key == 'referent_id' || $key == 'referent_name' || $key == 'referent_surname') {
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
                            <th>Referent ID</th>
                            <th>Referent name</th>
                            <th>Referent surname</th>
                            <th>Actions</th>
                        </tr>
                       </thead>";
                echo "<tbody>";
                while($row = $res->fetch_assoc()){
                    $referentQuery = "SELECT DISTINCT rs.referent_id, r.referent_name, r.referent_surname FROM referent r, student_referent rs WHERE r.referent_id = rs.referent_id AND rs.student_id = ? ";
                    $referentParams[0] = $row['student_id'];
                    $referentTypes[0] = "i";
                    $search = false;

                    foreach ($_POST as $key => $value) {
                        if (!empty($value)) {
                            if ($key == 'referent_id' || $key == 'referent_name' || $key == 'referent_surname') {
                                if($key == 'referent_id') {
                                    $referentQuery .= " AND rs." . $key . " = ?";
                                    $referentTypes[] = "i";
                                }
                                else {
                                    $referentQuery .= " AND r." . $key . " = ?";
                                    $referentTypes[] = "s";
                                    
                                }
                                $search = true;
                                $referentParams[] = $value;
                            }
                            else {
                                continue;
                            }
                        }
                    }

                    $stmt = $conn->prepare($referentQuery);
                    $stmt->bind_param(implode($referentTypes, ""), ...$referentParams);
                    $stmt->execute();
                    $referentRes = $stmt->get_result();
                    

                    $referentParams = array();
                    $referentTypes = array();

                    $search == true ? $operation = $referentRes->num_rows > 0 : $operation = $referentRes->num_rows >= 0;

                    if ($operation){
                        echo "<tr>
                            <td>". ucwords($row['name']) ."</td>
                            <td>". ucwords($row['surname']) ."</td>
                            <td>". $row['student_id'] ."</td>
                            <td>". $row['gender'] ."</td>
                            <td>". $row['birth_date'] ."</td>
                            <td>". $row['country'] ."</td>";

                            $referentIds = array();
                            $referentNames = array();
                            $referentSurnames = array();
                            while ($referentRow = $referentRes->fetch_assoc()){
                                if (isset($referentRow['referent_id'])){
                                    $referentIds[] = $referentRow['referent_id'];
                                }
                                else{
                                    $referentIds[] = " - ";
                                }
                                
                                $referentNames[] = $referentRow['referent_name'];
                                $referentSurnames[] = $referentRow['referent_surname'];  
                            }
                            echo "<td>";
                            for($i = 0; $i < count($referentIds); $i++){
                                echo $referentIds[$i]. "<br>";
                            }
                            echo "</td>";

                            echo "<td>";
                            for($i = 0; $i < count($referentNames); $i++){
                                echo $referentNames[$i] ."<br>";
                            }
                            echo "</td>";

                            echo "<td>";
                            for($i = 0; $i < count($referentSurnames); $i++){
                                echo $referentSurnames[$i] ."<br>";
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
