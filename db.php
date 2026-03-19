<?php

  $mysqli = new mysqli("localhost","2414582","Kangaroo@123","db2414582");

  if ($mysqli -> connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
    exit();
  }
?>
