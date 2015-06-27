<?php
  require_once('includes/load.php');
  if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
?>
<?php
  $d_user = find_by_user_id((int)$_GET['id']);
  if(!$d_user){
    $session->msg("d","Missing user id.");
    redirect('users.php');
  }
?>
<?php
  $delete_id = delete_user_by_id((int)$d_user['id']);
  if($delete_id){
      $session->msg("s","User deleted.");
      redirect('users.php');
  } else {
      $session->msg("d","user deletion failed.");
      redirect('sales.php');
  }
?>
