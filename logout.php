<?php
    session_start();

    if(session_destroy()){
        unset($_SESSION['userName']);
        header("location: index.php");
    }
?>