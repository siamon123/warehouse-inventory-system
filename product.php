<?php
  require_once('includes/load.php');
  require_once('controllers/ProductController.php');

  $controller = new ProductController();
  $data = $controller->index();
  
  $page_title = $data['page_title'];
  $products = $data['products'];

  require_once('views/products.php');
?>
