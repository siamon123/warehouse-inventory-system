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
$id = (int)$product['id'];
$sql = "DELETE FROM products WHERE id='{$id}'";
$result = mysqli_query($con,$sql);
if($result && mysqli_affected_rows($con) == 1){
  $session->msg("s","Products deleted.");
  redirect('product.php');
} else {
  $session->msg("d","Products deletion failed.");
  redirect('product.php');
}

?>
