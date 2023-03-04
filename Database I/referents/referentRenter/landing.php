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

            $query = "SELECT r.* FROM referent r";
            $additionalParameters = false;
            $params = array();
            $types = array();

            foreach ($_POST as $key => $value) {
                if (!empty($value)) {
                    if ($key == 'renter_id' || $key == 'renter_name' || $key == 'renter_type'){
                        continue;
                    }
                    if ($key == 'referent_name' || $key == 'referent_surname'){
                        $value = strtolower($value);
                    }
                    if ($key == 'referent_birth_date') {
                        $value = date("Y-m-d", strtotime($value));
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
                            <th>Surname</th>
                            <th>Referent ID</th>
                            <th>Gender</th>
                            <th>Date of birth</th>
                            <th>Renter ID</th>
                            <th>Renter Name</th>
                            <th>Renter Type</th>
                            <th>Actions</th>
                        </tr>
                       </thead>";
                echo "<tbody>";
                while($row = $res->fetch_assoc()){
                    $renterQuery = "SELECT DISTINCT r.renter_id, rt.renter_name, rt.renter_type FROM referent_renter r, renter rt WHERE r.referent_id = ? AND r.renter_id = rt.renter_id";
                    $renterParams[0] = $row['referent_id'];
                    $types[0] = "i";
                    $search = false;

                    foreach ($_POST as $key => $value) {
                        if (!empty($value)) {
                            if ($key == 'renter_name' || $key == 'renter_type' || $key == 'renter_id') {
                                $renterQuery .= " AND rt." . $key . " = ?";
                                $renterParams[] = $value;
                                $search = true;
                                if ($key == 'renter_name' || $key == 'renter_type'){
                                    $types[] = "s";
                                }
                                else{
                                    $types[] = "i";
                                }
                            }
                            else {
                                continue;
                            }
                        }
                    }

                    $stmt = $conn->prepare($renterQuery);
                    $stmt->bind_param(implode($types, ""), ...$renterParams);
                    $stmt->execute();
                    $renterRes = $stmt->get_result();
                    $renterParams = array();
                    $types = array();

                    $search == true ? $operation = $renterRes->num_rows > 0 : $operation = $renterRes->num_rows >= 0;

                    if($operation){
                        echo "<tr>
                            <td>". ucwords($row['referent_name']) ."</td>
                            <td>". ucwords($row['referent_surname']) ."</td>
                            <td>". $row['referent_id'] ."</td>
                            <td>". $row['referent_gender'] ."</td>
                            <td>". $row['referent_birth_date'] ."</td>";

                            $renterIds = array();
                            $renterNames = array();
                            $renterTypes = array();
                            while ($renterRow = $renterRes->fetch_assoc()){
                                $renterIds[] = $renterRow['renter_id'];
                                $renterNames[] = $renterRow['renter_name'];
                                $renterTypes[] = $renterRow['renter_type'];
                            
                            }
                            echo "<td>";
                            for($i = 0; $i < count($renterIds); $i++){
                                echo $renterIds[$i]."<br>";
                            }
                            echo "</td>";

                            echo "<td style='text-align:left'>";
                            for($i = 0; $i < count($renterNames); $i++){
                                echo $renterNames[$i]."<br>";
                            }
                            echo "</td>";

                            echo "<td>";
                            for($i = 0; $i < count($renterTypes); $i++){
                                echo $renterTypes[$i]."<br>";
                            }
                            echo "</td>";


                        echo  "<td class='actions'>
                                        <form method='POST' action='edit.php'>
                                            <input type='hidden' name='referent_id' id='referent_id' value='". $row['referent_id'] ."' />
                                            <button type='submit'>
                                                <i class='fa-solid fa-pen-to-square edit'></i>
                                            </button>
                                        </form>
                                        <form method='POST' action='delete.php'>
                                            <input type='hidden' name='referent_id' id='referent_id' value='". $row['referent_id'] ."' />
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
