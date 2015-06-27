<?php
  require_once('includes/load.php');
  if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
?>
<?php
  $d_sale = find_by_sale_id((int)$_GET['id']);
  if(!$d_sale){
    $session->msg("d","Missing sale id.");
    redirect('sales.php');
  }
?>
<?php
  $delete_id = delete_sale_by_id((int)$d_sale['id']);
  if($delete_id){
      $session->msg("s","sale deleted.");
      redirect('sales.php');
  } else {
      $session->msg("d","sale deletion failed.");
      redirect('sales.php');
  }
?>
