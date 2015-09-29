<?php
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(2);
?>
<?php
  $find_media = find_by_id('media',(int)$_GET['id']);
  $photo = new Media();
  if($photo->media_destroy($find_media['id'],$find_media['file_name'])){
      $session->msg("s","Photo has been deleted.");
      redirect('media.php');
  } else {
      $session->msg("d","Photo deletion failed Or Missing Prm.");
      redirect('media.php');
  }
?>
