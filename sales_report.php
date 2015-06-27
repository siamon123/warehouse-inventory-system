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
      <form method="post" action="sale_report_process.php">
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
<?php include_once('layouts/footer.php'); ?>
