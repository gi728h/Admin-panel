<!-- Establish Connection -->
<?php
$mysqli = mysqli_init();
mysqli_ssl_set($mysqli,NULL,NULL, "c:\Users\subod\Downloads\DigiCertGlobalRootCA.crt.pem", NULL, NULL);
mysqli_real_connect($mysqli, 'dbms.mysql.database.azure.com', 'subodh', 'Lomdu@502', 'payrollmanagement', 3306, MYSQLI_CLIENT_SSL);
if (mysqli_connect_error()) {
die('Failed to connect to MySQL: '.mysqli_connect_error());
}

// $user = 'root';
// $password = '';
// $database = 'test';
// $servername = 'localhost:3306';
// $mysqli = new mysqli(
//     $servername,
//     $user,
//     $password,
//     $database
// );

// if ($mysqli->connect_error) {
//     die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
// }
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
                                <td class="v <?php echo $tablename . " " . $x . " " . $row_index; ?>" ><?php echo $row[$x].'<svg class="pen" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16"><path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/><path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/></svg>'; ?></td>
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
            function sleep(ms) {
                return new Promise(resolve => setTimeout(resolve, ms));
            }
            window.onload = function() {
                if (sessionStorage.getItem("insert")) {
                    console.log("Record inserted successfully.")
                    sessionStorage.clear()
                    $("body").append('<div class="alert alert-primary" role="alert">Record inserted successfully.</div>')
                    sleep(2000);
                    $(".alert").animate({
                            opacity: 0
                        },
                        5000,
                        function() {
                            $elementToDisappear.hide();
                        }
                    );
                }
                if (sessionStorage.getItem("delete")) {
                    console.log("Record deleted successfully.")
                    $("body").append('<div class="alert alert-primary" role="alert">Record deleted successfully.</div>')
                    sessionStorage.clear()
                    sleep(2000);
                    $(".alert").animate({
                            opacity: 0
                        },
                        5000,
                        function() {
                            $elementToDisappear.hide();
                        }
                    );
                }
            }
        </script>
</body>

</html>
<?php
    }
?>