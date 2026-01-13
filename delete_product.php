<?php
  require_once('includes/load.php');
  require_once('controllers/ProductController.php');

  $controller = new ProductController();
  $controller->delete();
?>
