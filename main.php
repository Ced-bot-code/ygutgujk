<?php
    session_start();

    if(!isset($_SESSION['profilePic'])){
        header("location: index.php");
    }
    
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="media/logo.jpg" type="image/x-icon">
        <title>Welcome <?= $_SESSION['userName'];?></title>
        <link rel="stylesheet" href="styles/main.css">
        <style>
            .content{
                padding: 30px 0 0 30px;
            }
        </style>
    </head>
    <body>
        <div>
    <header id="navbar">
  <nav class="navbar-container container">
    <a href="main.php" class="home-link">
      <div class="navbar-logo">
        <img style="width:30px; height:30px; border-radius:50%" src="data:image/jpeg;base64,<?= base64_encode($_SESSION['profilePic'])?>" alt="">
      </div>
      <span title="Wellmade Motors and Development Corp.">WMDC</span>
    </a>
    <button type="button" id="navbar-toggle" aria-controls="navbar-menu" aria-label="Toggle menu" aria-expanded="false">
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <div id="navbar-menu" aria-labelledby="navbar-toggle">
      <ul class="navbar-links">
        <li class="navbar-item"><a class="navbar-link" href="main.php" title="Home">Home</a></li>
        <li class="navbar-item"><a class="navbar-link" href="logout.php" title="Logout">Logout</a></li>
      </ul>
    </div>
  </nav>
    </header>
        </div>
        <div class="content">
            <h1>Welcome</h1>
        </div>
    </body>
</html>
<script>
    const navbarToggle = navbar.querySelector("#navbar-toggle");
    const navbarMenu = document.querySelector("#navbar-menu");
    const navbarLinksContainer = navbarMenu.querySelector(".navbar-links");

    let isNavbarExpanded = navbarToggle.getAttribute("aria-expanded") === "true";

    const toggleNavbarVisibility = () => {
      isNavbarExpanded = !isNavbarExpanded;
      navbarToggle.setAttribute("aria-expanded", isNavbarExpanded);
    };

    navbarToggle.addEventListener("click", toggleNavbarVisibility);
    navbarLinksContainer.addEventListener("click", (e) => e.stopPropagation());
    navbarMenu.addEventListener("click", toggleNavbarVisibility);
</script>