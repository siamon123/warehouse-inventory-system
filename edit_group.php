<?php
  require_once('includes/load.php');
  require_once('controllers/GroupController.php');

  $controller = new GroupController();
  $data = $controller->edit();
  
  $page_title = $data['page_title'];
  $e_group = $data['e_group'];

  require_once('views/edit_group.php');
?>
