<?php
    include "database.php";
    
    $stmtDelete = $con->prepare("DELETE FROM accounts WHERE id=?");
    
    $stmtDelete->execute([
        $_GET['id']
    ]);

    header("location: viewRecords.php?res=0");
?>