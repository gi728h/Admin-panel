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
    die('Connect Error (' .
        $mysqli->connect_errno . ') ' .
        $mysqli->connect_error);
}
?>
<?php
$table = $_POST["table"];
$column = $_POST["column"];
$string = $_POST["string"];
$q = "USE test;";
$res = $mysqli->query($q);
$query = "SELECT * FROM ".$table." WHERE ".$column." LIKE '%".$string."%'";
$res = $mysqli->query($query);
if(!$res){
    die("query failed" . $mysqli->error);
}else{
    if ($res->num_rows > 0) {
        $firstRow = $res->fetch_assoc();
        $columnNames = array_keys($firstRow);
        $res->data_seek(0);
        $rows = [];
        while ($row = $res->fetch_assoc()) {
            $row_object = new stdClass();
            foreach ($columnNames as $columnName) {
                $row_object->$columnName = $row[$columnName];
            }
            array_push($rows,$row_object);
        }
        $json = $json = json_encode($rows);
        echo $json;
    } else {
        echo "No results found.";
    }
}
?>
