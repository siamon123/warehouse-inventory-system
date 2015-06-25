<?php
  require_once('includes/load.php');
  if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
?>
<?php
$name = "iphone";
$sales = find_all_sale();
?>
<?php include_once('layouts/header.php'); ?>
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
          <div class="pull-right">
            <a href="add_sale.php" class="btn btn-primary">Add sale</a>
          </div>
        </div>
        <div class="panel-body">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th> Id </th>
                <th> Product name </th>
                <th> Quantity sold</th>
                <th> Price </th>
                <th> Date </th>
                <th> Actions </th>
             </tr>
            </thead>
           <tbody>
             <?php foreach ($sales as $sale):?>
             <tr>
               <td><?php echo (int)$sale['id']; ?></td>
               <td><?php echo remove_junk($sale['name']); ?></td>
               <td><?php echo (int)$sale['qty']; ?></td>
               <td><?php echo remove_junk($sale['price']); ?></td>
               <td><?php echo remove_junk($sale['date']); ?></td>
               <td>
                   <a href="edit_sale.php?id=<?php echo (int)$sale['id'];?>" class="btn btn-warning btn-xs"  title="Edit">
                     <span class="glyphicon glyphicon-edit"></span>
                   </a>
                   <a href="delete_categorie.php?id=<?php echo (int)$sale['id'];?>" class="btn btn-danger btn-xs"  title="Edit">
                     <span class="glyphicon glyphicon-trash"></span>
                   </a>
               </td>
             </tr>
             <?php endforeach;?>
           </tbody>
         </table>
        </div>
        <div class="panel-footer"></div>
      </div>
    </div>
  </div>
<?php include_once('layouts/footer.php'); ?>
