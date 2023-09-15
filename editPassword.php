<?php
    include "database.php";

    $getUserID = $_GET['userID'];
    $errMessage = null;
    
    $stmt = $con->prepare("SELECT * FROM accounts WHERE id= ?");

    $stmt->bindParam(1, $getUserID);
    $stmt->execute();

    foreach($stmt as $queries){
        $USERNAME = $queries['userName'];
        $fullName = $queries['fullName'];
    }


    if($_SERVER['REQUEST_METHOD']=='POST'){
      $CURRENT_PASSWORD = $_POST['current_Pass'];
      $NEW_PASSWORD1 = $_POST['password_1'];
      $NEW_PASSWORD2 = $_POST['password_2'];


      $stmtCurrentPassword = $con->prepare("SELECT * FROM accounts WHERE id=?");
      $passHash = null;

      $stmtCurrentPassword->bindParam(1, $getUserID);
      $stmtCurrentPassword->execute();

      while($rw = $stmtCurrentPassword->fetch()){
        $passHash = $rw['pass_word'];
      }

      if(password_verify($CURRENT_PASSWORD, $passHash)){
          if($NEW_PASSWORD1 == $NEW_PASSWORD2){
              
              $stmtUpdPassword = $con->prepare("UPDATE accounts SET pass_word=? WHERE id=?");
              
              $stmtUpdPassword->execute([
                password_hash($NEW_PASSWORD1, PASSWORD_BCRYPT),
                $getUserID
              ]);
    
              header("location: viewRecords.php?res=1");
          }
          else{
            $errMessage = '<div class="errPass errMessage">
            <div class="errMessageBox">&#10006; &nbsp; Password does not match.</div>
          </div>';
          }
      }
      else{
        $errMessage = '<div class="errPass errMessage">
        <div class="errMessageBox">&#10006; &nbsp; Incorrect password.</div>
      </div>';
      }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit user</title>
        <link rel="stylesheet" href="form1.css">
        <style>
          .button-5 {
            align-items: center;
            background-clip: padding-box;
            background-color: #fa6400;
            border: 1px solid transparent;
            border-radius: .25rem;
            box-shadow: rgba(0, 0, 0, 0.02) 0 1px 3px 0;
            box-sizing: border-box;
            color: #fff;
            cursor: pointer;
            display: inline-flex;
            font-family: system-ui,-apple-system,system-ui,"Helvetica Neue",Helvetica,Arial,sans-serif;
            font-size: 16px;
            font-weight: 600;
            justify-content: center;
            line-height: 1.25;
            margin: 0;
            min-height: 3rem;
            padding: calc(.875rem - 1px) calc(1.5rem - 1px);
            position: relative;
            text-decoration: none;
            transition: all 250ms;
            user-select: none;
            -webkit-user-select: none;
            touch-action: manipulation;
            vertical-align: baseline;
            width: auto;
          }

          .button-5:hover,
          .button-5:focus {
            background-color: #973d00;
            box-shadow: rgba(0, 0, 0, 0.1) 0 4px 12px;
          }

          .button-5:hover {
            transform: translateY(-1px);
          }

          .button-5:active {
            background-color: #c85000;
            box-shadow: rgba(0, 0, 0, .06) 0 2px 4px;
            transform: translateY(0);
          }

          .errPass{
            padding:20px 0 20px;
            font-size:0.8em;
          }

          .errMessageBox{
            background-color: #a38185;
            border:1px solid #ab4450;
            padding: 15px;
          }
        </style>
    </head>
    <body>
        <div class="login-box">
    <h2>Edit password</h2>
    <form id="pa" action="<?= htmlspecialchars($_SERVER['PHP_SELF'])."?userID=".$getUserID;?>" method="post">
      <input type="hidden" name="id" value="<?=$getUserID;?>">
      <div class="user-box">
        <div id="errPass">
        </div>
        <input type="password" id="p1" name="current_Pass" required/>
        <label>Current password *</label>
      </div>
      <div class="user-box">
        <div id="errPass">
        </div>
        <input type="password" id="p1" name="password_1" required/>
        <label>New password *</label>
      </div>
      <div class="user-box">
        <input type="password" id="p2" name="password_2" required/>
        <label>Retype new password *</label>
      </div>
      <?= $errMessage; ?>
      <div style="text-align:center; padding:5px 0 20px">
        <input class="button-5" type="submit" value="Update user">
      </div>
    </form>
  </div>
</body>
</html>
