<?php
/**
 * Simple database setup by mysql:PDO
 * I think these all you know perfectly about creating a database
 * I've just created an local site setup
 **/
 
$servername = "localhost";
$username = "root";
$password = "";
$dbName = "db_clean_url";

try {
    $db = new PDO("mysql:host=$servername;dbname=$dbName", $username, $password);
    // set the PDO error mode to exception
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }
?>
