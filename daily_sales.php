<?php
  require_once('includes/load.php');
  require_once('controllers/SaleController.php');

  $controller = new SaleController();
  $data = $controller->daily();
  
  $page_title = $data['page_title'];
  $sales = $data['sales'];

  require_once('views/daily_sales.php');
?>
