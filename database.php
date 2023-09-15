<?php
    $SERVER = "localhost";
    $DATABASE = "testdatabase";
    $DB_USERNAME = "root";
    $DB_PASSWORD = "";

    try{
        $con = new PDO("mysql:host=$SERVER;dbname=$DATABASE", $DB_USERNAME, $DB_PASSWORD);
    }
    catch(PDOException $e){
        echo "Connection error! ".$e->getMessage();
    }

    function requestData($q){
        global $con;
        return $con->query($q);
    }
?>