<?php
  require_once('includes/load.php');
  require_once('controllers/SaleController.php');

  $controller = new SaleController();
  $data = $controller->monthly();
  
  $page_title = $data['page_title'];
  $sales = $data['sales'];

  require_once('views/monthly_sales.php');
?>
