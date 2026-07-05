<?php
  require_once('includes/load.php');
  require_once('controllers/CategoryController.php');

  $controller = new CategoryController();
  $data = $controller->index();
  
  $page_title = $data['page_title'];
  $all_categories = $data['all_categories'];

  require_once('views/categories.php');
?>
