<?php

//initialize the session object
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'exam_results');
 
/* Attempt to connect to MySQL database */
$db_link= mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
