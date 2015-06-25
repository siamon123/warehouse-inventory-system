<?php
  require_once('includes/load.php');
  if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
?>
<?php
 $c_categorie   = count_categories();
 $c_product     = count_products();
 $c_sale        = count_sales();
 $c_user        = count_users();
 $products_sold = find_higest_sale_product();
 $recent_products = find_recent_product_added();
 $recent_sales  = find_recent_sale_added()
?>
<?php include_once('layouts/header.php'); ?>

<div class="row">
   <div class="col-md-6">
     <?php echo display_msg($msg); ?>
   </div>
</div>
  <div class="row">
    <div class="col-md-3">
       <div class="alert info-box clearfix">
         <div class="alert btn-danger pull-left">
          <i class="glyphicon glyphicon-user"></i>
        </div>
         <strong>Total User</strong>
         <span> <?php  echo $c_user['total_user']; ?> </span>
       </div>
    </div>
    <div class="col-md-3">
       <div class="alert info-box clearfix">
         <div class="alert btn-success pull-left">
          <i class="glyphicon glyphicon-indent-left"></i>
        </div>
         <strong>Total calegorie</strong>
         <span> <?php  echo $c_categorie['total_cat']; ?> </span>
       </div>
    </div>
    <div class="col-md-3">
       <div class="alert info-box clearfix">
         <div class="alert btn-info pull-left">
          <i class="glyphicon glyphicon-th-large"></i>
        </div>
         <strong>Total Product</strong>
         <span> <?php  echo $c_product['total_pro']; ?> </span>
       </div>
    </div>
    <div class="col-md-3">
       <div class="alert info-box clearfix">
         <div class="alert btn-warning pull-left">
          <i class="glyphicon glyphicon-th-list"></i>
        </div>
         <strong>Total Sale</strong>
         <span> <?php  echo $c_sale['total_sale']; ?> </span>
       </div>
    </div>
</div>
<div class="padding-top">
  <div class="row">
   <div class="col-md-6">
    <div class="panel panel-success">
     <div class="panel-heading">
       <h4>Highest saleing Products</h4>
     </div>
     <div class="panel-body">

       <table class="table table-bordered table-striped">
        <thead>
         <tr>
           <th>Title</th>
           <th>Total Sold</th>
           <th>Total Quantity</th>
         <tr>
        </thead>
        <tbody>
          <?php foreach ($products_sold as  $product_sold): ?>
            <tr>
              <td><?php echo remove_junk(ucfirst($product_sold['name'])); ?></td>
              <td><?php echo (int)$product_sold['Totalsold']; ?></td>
              <td><?php echo (int)$product_sold['Totalquantity']; ?></td>
            </tr>
          <?php endforeach; ?>
        <tbody>
       </table>
     </div>
    </div>
   </div>
   </div>
 </div>
 <div class="row">
   <div class="col-md-6">
    <div class="panel panel-primary">
     <div class="panel-heading">
       <h4>Recently Added Products</h4>
     </div>
     <div class="panel-body">

       <ul class="list-group">
          <?php foreach ($recent_products as  $recent_product): ?>
              <li class="list-group-item">
                <a href="edit_product.php?id=<?php echo (int)$recent_product['id']; ?>">
                  <h4 class="list-group-item-heading"><?php echo remove_junk(ucfirst($recent_product['name'])); ?>
                    <span class="label label-warning pull-right">
                      $<?php echo (int)$recent_product['sale_price']; ?>
                    </span>
                  </h4>
                </a>
                <span class="list-group-item-text">
                <?php echo remove_junk(ucfirst($recent_product['categorie_name'])); ?>
              </span>
          <?php endforeach; ?>
      <ul>
     </div>
    </div>
   </div>
   <div class="col-md-6">
    <div class="panel panel-warning">
     <div class="panel-heading">
       <h4>Latest Sales</h4>
     </div>
     <div class="panel-body">

       <table class="table">
         <thead>
           <tr>
             <th>Sale ID</th>
             <th>Product Name</th>
             <th>Date</th>
             <th>Total Sale</th>
           </tr>
         </thead>
         <tbody>
        <?php foreach ($recent_sales as  $recent_sale): ?>

          <tr>
           <td>
             <a href="edit_sale.php?id=<?php echo (int)$recent_sale['id']; ?>">
               <?php echo (int)$recent_sale['id']; ?>
            </a>
           </td>
           <td><?php echo remove_junk(ucfirst($recent_sale['name'])); ?></td>
           <td><?php echo remove_junk(ucfirst($recent_sale['date'])); ?></td>
           <td>$<?php echo remove_junk(ucfirst($recent_sale['price'])); ?></td>
          </tr>
        <?php endforeach; ?>
         </tbody>
       </table>

     </div>
    </div>
   </div>
 </div>

<?php include_once('layouts/footer.php'); ?>
