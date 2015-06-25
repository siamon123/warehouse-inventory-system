<?php
  require_once('includes/load.php');
  if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
?>
<?php
  if(isset($_POST['add_user'])){

   $req_fields = array('full-name','username','password' );
   validate_fields($req_fields);
   $name       = remove_junk($_POST['full-name']);
   $username   = remove_junk($_POST['username']);
   $password   = remove_junk($_POST['password']);

   if(empty($errors)){
       $name = real_escape($name);
       $username = real_escape($username);
       $password = real_escape($password);
       $password = sha1($password);
        $query = "INSERT INTO users (";
        $query .="  name,username,password";
        $query .=") VALUES (";
        $query .=" '{$name}', '{$username}', '{$password}'";
        $query .=")";
        $result = mysqli_query($con, $query);
        if($result){
          //sucess
          $session->msg('s',"User account has been creted! ");
          redirect('index.php', false);

        } else {
          //failed
          $session->msg('d',' Sorry failed to create account!');
          redirect('add_user.php', false);
        }
   } else {
     $session->msg("d", $errors);
      redirect('home.php',false);
   }
 }
?>
<?php include_once('layouts/header.php'); ?>
  <?php echo display_msg($msg); ?>
  <div class="row">
   <div class="col-md-6">
     <form method="post" action="add_user.php">
       <div class="form-group">
           <label for="name">Name</label>
           <input type="text" class="form-control" name="full-name" placeholder="Full Name">
       </div>
       <div class="form-group">
           <label for="username">Username</label>
           <input type="text" class="form-control" name="username" placeholder="Username">
       </div>
       <div class="form-group">
           <label for="password">Password</label>
           <input type="password" class="form-control" name ="password"  placeholder="Password">
       </div>

       <button type="submit" name="add_user" class="btn btn-primary">Add User</button>
   </form>
   </div>
  </div>

<?php include_once('layouts/footer.php'); ?>
