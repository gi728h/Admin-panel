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
$values = $_POST["values"];
$q = "USE test;";
$res = $mysqli->query($q);
$query = "INSERT INTO " . $table . " VALUE (" ;
for($i = 0;$i < sizeof($values);$i++){
    if($i != sizeof($values) - 1){
        $query .= "'$values[$i]'"." , " ;
    }else{
        $query .= "'$values[$i]'".") ";
    }
} 
echo $query."</br>";
$res = $mysqli->query($query);
if(!$res){
    die("query failed" . $mysqli->error);
}else{
    echo $res;
}

?>