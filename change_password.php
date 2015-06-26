<?php
  require_once('includes/load.php');
  if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
?>
<?php $user = current_user(); ?>
<?php
  if(isset($_POST['update'])){
    $req_fields = array('new-password','old-password' );
    validate_fields($req_fields);
    if(sha1($_POST['old-password'])!== current_user()['password']){
      $errors = "Your old password not match";
      $session->msg('d', $errors);
      redirect('change_password.php',false);
    }
    if(empty($errors)){
             $id = (int)$_SESSION['user_id'];
            $new = remove_junk(real_escape(sha1($_POST['new-password'])));
            $sql = "UPDATE users SET password ='{$new}' WHERE id='{$id}'";
         $result = mysqli_query($con, $sql);
                if($result && mysqli_affected_rows($con) == 1){
                  $session->msg('s',"Acount updated");
                  redirect('change_password.php', false);
                } else {
                  $session->msg('d',' Sorry failed to updated!');
                  redirect('change_password.php', false);
                }
    } else {
      $session->msg("d", $errors);
      redirect('change_password.php',false);
    }
  }
?>
<?php include_once('layouts/header.php'); ?>
<div class="login-page">
    <div class="text-center">
       <h3>Change your password</h3>
     </div>
     <?php echo display_msg($msg); ?>
      <form method="post" action="change_password.php?id=<?php echo (int)$user['id'];?>" class="clearfix">
        <div class="form-group">
              <label for="newPassword" class="control-label">New password</label>
              <input type="password" class="form-control" name="new-password" placeholder="New password">
        </div>
        <div class="form-group">
              <label for="oldPassword" class="control-label">Old password</label>
              <input type="password" class="form-control" name="old-password" placeholder="Old password">
        </div>
        <div class="form-group clearfix">
                <button type="submit" name="update" class="btn btn-info">Change</button>
        </div>
    </form>
</div>
<?php include_once('layouts/footer.php'); ?>
