<?php $user = current_user(); ?>
<!DOCTYPE html>
  <html lang="en">
    <head>
    <meta charset="UTF-8">
    <title>Simple inventory System</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />
    <link rel="stylesheet" href="libs/css/main.css" />
  </head>
  <body>
  <?php  if ($session->isUserLoggedIn(true)): ?>
    <header id="header">
      <a href="#" id="menu-action">
       <i class="fa fa-bars"></i>
      </a>
      <div class="logo">
         Simple Inventory
      </div>
      <div id="logout" class="pull-right clearfix">
        <a href="logout.php">
         <span class="glyphicon glyphicon-off"></span> Logout
        </a>
      </div>
    </header>
    <div class="sidebar">
      <h4><?php echo remove_junk(ucfirst($user['name'])); ?> </h4>
      <ul>
        <li>
          <a href="home.php">
            <i class="glyphicon glyphicon-home"></i>
            <span>Home</span>
          </a>
        </li>
        <li>
          <a href="#" class="submenu-toggle">
            <i class="glyphicon glyphicon-user"></i>
            <span>User Management</span>
          </a>
          <ul class="nav submenu">
            <li><a href="users.php">Manage user</a> </li>
             <li><a href="edit_account.php">My account</a> </li>
             <li><a href="change_password.php">Change Password</a> </li>
             <li><a href="add_user.php">New User</a> </li>
         </ul>
        </li>
        <li>
          <a href="categorie.php" >
            <i class="glyphicon glyphicon-indent-left"></i>
            <span>Categorie</span>
          </a>
        </li>
        <li>
          <a href="#" class="submenu-toggle">
            <i class="glyphicon glyphicon-th-large"></i>
            <span>Product</span>
          </a>
          <ul class="nav submenu">
             <li><a href="product.php">Manage product</a> </li>
             <li><a href="add_product.php">Add product</a> </li>
         </ul>
        </li>
        <li>
          <a href="#" class="submenu-toggle">
            <i class="glyphicon glyphicon-th-list"></i>
             <span>Sale</span>
            </a>
            <ul class="nav submenu">
               <li><a href="sales.php">Manage Sale</a> </li>
               <li><a href="add_sale.php">Add Sale</a> </li>
           </ul>
          </li>
        <li>
          <a href="sales_report.php">
            <i class="glyphicon glyphicon-signal"></i>
            <span>Report</span>
          </a>
        </li>
      </ul>
   </div>
<?php endif; ?>

<div class="page">
  <div class="container-fluid">
