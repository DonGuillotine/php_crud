<?php 
// Database credentials
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'crud');

// Attempt to connect to MySql database
$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check Connection
if($connection === false){
    die("ERROR: COULD NOT CONNECT. " . mysqli_connect_error());
}


?>