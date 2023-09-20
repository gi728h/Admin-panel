<!-- Establish Connection -->
<?php
$user = 'root';
$password = '';
$database = 'test';
$servername = 'localhost:3306';
$mysqli = new mysqli(
    $servername,
    $user,
    $password,
    $database
);

if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}
?>

<!-- Loading HTML -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>MOHITO'S Paid project</title>
    <link rel="stylesheet" href="./style.css">
</head>

<body>
    <!-- For Each table form DB-->

    <?php
    $table_query = "show tables;";
    $tables = $mysqli->query($table_query);
    while ($tab = $tables->fetch_array()) {
        $tablename = $tab[0];
        $column_query = " DESC $tablename";
        $row_query = " SELECT * FROM $tablename";


        $columns = $mysqli->query($column_query); //col table 
        $rows = $mysqli->query($row_query); //row table 
        $col = [];
        while ($x = $columns->fetch_assoc()) {
            array_push($col, $x['Field']);
        }

    ?>
        <section>
            <!-- Columns per table -->
            <table class="<?php echo $tablename?>" id="myTable">
                <!-- Fields -->
                <tr>
                    <?php
                    foreach ($col as $x) {
                    ?>
                        <th><?php echo $x; ?></th>
                    <?php
                    }
                    ?>
                </tr>
                <!-- rows per table -->
                <?php
                $row_index = 0;
                while ($row = $rows->fetch_assoc()) {
                ?>
                    <tr class="<?php echo $row_index; ?>">
                        <!-- columns per row -->
                        <?php
                        foreach ($col as $x) {
                        ?>
                            <td class="v <?php echo $tablename . " " . $x . " " . $row_index; ?>" contenteditable><?php echo $row[$x]; ?></td>
                        <?php
                        }
                        ?>
                        <td class="delete"><svg class="<?php echo $tablename?> delete" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z" />
                                <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z" />
                            </svg></td>
                    </tr>
                <?php
                    $row_index++;
                }
                ?>
                
            </table>
            <button class="create" style="margin-left: 48%; margin-top: 20px">Create row</button>

              <!-- <script>
                function myCreateFunction(){
                    var table = document.getElementById("myTable");
                    var row = table.insertRow();
                    var cell1 = row.insertCell(0);
                    var cell2 = row.insertCell(1);
                    var cell3 = row.insertCell(2);
                    cell1.innerHTML = "";
                    cell2.innerHTML = "";
                    cell3.innerHTML = "";
                }
              </script> -->
        </section>
        <div id="remove_cursor" contenteditable style="visibility: hidden;">

        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="./index.js"></script>
</body>

</html>
<?php
    }
?>