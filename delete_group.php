<?php
  require_once('includes/load.php');
  require_once('controllers/GroupController.php');

  $controller = new GroupController();
  $controller->delete();
?>
