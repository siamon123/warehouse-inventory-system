<?php
  require_once('includes/load.php');
  require_once('controllers/SaleController.php');

  $controller = new SaleController();
  $data = $controller->edit();
  
  $page_title = $data['page_title'];
  $sale = $data['sale'];
  $product = $data['product'];

  require_once('views/edit_sale.php');
?>
