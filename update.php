
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
//     die('Connect Error (' .
//         $mysqli->connect_errno . ') ' .
//         $mysqli->connect_error);
// }
?>
<?php
$table = $_POST["table"];
$attribute = $_POST["attribute"];
$value = $_POST["value"];
$update = $_POST["update"];
$selectedElement = $_POST["selectedElement"];
$selectedValue = $_POST["selectedValue"];
$q = "USE payrollmanagement;";
$res = $mysqli->query($q);
$query = "UPDATE " . $table . " SET " . $selectedElement . "=" . "'$update'" . " WHERE ";
for($i = 0;$i < sizeof($attribute);$i++){
    if($i == sizeof($attribute)-1){
        $query .= ($attribute[$i]."="."'$value[$i]'".";");
    }else {
        $query .= ($attribute[$i]."="."'$value[$i]'"." AND ") ;
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