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
$id = (int)$d_user['id'];
$sql = "DELETE FROM users WHERE id='{$id}'";
$result = mysqli_query($con,$sql);
if($result && mysqli_affected_rows($con) == 1){
  $session->msg("s","User deleted.");
  redirect('users.php');
} else {
  $session->msg("d","user deletion failed.");
  redirect('users.php');
}

?>
