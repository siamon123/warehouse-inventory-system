<?php include_once('includes/load.php'); ?>
<?php
$req_fields = array('username','password' );
validate_fields($req_fields);
$username = remove_junk($_POST['username']);
$password = remove_junk($_POST['password']);

  if(empty($errors)){

    $user = authenticate_v2($username, $password);

        if($user):
           // crear sesión con id
           $session->login($user['id']);
           // actualizar tiempo de inicio de sesión
           updateLastLogIn($user['id']);
           // redirigir al usuario a su página de inicio según su nivel
           if($user['user_level'] === '1'):
             $session->msg("s", "Hola ".$user['username'].", Bienvenido a OSWA-INV.");
             redirect('admin.php',false);
           elseif ($user['user_level'] === '2'):
              $session->msg("s", "Hola ".$user['username'].", Bienvenido a OSWA-INV.");
             redirect('special.php',false);
           else:
              $session->msg("s", "Hola ".$user['username'].", Bienvenido a OSWA-INV.");
             redirect('home.php',false);
           endif;

        else:
          $session->msg("d", "Nombre de usuario y/o contraseña incorrectos.");
          redirect('index.php',false);
        endif;

  } else {

     $session->msg("d", $errors);
     redirect('login_v2.php',false);
  }

?>
