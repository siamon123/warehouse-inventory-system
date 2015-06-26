<?php
  require_once('includes/load.php');
  if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
?>

<?php
  if(isset($_POST['update'])){
    $req_fields = array('name','username' );
    validate_fields($req_fields);
    if(empty($errors)){
             $id = (int)$_SESSION['user_id'];
           $name = remove_junk(real_escape($_POST['name']));
       $username = remove_junk(real_escape($_POST['username']));
            $sql = "UPDATE users SET name ='{$name}', username ='{$username}' WHERE id='{$id}'";
    $result = mysqli_query($con, $sql);
          if($result && mysqli_affected_rows($con) == 1){
            $session->msg('s',"Acount updated ");
            redirect('edit_account.php', false);
          } else {
            $session->msg('d',' Sorry failed to updated!');
            redirect('edit_account.php', false);
          }
    } else {
      $session->msg("d", $errors);
      redirect('edit_account.php',false);
    }
  }
?>
<?php include_once('layouts/header.php'); ?>
<div class="login-page">
    <div class="text-center">
       <h3>Update your account</h3>
     </div>
     <?php echo display_msg($msg); ?>
      <form method="post" action="edit_account.php?id=<?php echo (int)$user['id'];?>" class="clearfix">
        <div class="form-group">
              <label for="name" class="control-label">Name</label>
              <input type="name" class="form-control" name="name" value="<?php echo remove_junk(ucwords($user['name'])); ?>">
        </div>
        <div class="form-group">
              <label for="username" class="control-label">Username</label>
              <input type="text" class="form-control" name="username" value="<?php echo remove_junk(ucwords($user['username'])); ?>">
        </div>
        <div class="form-group clearfix">
                <button type="submit" name="update" class="btn btn-info">Update</button>
        </div>
    </form>
</div>


<?php include_once('layouts/footer.php'); ?>
