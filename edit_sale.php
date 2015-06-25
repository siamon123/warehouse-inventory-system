<?php
  require_once('includes/load.php');
  if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
?>
<?php
$sale = find_by_sale_id((int)$_GET['id']);
if(!$sale){
  $session->msg("d","Missing product id.");
  redirect('sales.php');
}
?>
<?php $product = find_by_product_id($sale['product_id']); ?>
<?php

  if(isset($_POST['update_sale'])){
    $req_fields = array('title','quantity','price','total', 'date' );
    validate_fields($req_fields);
        if(empty($errors)){
          $p_id      = real_escape((int)$product['id']);
          $s_qty     = real_escape((int)$_POST['quantity']);
          $s_total   = real_escape($_POST['total']);
          $date      = real_escape($_POST['date']);
          $s_date    = date("Y-m-d", strtotime($date));

          $sql  = "UPDATE sales SET";
          $sql .= " product_id= '{$p_id}',qty={$s_qty},price='{$s_total}',date='{$s_date}'";
          $sql .= " WHERE id ='{$sale['id']}'";
          $result = mysqli_query($con,$sql);
          if( $result ){
                    update_product_qty($s_qty,$p_id);
                    $session->msg('s',"Sale updated.");
                    redirect('edit_sale.php?id='.$sale['id'], false);
                  } else {
                    $session->msg('d',' Sorry failed to updated!');
                    redirect('sales.php', false);
                  }
        } else {
           $session->msg("d", $errors);
           redirect('edit_sale.php?id='.(int)$sale['id'],false);
        }
  }

?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
  </div>
</div>
<div class="row">

  <div class="col-md-12">
    <form method="post" action="edit_sale.php?id=<?php echo (int)$sale['id']; ?>">
     <table class="table table-bordered">
       <thead>
        <th> Product title </th>
        <th> Qty </th>
        <th> Price </th>
        <th> Total </th>
        <th> Date</th>
        <th> Action</th>
       </thead>
         <tbody  id="product_info">

            <tr>
              <td id="s_name">
                <input type="text" class="form-control" id="sug_input" name="title" value="<?php echo remove_junk($product['name']); ?>">
                <div id="result" class="list-group"></div>
              </td>
              <td id="s_qty">
                <input type="text" class="form-control" name="quantity" value="<?php echo (int)$sale['qty']; ?>">
              </td>
              <td id="s_price">
                <input type="text" class="form-control" name="price" value="<?php echo remove_junk($product['sale_price']); ?>" >
              </td>
              <td>
                <input type="text" class="form-control" name="total" value="<?php echo remove_junk($sale['price']); ?>">
              </td>
              <td id="s_date">
                <input type="date" class="form-control datePicker"  name="date" data-date-format="" value="<?php echo remove_junk($sale['date']); ?>">
              </td>
              <td>
                <button type="submit" name="update_sale" class="btn btn-primary">Update sale</button>
              </td>
            </tr>
         </tbody>
     </table>
   </form>
  </div>

</div>

<?php include_once('layouts/footer.php'); ?>
