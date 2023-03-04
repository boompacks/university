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
            $query = "SELECT a.* FROM accomodation a ";
            $additional_parameters = false;
            $search = false;
            $types = "";
            $params = array();
            $search = false;

            foreach ($_POST as $key => $value) {
                if (!empty($value)) {
                    if ($key == 'accomodation_id' || $key == 'monthly_rent'){
                        $types .= "i";
                    }
                    else{
                        $types .= "s";
                    }

                    if ($additional_parameters) {
                        $query .= " AND a." . $key . " = ?";
                    } else {
                        $query .= " WHERE a." . $key . " = ?";
                        $additional_parameters = true;
                        $search = true;
                    }

                    $params[] = $value;
                }
            }


            $stmt = $conn->prepare($query);
            if ($additional_parameters) {
                $stmt->bind_param($types, ...$params);
            }
            $stmt->execute();
            $res = $stmt->get_result();
            

            $search == true ? $operation = $res->num_rows > 0 : $operation = $res->num_rows >= 0;

            if ($operation) {
                $rows = $res->fetch_all(MYSQLI_ASSOC);
                echo "<div class='extraButtons'>
                            <a href='search.php'><i class='fa-solid fa-magnifying-glass search'></i></a>
                            <a href='insert.php'><i class='fa-solid fa-plus search'></i></a>
                      </div>";
                echo "<table>";
                echo "<thead>
                        <tr>
                            <th>ID</th>
                            <th>Size</th>
                            <th>Monthly Rent</th>
                            <th>Address</th>
                            <th>Area</th>
                            <th>Action</th>
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
                            
                                    <td class='actions'>
                                        <form method='POST' action='edit.php'>
                                            <input type='hidden' name='accomodation_id' id='accomodation_id' value='". $row['accomodation_id'] ."' />
                                            <button type='submit'>
                                                <i class='fa-solid fa-pen-to-square edit'></i>
                                            </button>
                                        </form>
                                        <form method='POST' action='delete.php'>
                                            <input type='hidden' name='accomodation_id' id='accomodation_id' value='". $row['accomodation_id'] ."' />
                                            <button type='submit'>
                                                <i class='fa-solid fa-trash delete'></i></a>
                                            </button>
                                        </form>
                                    </td>
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
