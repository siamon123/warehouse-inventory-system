<?php
  require_once('includes/load.php');
  require_once('controllers/CategoryController.php');

  $controller = new CategoryController();
  $controller->delete();
?>
