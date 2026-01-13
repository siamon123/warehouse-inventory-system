<?php
  require_once('includes/load.php');
  require_once('controllers/UserController.php');

  $controller = new UserController();
  $data = $controller->index();
  
  $page_title = $data['page_title'];
  $all_users = $data['all_users'];

  require_once('views/users.php');
?>
