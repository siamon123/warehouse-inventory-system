<?php
  require_once('includes/load.php');
  if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
  $products = find_all_product();
?>
<?php include_once('layouts/header.php'); ?>
  <div class="row">
     <div class="col-md-12">
       <?php echo display_msg($msg); ?>
     </div>
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
         <div class="pull-right">
           <a href="add_product.php" class="btn btn-primary">Add New</a>
         </div>
        </div>
        <div class="panel-body">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th> id </th>
                <th> Product Title </th>
                <th> Instock </th>
                <th> Buying Price </th>
                <th> Saleing Price </th>
                <th> Categorie </th>
                <th> Actions </th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($products as $product):?>
              <tr>
                <td> <?php echo (int)$product['id']; ?></td>
                <td> <?php echo remove_junk($product['name']); ?></td>
                <td> <?php echo remove_junk($product['quantity']); ?></td>
                <td> <?php echo remove_junk($product['buy_price']); ?></td>
                <td> <?php echo remove_junk($product['sale_price']); ?></td>
                <td> <?php echo remove_junk($product['categorie_name']); ?></td>
                <td>
                  <a href="edit_product.php?id=<?php echo (int)$product['id'];?>" class="btn btn-warning btn-xs"  title="Edit">
                    <span class="glyphicon glyphicon-edit"></span>
                  </a>
                  <a href="delete_product.php?id=<?php echo (int)$product['id'];?>" class="btn btn-danger btn-xs"  title="Edit">
                    <span class="glyphicon glyphicon-trash"></span>
                  </a>
                </td>
              </tr>
             <?php endforeach; ?>
            </tbody>
          </tabel>
        </div>
      </div>
    </div>
  </div>
  <?php include_once('layouts/footer.php'); ?>
