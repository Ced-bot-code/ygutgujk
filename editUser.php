<?php
    include "database.php";
    include "fileControl.php";

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
      $USERNAME   = $_POST['userName'];
      $FULL_NAME  = $_POST['fullName'];
      $Image      = $_FILES['profilePic']['tmp_name'];
      $Image_size = $_FILES['profilePic']['size'];
      $Image_type = $_FILES['profilePic']['type'];
      $textPlain  = explode("/", $Image_type);

      if(is_uploaded_file($Image)){
        if($textPlain[0] == "image"){
          if($Image_size <= convertFileSize(512, "kB")){
              if(in_array($textPlain[1], $fileType)){
                $imgBLOB = file_get_contents($Image);
  
                $stmtUpd = $con->prepare("UPDATE accounts SET userName=?, fullName=?, profilePic=? WHERE id=?");
  
                $stmtUpd->execute([
                  $USERNAME,
                  $FULL_NAME,
                  $imgBLOB,
                  $getUserID
                ]);
                
                header("location: viewRecords.php?res=1");
              }
              else{
                $errMessage = '<div class="errPass errMessage"><div class="errMessageBox">The file must be in .jpeg, .jpg, or .png.</div>
                </div>';
              }
          }
          else{
            $errMessage = '<div class="errPass errMessage"><div class="errMessageBox">The file must not exceed to 512 kB.</div>
                </div>';
          }
        }
        else{
         $errMessage = '<div class="errPass errMessage"><div class="errMessageBox">The file is not an image.</div>
              </div>';
        }
      }
      else{
        $stmtUpd = $con->prepare("UPDATE accounts SET userName= ?, fullName=? WHERE id=?");
    
          $stmtUpd->execute([
            $USERNAME,
            $FULL_NAME,
            $getUserID
          ]);
  
          header("location: viewRecords.php?res=1");
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
    <h2>Edit user</h2>
    <form id="pa" action="<?= htmlspecialchars($_SERVER['PHP_SELF'])."?userID=".$getUserID;?>" method="post" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?=$getUserID;?>">
      <div class="user-box">
        <input type="text" name="userName" value="<?=$USERNAME?>" id="uName" required>
        <label>Username *</label>
      </div>
      <div class="user-box">
        <input type="text" value="<?= $fullName;?>" name="fullName" required/>
        <label>Full Name *</label>
      </div>
      <div style="padding-bottom:30px">
        To change password, <a href="editPassword.php?userID=<?= $getUserID;?>">click here</a>
      </div>
      <div class="user-box">
        <div>
          Change profile picture
        </div>
        <div style="padding-top:10px; font-size:0.5em">
          Maximum upload file size: 512 kB.
        </div>
        <!-- <input type="file" name="profilePic" accept=".jpg, .jpeg, .png" /> -->
        <input type="file" name="profilePic" />
      </div>
      <?= $errMessage; ?>
      <div style="text-align:center; padding:5px 0 20px">
        <input class="button-5" type="submit" value="Update user">
      </div>
      <div class="margin-top:10px">
        <a href="deleteConfirm.php?id=<?= $getUserID;?>">
          <div style="color:#ab4450">Delete account</div>
        </a>
      </div>
    </form>
  </div>
</body>
</html>