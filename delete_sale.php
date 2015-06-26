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
$id = (int)$d_sale['id'];
$sql = "DELETE FROM sales WHERE id='{$id}'";
$result = mysqli_query($con,$sql);
if($result && mysqli_affected_rows($con) == 1){
  $session->msg("s","sale deleted.");
  redirect('sales.php');
} else {
  $session->msg("d","sale deletion failed.");
  redirect('sales.php');
}

?>
