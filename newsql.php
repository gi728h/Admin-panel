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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
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
            <table class="<?php echo $tablename ?>" id="myTable">
                <thead>
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
                </thead>
                <tbody>
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
                            <td><button style="height:20px; width:20px; margin:0;" class="<?php echo $tablename ?> delete"></button></td>
                        </tr>
                    <?php
                        $row_index++;
                    }
                    ?>
                </tbody>
            </table>
            <button class="create" style="margin-left: 48%; margin-top: 20px">Create row</button>
            <form class="form">
                <input type="text" placeholder="search" name="search">
                <select id="column" name="column">
                    <?php
                    foreach ($col as $x) {
                    ?>
                        <option value="<?php echo $x ?>"><?php echo $x ?></option>
                    <?php
                    }
                    ?>
                </select>
                <button type="button" class="search"></button>
            </form>

        </section>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <script src="./insert.js"></script>
        <script src="./delete.js"></script>
        <script src="./update.js"></script>
        <script>
            window.onload = function() {
                if(sessionStorage.getItem("insert")){
                    console.log("Record inserted successfully.")
                    sessionStorage.clear()
                    $("body").append('<div class="alert alert-primary" role="alert">Record inserted successfully.</div>')
                }
                if(sessionStorage.getItem("delete")){
                    console.log("Record deleted successfully.")
                    $("body").append('<div class="alert alert-primary" role="alert">Record deleted successfully.</div>')
                    sessionStorage.clear()
                }
            }
        </script>
</body>

</html>
<?php
    }
?>