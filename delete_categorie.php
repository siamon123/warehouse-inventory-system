<?php
  require_once('includes/load.php');
  if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
?>
<?php
  $categorie = find_by_cat_id((int)$_GET['id']);
  if(!$categorie){
    $session->msg("d","Missing Categorie id.");
    redirect('categorie.php');
  }
?>
<?php
$id = $categorie['id'];
$sql = "DELETE FROM categories WHERE id='{$id}'";
$result = mysqli_query($con,$sql);
if($result && mysqli_affected_rows($con) == 1){
  $session->msg("s","Categorie deleted.");
  redirect('categorie.php');
} else {
  $session->msg("d","Categorie deletion failed.");
  redirect('categorie.php');
}

?>
