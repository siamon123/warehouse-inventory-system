<?php
  require_once('includes/load.php');
  require_once('controllers/UserController.php');

  $controller = new UserController();
  $controller->delete();
?>
