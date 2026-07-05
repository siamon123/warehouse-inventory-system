<?php $user = current_user(); ?>
<!DOCTYPE html>
  <html lang="es">
    <head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="<?php echo $session->generate_csrf_token(); ?>">
    <title><?php if (!empty($page_title))
           echo remove_junk($page_title);
            elseif(!empty($user))
           echo ucfirst($user['name']);
            else echo "Sistema de inventario";?>
    </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />
    <link rel="stylesheet" href="libs/css/main.css" />
  </head>
  <body<?php if (!$session->isUserLoggedIn(true)) echo ' class="login-body"'; ?>>
  <?php  if ($session->isUserLoggedIn(true)): ?>
    <header id="header">
      <div class="logo pull-left"> OSWA - Inventory </div>
      <div class="header-content">
      <div class="header-date pull-left">
        <strong><?php echo date("F j, Y, g:i a");?></strong>
      </div>
      <div class="pull-right clearfix">
        <ul class="info-menu list-inline list-unstyled">
          <li class="profile">
            <a href="#" data-toggle="dropdown" class="toggle" aria-expanded="false">
              <img src="uploads/users/<?php echo $user['image'];?>" alt="user-image" class="img-circle img-inline">
              <span><?php echo remove_junk(ucfirst($user['name'])); ?> <i class="caret"></i></span>
            </a>
            <ul class="dropdown-menu">
              <li>
                  <a href="profile.php?id=<?php echo (int)$user['id'];?>">
                      <i class="glyphicon glyphicon-user"></i>
                      Perfil
                  </a>
              </li>
             <li>
                 <a href="edit_account.php" title="edit account">
                     <i class="glyphicon glyphicon-cog"></i>
                     Configuración
                 </a>
             </li>
             <li class="last">
                 <a href="logout.php">
                     <i class="glyphicon glyphicon-off"></i>
                     Salir
                 </a>
             </li>
           </ul>
          </li>
        </ul>
      </div>
     </div>
    </header>
    <div class="sidebar">
      <?php if($user['user_level'] == '1'): ?>
        <!-- Menu de Admin -->
      <?php include_once('admin_menu.php');?>

      <?php elseif($user['user_level'] == '2'): ?>
        <!-- Menu de Especial -->
      <?php include_once('special_menu.php');?>

      <?php elseif($user['user_level'] == '3'): ?>
        <!-- Menu de Usuario -->
      <?php include_once('user_menu.php');?>

      <?php endif;?>

   </div>
<?php endif;?>

<div class="page"<?php if (!$session->isUserLoggedIn(true)) echo ' style="padding-left: 0; top: 0;"'; ?>>
  <div class="container-fluid">
