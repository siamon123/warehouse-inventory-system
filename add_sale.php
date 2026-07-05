<?php
  require_once('includes/load.php');
  require_once('controllers/SaleController.php');

  $controller = new SaleController();
  $data = $controller->add();
  
  $page_title = $data['page_title'];

  require_once('views/add_sale.php');
?>
