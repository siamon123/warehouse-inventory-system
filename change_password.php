<?php
  $page_title = 'Cambiar contraseña';
  require_once('includes/load.php');
  // Comprobar qué nivel de usuario tiene permiso para ver esta página
  page_require_level(3);
?>
<?php $user = current_user(); ?>
<?php
  if(isset($_POST['update'])){

    $req_fields = array('new-password','old-password','id' );
    validate_fields($req_fields);

    if(empty($errors)){

             if(!password_verify($_POST['old-password'], current_user()['password']) && sha1($_POST['old-password']) !== current_user()['password']){
               $session->msg('d', "Tu contraseña antigua no coincide");
               redirect('change_password.php',false);
             }

            $id = (int)$_POST['id'];
            $new_password = password_hash($_POST['new-password'], PASSWORD_DEFAULT);
            $sql = "UPDATE users SET password ='{$db->escape($new_password)}' WHERE id='{$db->escape($id)}'";
            $result = $db->query($sql);
                if($result && $db->affected_rows() === 1):
                  $session->logout();
                  $session->msg('s',"Inicie sesión con su nueva contraseña.");
                  redirect('index.php', false);
                else:
                  $session->msg('d',' ¡Lo sentimos, falló la actualización!');
                  redirect('change_password.php', false);
                endif;
    } else {
      $session->msg("d", $errors);
      redirect('change_password.php',false);
    }
  }
?>
<?php include_once('layouts/header.php'); ?>
<div class="login-page">
    <div class="text-center">
       <h3>Cambiar su contraseña</h3>
     </div>
     <?php echo display_msg($msg); ?>
      <form method="post" action="change_password.php" class="clearfix">
        <?php echo csrf_field(); ?>
        <div class="form-group">
              <label for="newPassword" class="control-label">Nueva contraseña</label>
              <input type="password" class="form-control" name="new-password" placeholder="Nueva contraseña">
        </div>
        <div class="form-group">
              <label for="oldPassword" class="control-label">Contraseña antigua</label>
              <input type="password" class="form-control" name="old-password" placeholder="Contraseña antigua">
        </div>
        <div class="form-group clearfix">
               <input type="hidden" name="id" value="<?php echo (int)$user['id'];?>">
                <button type="submit" name="update" class="btn btn-info">Cambiar</button>
        </div>
    </form>
</div>
<?php include_once('layouts/footer.php'); ?>
