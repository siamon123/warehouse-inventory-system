<?php include_once('layouts/header.php'); ?>
<div class="login-page">
    <div class="text-center">
       <h3>Edit Group</h3>
     </div>
     <?php echo display_msg($msg); ?>
      <form method="post" action="edit_group.php?id=<?php echo (int)$e_group['id'];?>" class="clearfix">
        <?php echo csrf_field(); ?>
        <div class="form-group">
              <label for="name" class="control-label">Nombre del grupo</label>
              <input type="name" class="form-control" name="group-name" value="<?php echo remove_junk(ucwords($e_group['group_name'])); ?>">
        </div>
        <div class="form-group">
              <label for="level" class="control-label">Nivel del grupo</label>
              <input type="number" class="form-control" name="group-level" value="<?php echo (int)$e_group['group_level']; ?>">
        </div>
        <div class="form-group">
          <label for="status">Estado</label>
            <select class="form-control" name="status">
              <option <?php if($e_group['group_status'] == '1') echo 'selected="selected"';?> value="1"> Activo </option>
              <option <?php if($e_group['group_status'] == '0') echo 'selected="selected"';?> value="0">Inactivo</option>
            </select>
        </div>
        <div class="form-group clearfix">
                <button type="submit" name="update" class="btn btn-info">Actualizar</button>
        </div>
    </form>
</div>
<?php include_once('layouts/footer.php'); ?>
