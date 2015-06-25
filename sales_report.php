<?php
$results = '';
  require_once('includes/load.php');
  if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
?>
<?php
  if(isset($_POST['submit'])){
    $req_dates = array('start-date','end-date');
    validate_fields($req_dates);
    if(empty($errors)){
      $start_date   = remove_junk(real_escape($_POST['start-date']));
      $end_date     = remove_junk(real_escape($_POST['end-date']));
      $results      = find_sale_by_dates($start_date,$end_date);
    } else {
      $session->msg("d", $errors);
      redirect('sales_report.php', false);
    }
  }
?>
<?php include_once('layouts/header.php'); ?>
 <div class="row">
   <div class="col-md-6">
     <?php echo display_msg($msg); ?>
   </div>
  <div class="col-md-12">
   <div class="panel panel-default">
     <div class="panel-heading">
     </div>
     <div class="panel-body">
      <form method="post" action="sales_report.php">
        <div class="row">
          <div class="col-xs-5">
            <label for="start date">Start Date</label>
            <div class="input-group">
                <input type="text" class="form-control datePicker" name="start-date" data-date-format="yyyy-mm-dd" required>
                <span class="input-group-addon">
                  <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
          </div>
          <div class="col-xs-5">
            <label for="end date">End Date</label>
            <div class="input-group">
                <input type="text" class="form-control datePicker" name="end-date" data-date-format="yyyy-mm-dd" required>
                <span class="input-group-addon">
                  <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
          </div>
          <div class="col-md-2">
            <label></label>
            <div class="input-group">
              <button type="submit" name="submit" class="btn btn-primary">Generate Report</button>
            </div>
          </div>
        </div>
      </form>
     </div>
   </div>
  </div>
 </div>
 <div class="btn-group pull-right">
   <a onclick="print_invoice('printableArea')" class="btn btn-success">Print</a>
 </div>
<?php if($results): ?>
 <div id="printReport">
   <div class="row">
     <div class="col-md-12">
       <div class="main">
        <div class="sale_report_header">
          <h5 class="text-right"> Sales Report From :
            <strong><?php if(isset($start_date)){echo $start_date;}?></strong>
              To
              <strong><?php if(isset($end_date)){echo $end_date;}?></strong>
         </h5>
        </div>
         <table border="0" cellspacing="0" cellpadding="0" class="table">
          <thead>
            <tr style="background-color: #ECECEC">
                <th>Date</th>
                <th class="desc">Product Title</th>
                <th class="text-right">Buying Price</th>
                <th class="text-right">Selling Price</th>
                <th class="text-right">Total Qty</th>
                <th class="text-right ">TOTAL</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($results as $result): ?>
             <tr>
                <td class=""><?php echo remove_junk($result['date']);?></td>
                <td class="desc">
                  <h6><?php echo remove_junk(ucfirst($result['name']));?></h6>
                </td>
                <td class="text-right"><?php echo remove_junk($result['buy_price']);?></td>
                <td class="text-right"><?php echo remove_junk($result['sale_price']);?></td>
                <td class="text-right"><?php echo remove_junk($result['total_sales']);?></td>
                <td class="text-right"><?php echo remove_junk($result['total_saleing_price']);?></td>
            </tr>
          <?php endforeach; ?>
          </tbody>
          <tfoot>
           <tr class="text-right">
             <td colspan="4"></td>
             <td colspan="1">Grand Total</td>
             <td> $
             <?php echo number_format(add($results)[0], 2);?>
            </td>
           </tr>
           <tr class="text-right">
             <td colspan="4"></td>
             <td colspan="1">Profit</td>
             <td> $<?php echo number_format(add($results)[1], 2);?></td>
           </tr>
          </tfoot>
         </table>
       </div>
     </div>
   </div>
 <div>
<?php endif; ?>
<?php include_once('layouts/footer.php'); ?>
