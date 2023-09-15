<?php
    include "database.php";
    $imgID = $_GET['imgID'];

    $stmt = $con->prepare("SELECT profilePic FROM accounts WHERE id = ?");
    $stmt->bindParam(1, $imgID);
    $stmt->execute();

    $img = null;
    while($listImg = $stmt->fetch()){
        $b64 = base64_encode($listImg['profilePic']);
    }
?>
<img style="width:auto; height:auto;" src="data:image/jpeg;base64,<?= $b64; ?>">