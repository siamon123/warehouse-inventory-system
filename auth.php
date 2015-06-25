<?php
  require_once('includes/load.php');
?>
<?php
$req_fields = array('username','password' );
validate_fields($req_fields);
$username = remove_junk($_POST['username']);
$password = remove_junk($_POST['password']);

if(empty($errors)){
  $user_id = authenticate($username, $password);

  if($user_id){
     $session->login($user_id);
     $session->msg("s", "Wel Come.");
     redirect('home.php',false);
  } else {

    $session->msg("d", "Sorry Username/Password incorrect.");
    redirect('index.php',false);
  }

} else {
   $session->msg("d", $errors);
   redirect('index.php',false);
}

?>
