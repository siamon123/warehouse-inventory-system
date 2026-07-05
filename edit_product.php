<?php
  require_once('includes/load.php');
  require_once('controllers/ProductController.php');

  $controller = new ProductController();
  $data = $controller->edit();
  
  $page_title = $data['page_title'];
  $product = $data['product'];
  $all_categories = $data['all_categories'];
  $all_photo = $data['all_photo'];

  require_once('views/edit_product.php');
?>
