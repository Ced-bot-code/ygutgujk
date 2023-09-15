<?php
    include "database.php";
    include "timers.php";

    $s = isset($_GET['res']) ? $_GET['res'] : null;
    
    switch($s){
        case "1":
            echo "Successfully updated.";
            break;
        case "0":
            echo "Successfully deleted.";
            break;
        case "-1":
            echo "Query not found.";
            break;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Records</title>
    <link rel="stylesheet" href="tables.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="scripts/jQueryv2.2.2min.js"></script>
    <style>
        *{
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .listEdit{
            text-decoration:none;
        }

        .listEdit:hover{
            text-decoration:underline;
        }
    </style>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Roboto');
*{
  font-family:'Roboto', sans-serif;
}
.box{
  max-width:700px;
  position:relative;
  width:100%;
  margin:0 auto;
}
h1 small{
  font-size:0.6em;
  color:#666;
}
.skeptik-table{
  width:100%;
  border-collapse:collapse;
  min-width:500px;
}
.skeptik-table tr th, .skeptik-table tr td{
  border:1px solid #e3e3e3;
  padding:10px;
}
.skeptik-table tr th{
  border-bottom:1px solid #666;
}
.skeptik-table tr:nth-child(even){
  background-color:#f3f3f3;
}
.skeptik-table tr:hover td{
  background-color:#e3e3e3;
}
.skeptik-table{
  margin-bottom:10px;
}
@media(max-width:1024px){
  .skeptik-overflow{
    overflow-x:scroll;
   
  }
  .skeptik-table{
  margin-bottom:0px;
}

}
.skeptik-paging{
  font-size:0px;
}
.skeptik-paging span{
    border:1px solid #e3e3e3;
  border-right:none;
  display:inline-block;
  padding:10px;
  cursor:pointer;
  border-left:none;
  font-size:15px;
}
.skeptik-paging span:first-child{
  border-top-left-radius:4px;
  border-bottom-left-radius:4px;
  border:1px solid #e3e3e3;
  border-right:none;
  display:inline-block;
  padding:10px;
  cursor:pointer;
}
.skeptik-paging span:last-child{
  border-top-right-radius:4px;
  border-bottom-right-radius:4px;
  border:1px solid #e3e3e3;
  border-right:1px solid #e3e3e3;;
  display:inline-block;
  padding:10px;
  cursor:pointer;
  border-left:none;
}
.skeptik-paging span:hover{background-color:#4286f4;color:white;
border-color:#4286f4}
.skeptik-selected{
  background-color:#4286f4;color:white;
border-color:#4286f4 !important;
}
    </style>
</head>
<body>
    <div class="skeptikfull">
    <table class="form_table skeptik-table">
        <tr class="skeptik-header">
            <th>User name</th>
            <th>Date created</th>
            <th>Image</th>
            <th></th>
        </tr>
        <?php
            $i=0;
            
            foreach(requestData("SELECT * FROM accounts") as $lists){
                ?>
                    <tr>
                        <td><?= $lists['userName'];?></td>
                        <td><?= getLocalTime($lists['timeCreated']);?></td>
                        <td>
                            <a href="viewImage.php?imgID=<?= $lists['id'];?>" title="Click to view" target="_blank">
                              <img style="width:53px; height:auto" src="data:image/jpeg;base64,<?= base64_encode($lists['profilePic']);?>" alt="">
                            </a>
                        </td>
                        <td><a class="listEdit" href="editUser.php?userID=<?= $lists['id'];?>">Edit</a></td>
                    </tr>
                <?php
                $i++;
            }
        ?>
    </table>
    <div class="skeptik-paging"></div>
</div>
    <script>
      $(function() {
  $(".skeptik-table").wrap("<div class='skeptik-overflow'></div>");
  
  //BEGIN OPPERATIONS
var box = $(".skeptik-table tr").not(".skeptik-header");
  //Get Lengthx
  var total = $(".skeptikfull");
  for(var l = 1; l <= total.length; l+=1){
    console.log(l);
    //Begin Creating Each Functions

  }
  
  $(".skeptikfull").each(function(){
    var tl = $(this).find(".skeptik-table").find("tr").not(".skeptik-header");
    console.log(tl.length);
    
    //begin second loop
    for( var i = 0; i*5 < tl.length; i+=1 ) {
      tl.slice(i*5, i*5+5).each(function(){
      $(this).addClass("skeptik"+(i+1))
        $(this).addClass("skeptikitem");
      });
      //end of each function
      $(this).find(".skeptik-paging").append("<span>"+(i+1)+"</span>");
    }
});

  $(".skeptikitem").hide();
  $(".skeptik"+1).show();
  $(".skeptik-paging span:first-child").addClass("skeptik-selected");
  
});

//Click Event
$(".skeptik-paging").on( "click", "span", function(){
    var number = $(this).html();
  $(this).parent().siblings().find(".skeptikitem").hide();
  $(this).parent().siblings().find(".skeptik"+number).show();
  $(this).parent().children().removeClass("skeptik-selected");
  $(this).addClass("skeptik-selected");
} );
    </script>
</body>
</html>
<!-- https://codepen.io/rorofat/pen/WpmobL -->