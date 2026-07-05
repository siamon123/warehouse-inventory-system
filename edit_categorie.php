<?php
  require_once('includes/load.php');
  require_once('controllers/CategoryController.php');

  $controller = new CategoryController();
  $data = $controller->edit();
  
  $page_title = $data['page_title'];
  $categorie = $data['categorie'];

  require_once('views/edit_categorie.php');
?>
