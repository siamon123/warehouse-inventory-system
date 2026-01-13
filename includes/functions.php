<?php
  $errors = array();

  /*--------------------------------------------------------------*/
  /* Función para eliminar caracteres especiales para SQL
  /*--------------------------------------------------------------*/
function real_escape($str){
  global $db;
  return $db->escape($str);
}
/*--------------------------------------------------------------*/
/* Función para eliminar caracteres HTML
/*--------------------------------------------------------------*/
function remove_junk($str){
  $str = nl2br($str);
  $str = htmlspecialchars(strip_tags($str, ENT_QUOTES));
  return $str;
}
/*--------------------------------------------------------------*/
/* Función para poner en mayúscula la primera letra
/*--------------------------------------------------------------*/
function first_character($str){
  $val = str_replace('-'," ",$str);
  $val = ucfirst($val);
  return $val;
}
/*--------------------------------------------------------------*/
/* Función para validar campos no vacíos
/*--------------------------------------------------------------*/
function validate_fields($var){
  global $errors;
  foreach ($var as $field) {
    $val = remove_junk($_POST[$field]);
    if(isset($val) && $val==''){
      $errors = $field ." no puede estar vacío.";
      return $errors;
    }
  }
}
/*--------------------------------------------------------------*/
/* Función para mostrar mensajes de sesión
/*--------------------------------------------------------------*/
function display_msg($msg =''){
   $output = array();
   if(!empty($msg)) {
      foreach ($msg as $key => $value) {
         $output  = "<div class=\"alert alert-{$key}\">";
         $output .= "<a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>";
         $output .= remove_junk(first_character($value));
         $output .= "</div>";
      }
      return $output;
   } else {
     return "" ;
   }
}
/*--------------------------------------------------------------*/
/* Función para redirección
/*--------------------------------------------------------------*/
function redirect($url, $permanent = false)
{
    if (headers_sent() === false)
    {
      header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
    }

    exit();
}
/*--------------------------------------------------------------*/
/* Función para calcular precio total, precio de compra y beneficio
/*--------------------------------------------------------------*/
function total_price($totals){
   $sum = 0;
   $sub = 0;
   foreach($totals as $total ){
     $sum += $total['total_saleing_price'];
     $sub += $total['total_buying_price'];
     $profit = $sum - $sub;
   }
   return array($sum,$profit);
}
/*--------------------------------------------------------------*/
/* Función para fecha legible
/*--------------------------------------------------------------*/
function read_date($str){
     if($str)
      return date('F j, Y, g:i:s a', strtotime($str));
     else
      return null;
  }
/*--------------------------------------------------------------*/
/* Función para generar fecha actual
/*--------------------------------------------------------------*/
function make_date(){
  return strftime("%Y-%m-%d %H:%M:%S", time());
}
/*--------------------------------------------------------------*/
/* Función para contar ID
/*--------------------------------------------------------------*/
function count_id(){
  static $count = 1;
  return $count++;
}
/*--------------------------------------------------------------*/
/* Función para crear cadena aleatoria
/*--------------------------------------------------------------*/
function randString($length = 5)
{
  $str='';
  $cha = "0123456789abcdefghijklmnopqrstuvwxyz";

  for($x=0; $x<$length; $x++)
   $str .= $cha[mt_rand(0,strlen($cha))];
  return $str;
}


/*--------------------------------------------------------------*/
/* Función para generar campo oculto CSRF
/*--------------------------------------------------------------*/
function csrf_field() {
  global $session;
  return '<input type="hidden" name="csrf_token" value="' . $session->generate_csrf_token() . '">';
}

/*--------------------------------------------------------------*/
/* Función para verificar token CSRF en peticiones POST
/*--------------------------------------------------------------*/
function csrf_verify() {
  global $session;
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || !$session->validate_csrf_token($_POST['csrf_token'])) {
      die("¡Error de validación CSRF! La petición fue bloqueada por seguridad.");
    }
  }
}
?>
