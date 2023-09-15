<?php
    include "database.php";
    include "verifyAccount.php";
    include "fileControl.php";
    include "timers.php";

    session_start();
    $_SESSION['completeUsername'] = null;
    $_SESSION['completeName'] = null;
    $_SESSION['password_1'] = null;
    $_SESSION['password_2'] = null;

    $errMessage = '';



    if($_SERVER['REQUEST_METHOD']=='POST'){

      $USERNAME              = $_POST['userName'];
      $PASSWORD_1            = $_POST['password_1'];
      $PASSWORD_2            = $_POST['password_2'];
      $FULL_NAME             = $_POST['fullName'];
      $PROFILE_PIC           = $_FILES['profilePic']['tmp_name'];
      $PROFILE_PIC_SIZE      = $_FILES['profilePic']['size']; 
      $PROFILE_PIC_FILE_TYPE = $_FILES['profilePic']['type'];
    

      $textPlain = explode("/", $PROFILE_PIC_FILE_TYPE);

      if(isUserExist($USERNAME, "USER")){
        if($PASSWORD_1 == $PASSWORD_2){
          $_SESSION['password_1'] = $PASSWORD_1;
          $_SESSION['password_2'] = $PASSWORD_2;

         if($textPlain[0] == 'image'){
            if($PROFILE_PIC_SIZE <= convertFileSize(512, "kB")){
              if(in_array($textPlain[1], $fileType)){
                $imgData = file_get_contents($PROFILE_PIC);
                  $stmt = $con->prepare("INSERT INTO accounts(userName, pass_word, timeCreated, fullName, profilePic) VALUES(?, ?, ?, ?, ?)");
      
                  $stmt->execute([
                      $USERNAME,
                      password_hash($PASSWORD_1, PASSWORD_BCRYPT),
                      $UNIX,
                      $FULL_NAME,
                      $imgData
                  ]);
                  
                  unset($_SESSION['completeUsername']);
                  unset($_SESSION['completeName']);
                  unset($_SESSION['password_1']);
                  unset($_SESSION['password_2']);
                  header("location: viewRecords.php");
              }
              else{
                $errMessage = '<div class="errPass errMessage">
                                <div class="errMessageBox">The image must be in .jpg, .jpeg, or .png.</div>
                                  </div>';
                $_SESSION['completeUsername'] = $USERNAME;
                $_SESSION['completeName'] = $FULL_NAME;
                $_SESSION['password_1'] = $PASSWORD_1;
                $_SESSION['password_2'] = $PASSWORD_2;

              }
            }
            else{
              $errMessage = '<div class="errPass errMessage">
                                <div class="errMessageBox">The image must not exceed to 512 kB.</div>
                                  </div>';
              $_SESSION['completeUsername'] = $USERNAME;
              $_SESSION['completeName'] = $FULL_NAME;
              $_SESSION['password_1'] = $PASSWORD_1;
              $_SESSION['password_2'] = $PASSWORD_2;

            }
         }
         else{
          $errMessage = '<div class="errPass errMessage">
                  <div class="errMessageBox">The file must be an image!</div>
                    </div>';
          $_SESSION['completeUsername'] = $USERNAME;
          $_SESSION['completeName'] = $FULL_NAME;
          $_SESSION['password_1'] = $PASSWORD_1;
          $_SESSION['password_2'] = $PASSWORD_2;

         }
        }
        else{
            $errMessage = '<div class="errPass errMessage">
            <div class="errMessageBox">&#10006; &nbsp; Password does not match.</div>
          </div>';
          $_SESSION['completeUsername'] = $USERNAME;
          $_SESSION['completeName'] = $FULL_NAME;

        }
      }
      else{
        $errMessage = '<div class="errPass errMessage">
          <div class="errMessageBox">The username <b>'.$USERNAME.'</b> is already taken.</div>
        </div>';
        $_SESSION['completeName'] = $FULL_NAME;
        $_SESSION['password_1'] = $PASSWORD_1;
        $_SESSION['password_2'] = $PASSWORD_2;

      }
    }

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add user</title>
    <link rel="stylesheet" href="form1.css">
    <style>
    .errMessage{
       color:black;
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
    </style>
  </head>
  <body>
    <div class="login-box">
    <h2>Add user</h2>
    <form id="reg_form" action="<?= htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post" enctype="multipart/form-data">
      <div class="user-box">
        <input type="text" name="userName" id="uName" value="<?= $_SESSION["completeUsername"]?>" required>
        <label>Username *</label>
      </div>
      <div class="user-box">
        <div id="errPass">
        </div>
        <input type="password" id="p1" value="<?= $_SESSION['password_1'];?>" name="password_1" required/>
        <label>Password *</label>
      </div>
      <div class="user-box">
        <input type="password" id="p2" value="<?= $_SESSION['password_2'];?>" name="password_2" required/>
        <label>Retype password * </label>
      </div>
      <div class="user-box">
        <input type="text" name="fullName" value="<?= $_SESSION["completeName"]?>" required/>
        <label>Full Name *</label>
      </div>
      <div class="user-box">
      <div style="padding-top:10px; font-size:0.5em">
          Maximum upload file size: 512 kB.
        </div>
        <input id='imgFile' type="file" name="profilePic" accept=".jpeg, .jpg, .png" required/>
      </div>
      <?= $errMessage;?>
      <span id="errmes"></span>
      <div style="text-align:center">
        <input class="button-5" type="submit" value="Save user">
      </div>
    </form>
    </div>
      <script>
        imgExtn = ['jpeg', 'jpg', 'png']
        hhh = 0
        

          function displayError(a, b){
            messages =[
              "The file must be an image",                  // 0
              "Password does not match",                    // 1
              `The username <b>${b}</b> is already taken`,  // 2
              "The image must be in .jpg, .jpeg, or .png",  // 3
              "The image does not exceed to 512 kB"         // 4
            ]

             
             const k = setInterval(()=>{
              hhh++

              if(hhh == 6){
                document.getElementById('errmes').innerHTML = null;
                clearInterval(k);
              }
              else{
                document.getElementById('errmes').innerHTML = `<div class="errPass errMessage">
                  <div class="errMessageBox">${messages[a]}</div>
                    </div>`
              }
            }, 1000)
             
          }

          function checkUser(uName){
            const ajax = new XMLHttpRequest()

            ajax.onload = () =>{
                return "YES" == ajax.responseText ? "YES" : "NO";
            }
            ajax.open("GET", "checkUser.php?uName="+uName);
            ajax.send();
          }

          regForm  = document.getElementById("reg_form");
          userName = document.getElementById("uName"); 
          pass1    = document.getElementById("p1"); 
          pass2    = document.getElementById("p2"); 
          fileType = document.getElementById("imgFile"); 
          FullName = document.getElementById("fullName"); 

          regForm.addEventListener("submit", (e)=>{
                textPlain = fileType.files[0].type.split("/")
                if(checkUser(userName.value) == "NO"){
                  if(pass1.value == pass2.value){
                    if(textPlain[0]=="image"){
                      if(fileType.files[0].size <= 512000){
                        if(!imgExtn.includes(textPlain[1])){
                           e.preventDefault()
                            displayError(3, null)
                        }
                      }
                      else{
                        
                         e.preventDefault()
                        
                        displayError(4, null)
                      }
                    }
                    else{
                       e.preventDefault()
                      displayError(0, null);
                    }
                  }
                  else{
                     e.preventDefault()
                    displayError(1, null);
                  }
                }
                else{
                   e.preventDefault()
                  displayError(2, userName.value)
                }
          })
      </script>
  </body>
</html>

