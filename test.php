<?php
$conn = mysqli_init();
mysqli_ssl_set($conn,NULL,NULL, "c:\Users\subod\Downloads\DigiCertGlobalRootCA.crt (3).pem", NULL, NULL);
$result = mysqli_real_connect($conn, 'dbms.mysql.database.azure.com', 'subodh', 'Lomdu@502', 'test', 3306, MYSQLI_CLIENT_SSL);
if (mysqli_connect_error()) {
die('Failed to connect to MySQL: '.mysqli_connect_error());
}

?>