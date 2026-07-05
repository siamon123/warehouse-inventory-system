<?php
  $page_title = 'Página de Inicio';
  require_once('includes/load.php');
  if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
 <div class="col-md-12">
    <div class="panel">
      <div class="jumbotron text-center">
         <h1>¡Esta es su nueva página de inicio!</h1>
         <p>Navegue por el sistema para descubrir a qué páginas tiene acceso.</p>
      </div>
    </div>
 </div>
</div>
<?php include_once('layouts/footer.php'); ?>
