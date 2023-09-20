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
$attribute = $_POST["attribute"];
$value = $_POST["value"];
$q = "USE test;";
$res = $mysqli->query($q);
$query = "DELETE FROM " . $table . " WHERE ";
for($i = 0;$i < sizeof($attribute);$i++){
    $query .= ($attribute[$i]."="."'$value[$i]'"." AND ") ;
    if($i == sizeof($attribute)-1){
        $query .= ($attribute[$i]."="."'$value[$i]'".";");
    }
}
echo $query;
$res = $mysqli->query($query);
if(!$res){
    die("query failed" . $mysqli->error);
}else{
    echo $res;
}

?>