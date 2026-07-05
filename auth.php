<?php include_once('includes/load.php'); ?>
<?php
csrf_verify();
$req_fields = array('username','password' );
validate_fields($req_fields);
$username = remove_junk($_POST['username']);
$password = remove_junk($_POST['password']);

if(empty($errors)){
  $user_id = authenticate($username, $password);
  if($user_id){
    // crear sesión con id
     $session->login($user_id);
    // actualizar tiempo de inicio de sesión
     updateLastLogIn($user_id);
     $session->msg("s", "Bienvenido a OSWA-INV.");
     redirect('home.php',false);

  } else {
    $session->msg("d", "Nombre de usuario y/o contraseña incorrectos.");
    redirect('index.php',false);
  }

} else {
   $session->msg("d", $errors);
   redirect('index.php',false);
}

?>
