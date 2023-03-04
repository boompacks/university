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
            $query = "SELECT r.* FROM renter r ";
            $additional_parameters = false;
            $search = false;

            foreach ($_POST as $key => $value) {
                if (!empty($value)) {
                    if ($key == 'renter_name' || $key == 'renter_surname') {
                        $value = strtolower($value);
                    }

                    if ($additional_parameters) {
                        $query .= " AND r." . $key . " = ?";
                    } else {
                        $query .= " WHERE r." . $key . " = ?";
                        $additional_parameters = true;
                        $search = true;
                    }

                    $params[] = $value;
                }
            }

            $stmt = $conn->prepare($query);
            if ($additional_parameters) {
                $types = str_repeat("s", count($params));
                $stmt->bind_param($types, ...$params);
            }

            $stmt->execute();
            $res = $stmt->get_result();

            $search == true ? $operation = $res->num_rows > 0 : $operation = $res->num_rows >= 0;

            if ($operation) {
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
                            <th>Contacts</th>
                            <th>Actions</th>
                        </tr>
                       </thead>";
                echo "<tbody>";
                while($row = $res->fetch_assoc()){
                    $contactsQuery = "SELECT type, value FROM renter_contact c WHERE c.renter_id = ". $row['renter_id'] .";";
    
                    if($contactsRes = $conn->query($contactsQuery)){
                        echo "<tr>
                            <td>". ucwords($row['renter_name']) ."</td>
                            <td>". ucwords($row['renter_type']) ."</td>
                            <td>". $row['renter_id'] ."</td>
                            <td>". $row['renter_surname'] ."</td>
                            <td>". $row['corporate_structure'] ."</td>
                            <td style='text-align:left'>";
                            while ($contactRow = $contactsRes->fetch_assoc()){
                                if($contactRow['type'] == 'Email'){
                                    echo "<i class='fa-solid fa-envelope'></i>";
                                } else{
                                    echo "<i class='fa-solid fa-phone'></i>";
                                }
                                    
                                echo "  ". $contactRow['value'] ."<br>";
                            }
                        echo  "</td>
                                    <td class='actions'>
                                        <form method='POST' action='edit.php'>
                                            <input type='hidden' name='renter_id' id='renter_id' value='". $row['renter_id'] ."' />
                                            <button type='submit'>
                                                <i class='fa-solid fa-pen-to-square edit'></i>
                                            </button>
                                        </form>
                                        <form method='POST' action='delete.php'>
                                            <input type='hidden' name='renter_id' id='renter_id' value='". $row['renter_id'] ."' />
                                            <button type='submit'>
                                                <i class='fa-solid fa-trash delete'></i></a>
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
