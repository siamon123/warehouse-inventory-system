<?php include_once('layouts/header.php'); ?>
 <div class="row">
   <div class="col-md-12"> <?php echo display_msg($msg); ?> </div>
    <div class="col-md-6">
     <div class="panel panel-default">
       <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Editar cuenta</span>
       </strong>
       </div>
       <div class="panel-body">
          <form method="post" action="edit_user.php?id=<?php echo (int)$e_user['id'];?>" class="clearfix">
            <?php echo csrf_field(); ?>
            <div class="form-group">
                  <label for="name" class="control-label">Nombre</label>
                  <input type="name" class="form-control" name="name" value="<?php echo remove_junk(ucwords($e_user['name'])); ?>">
            </div>
            <div class="form-group">
                  <label for="username" class="control-label">Usuario</label>
                  <input type="text" class="form-control" name="username" value="<?php echo remove_junk($e_user['username']); ?>">
            </div>
            <div class="form-group">
              <label for="level">Rol de usuario</label>
                <select class="form-control" name="level">
                  <?php foreach ($groups as $group):?>
                   <option <?php if($group['group_level'] === $e_user['user_level']) echo 'selected="selected"';?> value="<?php echo $group['group_level'];?>"><?php echo ucwords($group['group_name']);?></option>
                <?php endforeach;?>
                </select>
            </div>
            <div class="form-group clearfix">
                    <button type="submit" name="update" class="btn btn-info">Actualizar</button>
            </div>
        </form>
       </div>
     </div>
    </div>
    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Cambiar contraseña</span>
          </strong>
        </div>
        <div class="panel-body">
          <form action="edit_user.php?id=<?php echo (int)$e_user['id'];?>" method="post" class="clearfix">
            <?php echo csrf_field(); ?>
            <div class="form-group">
                  <label for="password" class="control-label">Contraseña</label>
                  <input type="password" class="form-control" name="password" placeholder="Nueva contraseña">
            </div>
            <div class="form-group clearfix">
                    <button type="submit" name="update-pass" class="btn btn-danger pull-right">Cambiar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
 </div>
<?php include_once('layouts/footer.php'); ?>
