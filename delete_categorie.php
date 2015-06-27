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
  $delete_id = delete_categorie_by_id((int)$categorie['id']);
  if($delete_id){
      $session->msg("s","Categorie deleted.");
      redirect('categorie.php');
  } else {
      $session->msg("d","Categorie deletion failed.");
      redirect('categorie.php');
  }
?>
