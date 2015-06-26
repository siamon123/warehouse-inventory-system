<?php
  require_once('includes/load.php');
  if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
  $all_users = all_users();
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
   <div class="col-md-12">
     <?php echo display_msg($msg); ?>
   </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-info">
     <div class="panel-body">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Name </th>
            <th>Username</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach($all_users as $a_user): ?>
          <tr>
           <td><?php echo remove_junk(ucwords($a_user['name']))?></td>
           <td><?php echo remove_junk(ucwords($a_user['username']))?></td>
           <td>
             <a href="edit_user.php?id=<?php echo (int)$a_user['id'];?>" class="btn btn-warning btn-xs"  title="Edit">
               <span class="glyphicon glyphicon-edit"></span>
             </a>
             <a href="delete_user.php?id=<?php echo (int)$a_user['id'];?>" class="btn btn-danger btn-xs"  title="Edit">
               <span class="glyphicon glyphicon-trash"></span>
             </a>
           </td>
          </tr>
        <?php endforeach;?>
       </tbody>
     </table>
     </div>
    </div>
  </div>
</div>
  <?php include_once('layouts/footer.php'); ?>
