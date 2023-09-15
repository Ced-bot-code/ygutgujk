<?php
  $UNIX = time();

  function getLocalTime($timestamp){
    return gmdate("Y-M-d H:i:s", $timestamp + 28800);
  }

?>