<?php
  require_once('includes/load.php');
  if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
?>
<?php
  $product = find_by_product_id((int)$_GET['id']);
  if(!$product){
    $session->msg("d","Missing Product id.");
    redirect('product.php');
  }
?>
<?php
  $delete_id = delete_product_by_id((int)$product['id']);
  if($delete_id){
      $session->msg("s","Products deleted.");
      redirect('product.php');
  } else {
      $session->msg("d","Products deletion failed.");
      redirect('product.php');
  }
?>
