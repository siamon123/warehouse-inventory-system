<?php
  require_once('includes/load.php');
  require_once('controllers/UserController.php');

  $controller = new UserController();
  $data = $controller->edit();
  
  $page_title = $data['page_title'];
  $e_user = $data['e_user'];
  $groups = $data['groups'];

  require_once('views/edit_user.php');
?>
