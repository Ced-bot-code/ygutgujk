<?php
    include "database.php";
    include "verifyAccount.php";

    $userName = $_GET['uName'];
    $getBOOL = !isUserExist($userName, "USER") ? "YES" : "NO";
    
    echo $getBOOL;
?>