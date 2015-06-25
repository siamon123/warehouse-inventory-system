<?php
  require_once('includes/load.php');
  if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
  $all_categories = all_catgories();
?>
<?php
 if(isset($_POST['add_product'])){
   $req_fields = array('product-title','product-categorie','product-quantity','buying-price', 'saleing-price' );
   validate_fields($req_fields);
   if(empty($errors)){
     $p_name  = remove_junk(real_escape($_POST['product-title']));
     $p_cat   = remove_junk(real_escape($_POST['product-categorie']));
     $p_qty   = remove_junk(real_escape($_POST['product-quantity']));
     $p_buy   = remove_junk(real_escape($_POST['buying-price']));
     $p_sale  = remove_junk(real_escape($_POST['saleing-price']));
     $query = "INSERT INTO products (";
     $query .="  name,quantity,buy_price,sale_price,categorie_id";
     $query .=") VALUES (";
     $query .=" '{$p_name}', '{$p_qty}', '{$p_buy}', '{$p_sale}', '{$p_cat}'";
     $query .=")";
     $query .="  ON DUPLICATE KEY UPDATE name='{$p_name}'";
     $result = mysqli_query($con, $query);
     if($result){
       $session->msg('s',"Product added ");
       redirect('add_product.php', false);
     } else {
       $session->msg('d',' Sorry failed to added!');
       redirect('product.php', false);
     }

   } else{
     $session->msg("d", $errors);
      redirect('add_product.php',false);
   }

 }

?>
<?php include_once('layouts/header.php'); ?>
<div class="box">
  <div class="row">
    <div class="col-md-6">
      <?php echo display_msg($msg); ?>
    </div>
    <form method="post" action="add_product.php" class="clearfix">
      <div class="col-xs-8">
        <div class="form-group">
          <div class="input-group">
            <span class="input-group-addon">
             <i class="glyphicon glyphicon-th-large"></i>
            </span>
            <input type="text" class="form-control" name="product-title" placeholder="Product Title">
         </div>
        </div>
      </div>
      <div class="col-xs-4">
        <div class="form-group">
            <select class="form-control" name="product-categorie">
              <option value="">Select Product Category</option>
            <?php  foreach ($all_categories as $cat): ?>
              <option value="<?php echo (int)$cat['id'] ?>">
                <?php echo $cat['name'] ?></option>
            <?php endforeach; ?>
            </select>
        </div>
      </div>
      <div class="col-xs-4">
        <div class="form-group">
          <div class="input-group">
            <span class="input-group-addon">
             <i class="glyphicon glyphicon-usd"></i>
            </span>
            <input type="text" class="form-control" name="product-quantity" placeholder="Product Quantity">
         </div>
        </div>
      </div>
      <div class="col-xs-4">
        <div class="form-group">
          <div class="input-group">
            <span class="input-group-addon">
              <i class="glyphicon glyphicon-usd"></i>
            </span>
            <input type="text" class="form-control" name="buying-price" placeholder="Buying Price">
            <span class="input-group-addon">.00</span>
         </div>
        </div>
      </div>
      <div class="col-xs-4">
        <div class="form-group">
          <div class="input-group">
            <span class="input-group-addon">
              <i class="glyphicon glyphicon-usd"></i>
            </span>
            <input type="text" class="form-control" name="saleing-price" placeholder="Selling Price">
            <span class="input-group-addon">.00</span>
         </div>
        </div>
      </div>
      <div class="col-md-12">
        <button type="submit" name="add_product" class="btn btn-info pull-right">Add product</button>
      </div>
    </form>
  </div>
</div>
<?php include_once('layouts/footer.php'); ?>
