<?php
  require_once('includes/load.php');
  require_once('controllers/GroupController.php');

  $controller = new GroupController();
  $data = $controller->index();
  
  $page_title = $data['page_title'];
  $all_groups = $data['all_groups'];

  require_once('views/groups.php');
?>
