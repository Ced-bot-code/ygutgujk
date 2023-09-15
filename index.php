<?php

  include "database.php";
  include "verifyAccount.php";

  session_start();

  $errMessage = null;
  
  if($_SERVER['REQUEST_METHOD'] == 'POST'){
      $USERNAME = $_POST['userName'];
      $PASSWORD = $_POST['password'];

      $stmt = $con->prepare("SELECT id, userName, pass_word, profilePic FROM accounts WHERE userName=?");

      $stmt->bindParam(1, $USERNAME);
      $stmt->execute();

      $pass = '';
      while($rw = $stmt->fetch()){
        $pass = $rw['pass_word'];
        $ProfilePic = $rw['profilePic'];
      }

      if(password_verify($PASSWORD, $pass)){
        $_SESSION['profilePic'] = $ProfilePic;
        $_SESSION['userName'] = $USERNAME;
        header("location: main.php");
      }
      else{
        $errMessage = '<div class="errPass errMessage">
        <div class="errMessageBox">&#10006; &nbsp; Incorrect username or password.</div>
      </div>';
      }
  }

  if(isset($_SESSION['userName'])){
    header("location: main.php");
  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="form1.css">
  <link rel="shortcut icon" href="media/logo.jpg" type="image/x-icon">
  <!-- HTML !-->
<!-- <button class="button-5" role="button">Button 5</button> -->
  <style>

    body{
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

/* CSS */
.errMessage{
  color:black;
}

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
    <h2>Login</h2>
    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
      <div class="user-box">
        <input type="text" name="userName" id="uName" required/>
        <label>Username</label>
      </div>
      <div class="user-box">
        <input type="password" id="p1" name="password" required/>
        <label>Password</label>
      </div>
      <?= $errMessage;?>
      <div style="text-align:center; padding-top:20px;">
        <input class='button-5' type="submit" value="Login">
      </div>
    </form>
  </div>
</body>
</html>