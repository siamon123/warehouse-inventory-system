<?php
  require_once('includes/load.php');
  require_once('controllers/GroupController.php');

  $controller = new GroupController();
  $data = $controller->add();
  
  $page_title = $data['page_title'];

  require_once('views/add_group.php');
?>
