<?php
  require_once('includes/load.php');
  if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
?>
<?php
$product = find_by_product_id((int)$_GET['id']);
$all_categories = all_catgories();
if(!$product){
  $session->msg("d","Missing product id.");
  redirect('product.php');
}
?>
<?php
 if(isset($_POST['product'])){

   $req_fields = array('product-title','product-categorie','product-quantity','buying-price', 'saleing-price' );

   validate_fields($req_fields);

   if(empty($errors)){
       $p_name  = remove_junk(real_escape($_POST['product-title']));
       $p_cat   = (int)$_POST['product-categorie'];
       $p_qty   = remove_junk(real_escape($_POST['product-quantity']));
       $p_buy   = remove_junk(real_escape($_POST['buying-price']));
       $p_sale  = remove_junk(real_escape($_POST['saleing-price']));
       $query   = "UPDATE products SET";
       $query  .=" name ='{$p_name}', quantity ='{$p_qty}',";
       $query  .=" buy_price ='{$p_buy}', sale_price ='{$p_sale}', categorie_id ='{$p_cat}'";
       $query  .=" WHERE id ='{$product['id']}'";
       $result = mysqli_query($con, $query);
               if($result && mysqli_affected_rows($con) == 1){
                 $session->msg('s',"Product updated ");
                 redirect('product.php', false);
               } else {
                 $session->msg('d',' Sorry failed to updated!');
                 redirect('edit_product.php?id='.$product['id'], false);
               }

   } else{
       $session->msg("d", $errors);
       redirect('edit_product.php?id='.$product['id'], false);
   }

 }

?>
<?php include_once('layouts/header.php'); ?>

  <div class="box">
    <div class="row">
      <div class="col-md-6">
        <?php echo display_msg($msg); ?>
      </div>
      <form method="post" action="edit_product.php?id=<?php echo (int)$product['id'] ?>">
        <div class="col-xs-8">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="glyphicon glyphicon-th-large"></i>
              </span>
              <input type="text" class="form-control" name="product-title" value="<?php echo remove_junk($product['name']);?>">
              <span class="input-group-addon">Title</span>
           </div>
          </div>
        </div>
        <div class="col-xs-4">
          <div class="form-group">
              <select class="form-control" name="product-categorie">
                <option>Select categorie</option>
              <?php  foreach ($all_categories as $cat): ?>
                <option value="<?php echo (int)$cat['id'] ?>" <?php if($product['categorie_id'] == $cat['id']): echo "selected"; endif; ?> >
                  <?php echo remove_junk($cat['name']); ?></option>
              <?php endforeach; ?>
              </select>
          </div>
        </div>
        <div class="col-xs-4">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="glyphicon glyphicon-gift"></i>
              </span>
              <input type="text" class="form-control" name="product-quantity" value="<?php echo remove_junk($product['quantity']); ?>">
              <span class="input-group-addon">Qty</span>
           </div>
          </div>
        </div>
        <div class="col-xs-4">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="glyphicon glyphicon-usd"></i>
              </span>
              <input type="text" class="form-control" name="buying-price" value="<?php echo remove_junk($product['buy_price']); ?>">
              <span class="input-group-addon">Buying Price</span>
           </div>
          </div>
        </div>
        <div class="col-xs-4">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="glyphicon glyphicon-usd"></i>
              </span>
              <input type="text" class="form-control" name="saleing-price" value="<?php echo remove_junk($product['sale_price']); ?>">
              <span class="input-group-addon">Saleing Price</span>
           </div>
          </div>
        </div>
        <div class="col-md-3">
          <button type="submit" name="product" class="btn btn-primary">Eidt Product</button>
        </div>
      </form>
    </div>
  </div>

<?php include_once('layouts/footer.php'); ?>
