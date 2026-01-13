<?php
  require_once('includes/load.php');
  require_once('controllers/SaleController.php');

  $controller = new SaleController();
  $controller->delete();
?>
