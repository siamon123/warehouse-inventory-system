<?php
  require_once('includes/load.php');
  require_once('controllers/UserController.php');

  $controller = new UserController();
  $data = $controller->add();
  
  $page_title = $data['page_title'];
  $groups = $data['groups'];

  require_once('views/add_user.php');
?>
