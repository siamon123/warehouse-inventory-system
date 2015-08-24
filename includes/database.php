<?php
 require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . "config.php");
  $con = mysqli_connect(DB_SERVER,DB_USER,DB_PASS);
  if(!$con){
    die('<pre> Database Connection Failed '.mysqli_connect_error().'</pre>' );
  } else {
    $select_db = $con->select_db(DB_NAME);
    if(!$select_db){
      die('Sorry failed to select Database');
    }
  }

?>
