<?php
  require_once('includes/load.php');

/*--------------------------------------------------------------*/
/* Función para encontrar todas las filas de una tabla por nombre
/*--------------------------------------------------------------*/
function find_all($table) {
   global $db;
   if(tableExists($table))
   {
     return find_by_sql("SELECT * FROM ".$db->escape($table));
   }
}
/*--------------------------------------------------------------*/
/* Función para realizar consultas
/*--------------------------------------------------------------*/
function find_by_sql($sql)
{
  global $db;
  $result = $db->query($sql);
  $result_set = $db->while_loop($result);
 return $result_set;
}
/*--------------------------------------------------------------*/
/* Función para encontrar datos de una tabla por ID
/*--------------------------------------------------------------*/
function find_by_id($table,$id)
{
  global $db;
  $id = (int)$id;
    if(tableExists($table)){
          $sql = "SELECT * FROM {$db->escape($table)} WHERE id = ? LIMIT 1";
          $stmt = $db->query_prepared($sql, [$id]);
          if($result = $db->fetch_assoc($stmt))
            return $result;
          else
            return null;
     }
}
/*--------------------------------------------------------------*/
/* Función para eliminar datos de una tabla por ID
/*--------------------------------------------------------------*/
function delete_by_id($table,$id)
{
  global $db;
  if(tableExists($table))
   {
    $sql = "DELETE FROM ".$db->escape($table)." WHERE id = ? LIMIT 1";
    $db->query_prepared($sql, [(int)$id]);
    return ($db->affected_rows() === 1) ? true : false;
   }
}
/*--------------------------------------------------------------*/
/* Función para contar registros por tabla
/*--------------------------------------------------------------*/

function count_by_id($table){
  global $db;
  if(tableExists($table))
  {
    $sql    = "SELECT COUNT(id) AS total FROM ".$db->escape($table);
    $result = $db->query($sql);
     return($db->fetch_assoc($result));
  }
}
/*--------------------------------------------------------------*/
/* Determinar si una tabla de la base de datos existe
/*--------------------------------------------------------------*/
function tableExists($table){
  global $db;
  $sql = "SELECT table_name FROM information_schema.tables WHERE table_schema = ? AND table_name = ? LIMIT 1";
  $stmt = $db->query_prepared($sql, [DB_NAME, $table]);
  if ($stmt && $db->num_rows($stmt) > 0) {
      return true;
  }
  return false;
}
 /*--------------------------------------------------------------*/
 /* Iniciar sesión con los datos proporcionados en $_POST,
 /* provenientes del formulario de inicio de sesión.
 /*--------------------------------------------------------------*/
  function authenticate($username='', $password='') {
    global $db;
    $sql  = "SELECT id,username,password,user_level FROM users WHERE username = ? LIMIT 1";
    $stmt = $db->query_prepared($sql, [$username]);
    if($db->num_rows($stmt)){
      $user = $db->fetch_assoc($stmt);
      if(password_verify($password, $user['password']) || sha1($password) === $user['password'] ){
        return $user['id'];
      }
    }
   return false;
  }
  /*--------------------------------------------------------------*/
  /* Iniciar sesión con los datos proporcionados en $_POST,
  /* provenientes del formulario login_v2.php.
  /*--------------------------------------------------------------*/
    function authenticate_v2($username='', $password='') {
      global $db;
      $sql  = "SELECT id,username,password,user_level FROM users WHERE username = ? LIMIT 1";
      $stmt = $db->query_prepared($sql, [$username]);
      if($db->num_rows($stmt)){
        $user = $db->fetch_assoc($stmt);
        if(password_verify($password, $user['password']) || sha1($password) === $user['password'] ){
          return $user;
        }
      }
     return false;
    }


  /*--------------------------------------------------------------*/
  /* Encontrar el usuario actual por el ID de sesión
  /*--------------------------------------------------------------*/
  function current_user(){
      static $current_user;
      global $db;
      if(!$current_user){
         if(isset($_SESSION['user_id'])):
             $user_id = intval($_SESSION['user_id']);
             $current_user = find_by_id('users',$user_id);
         endif;
      }
    return $current_user;
  }
  /*--------------------------------------------------------------*/
  /* Encontrar todos los usuarios uniendo
  /* las tablas de usuarios y grupos de usuarios
  /*--------------------------------------------------------------*/
  function find_all_user(){
      global $db;
      $sql = "SELECT u.id,u.name,u.username,u.user_level,u.status,u.last_login,";
      $sql .="g.group_name ";
      $sql .="FROM users u ";
      $sql .="LEFT JOIN user_groups g ";
      $sql .="ON g.group_level=u.user_level ORDER BY u.name ASC";
      $result = find_by_sql($sql);
      return $result;
  }
  /*--------------------------------------------------------------*/
  /* Función para actualizar el último inicio de sesión de un usuario
  /*--------------------------------------------------------------*/

 function updateLastLogIn($user_id)
	{
		global $db;
    $date = make_date();
    $sql = "UPDATE users SET last_login = ? WHERE id = ? LIMIT 1";
    $result = $db->query_prepared($sql, [$date, (int)$user_id]);
    return ($result && $db->affected_rows() === 1 ? true : false);
	}

  /*--------------------------------------------------------------*/
  /* Encontrar todos los nombres de grupo
  /*--------------------------------------------------------------*/
  function find_by_groupName($val)
  {
    global $db;
    $sql = "SELECT group_name FROM user_groups WHERE group_name = ? LIMIT 1 ";
    $result = $db->query_prepared($sql, [$val]);
    return($db->num_rows($result) === 0 ? true : false);
  }
  /*--------------------------------------------------------------*/
  /* Encontrar nivel de grupo
  /*--------------------------------------------------------------*/
  function find_by_groupLevel($level)
  {
    global $db;
    $sql = "SELECT group_level, group_status FROM user_groups WHERE group_level = ? LIMIT 1 ";
    $result = $db->query_prepared($sql, [$level]);
    return $db->fetch_assoc($result);
  }
  /*--------------------------------------------------------------*/
  /* Función para comprobar qué nivel de usuario tiene acceso a la página
  /*--------------------------------------------------------------*/
   function page_require_level($require_level){
     global $session;
     $current_user = current_user();
     $login_level = find_by_groupLevel($current_user['user_level']);
     // si el usuario no ha iniciado sesión
     if (!$session->isUserLoggedIn(true)):
            $session->msg('d','Por favor inicie sesión...');
            redirect('index.php', false);
      // si el estado del grupo está inactivo
     elseif($login_level && $login_level['group_status'] === '0'):
           $session->msg('d','¡Este nivel de usuario está prohibido!');
           redirect('home.php',false);
      // comprueba si el nivel del usuario logueado es menor o igual al requerido
     elseif($current_user['user_level'] <= (int)$require_level):
              return true;
      else:
            $session->msg("d", "¡Lo sentimos! No tienes permiso para ver esta página.");
            redirect('home.php', false);
        endif;

     }
   /*--------------------------------------------------------------*/
   /* Función para encontrar todos los nombres de productos
   /* Uniéndose con las tablas de categorías y multimedia
   /*--------------------------------------------------------------*/
  function join_product_table(){
     global $db;
     $sql  =" SELECT p.id,p.name,p.quantity,p.buy_price,p.sale_price,p.media_id,p.date,c.name";
    $sql  .=" AS categorie,m.file_name AS image";
    $sql  .=" FROM products p";
    $sql  .=" LEFT JOIN categories c ON c.id = p.categorie_id";
    $sql  .=" LEFT JOIN media m ON m.id = p.media_id";
    $sql  .=" ORDER BY p.id ASC";
    return find_by_sql($sql);

   }
  /*--------------------------------------------------------------*/
  /* Función para encontrar todos los nombres de productos
  /* La solicitud proviene de ajax.php para el auto-sugerir
  /*--------------------------------------------------------------*/

   function find_product_by_title($product_name){
     global $db;
     $p_name = "%".$product_name."%";
     $sql = "SELECT name FROM products WHERE name LIKE ? LIMIT 5";
     $stmt = $db->query_prepared($sql, [$p_name]);
     return $db->while_loop($stmt);
   }

  /*--------------------------------------------------------------*/
  /* Función para encontrar toda la información del producto por título
  /* La solicitud proviene de ajax.php
  /*--------------------------------------------------------------*/
  function find_all_product_info_by_title($title){
    global $db;
    $sql  = "SELECT * FROM products WHERE name = ? LIMIT 1";
    $stmt = $db->query_prepared($sql, [$title]);
    return $db->while_loop($stmt);
  }

  /*--------------------------------------------------------------*/
  /* Función para actualizar la cantidad del producto
  /*--------------------------------------------------------------*/
  function update_product_qty($qty,$p_id){
    global $db;
    $sql = "UPDATE products SET quantity = quantity - ? WHERE id = ?";
    $result = $db->query_prepared($sql, [(int)$qty, (int)$p_id]);
    return($db->affected_rows() === 1 ? true : false);

  }
  /*--------------------------------------------------------------*/
  /* Función para mostrar los productos añadidos recientemente
  /*--------------------------------------------------------------*/
 function find_recent_product_added($limit){
   global $db;
   $sql   = " SELECT p.id,p.name,p.sale_price,p.media_id,c.name AS categorie,";
   $sql  .= "m.file_name AS image FROM products p";
   $sql  .= " LEFT JOIN categories c ON c.id = p.categorie_id";
   $sql  .= " LEFT JOIN media m ON m.id = p.media_id";
   $sql  .= " ORDER BY p.id DESC LIMIT ?";
   $stmt = $db->query_prepared($sql, [(int)$limit]);
   return $db->while_loop($stmt);
 }
 /*--------------------------------------------------------------*/
 /* Función para encontrar el producto más vendido
 /*--------------------------------------------------------------*/
 function find_higest_saleing_product($limit){
   global $db;
   $sql  = "SELECT p.name, COUNT(s.product_id) AS totalSold, SUM(s.qty) AS totalQty";
   $sql .= " FROM sales s";
   $sql .= " LEFT JOIN products p ON p.id = s.product_id ";
   $sql .= " GROUP BY s.product_id";
   $sql .= " ORDER BY SUM(s.qty) DESC LIMIT ?";
   return $db->query_prepared($sql, [(int)$limit]);
 }
 /*--------------------------------------------------------------*/
 /* Función para encontrar todas las ventas
 /*--------------------------------------------------------------*/
 function find_all_sale(){
   global $db;
   $sql  = "SELECT s.id,s.qty,s.price,s.date,p.name";
   $sql .= " FROM sales s";
   $sql .= " LEFT JOIN products p ON s.product_id = p.id";
   $sql .= " ORDER BY s.date DESC";
   return find_by_sql($sql);
 }
 /*--------------------------------------------------------------*/
 /* Función para mostrar ventas recientes
 /*--------------------------------------------------------------*/
function find_recent_sale_added($limit){
  global $db;
  $sql  = "SELECT s.id,s.qty,s.price,s.date,p.name";
  $sql .= " FROM sales s";
  $sql .= " LEFT JOIN products p ON s.product_id = p.id";
  $sql .= " ORDER BY s.date DESC LIMIT ?";
  $stmt = $db->query_prepared($sql, [(int)$limit]);
  return $db->while_loop($stmt);
}
/*--------------------------------------------------------------*/
/* Función para generar informe de ventas por dos fechas
/*--------------------------------------------------------------*/
function find_sale_by_dates($start_date,$end_date){
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = "SELECT s.date, p.name,p.sale_price,p.buy_price,";
  $sql .= "COUNT(s.product_id) AS total_records,";
  $sql .= "SUM(s.qty) AS total_sales,";
  $sql .= "SUM(p.sale_price * s.qty) AS total_saleing_price,";
  $sql .= "SUM(p.buy_price * s.qty) AS total_buying_price ";
  $sql .= "FROM sales s ";
  $sql .= "LEFT JOIN products p ON s.product_id = p.id";
  $sql .= " WHERE s.date BETWEEN ? AND ?";
  $sql .= " GROUP BY DATE(s.date),p.name";
  $sql .= " ORDER BY DATE(s.date) DESC";
  return $db->query_prepared($sql, [$start_date, $end_date]);
}
/*--------------------------------------------------------------*/
/* Función para generar informe de ventas diarias
/*--------------------------------------------------------------*/
function  dailySales($year,$month){
  global $db;
  $date_filter = $year.'-'.str_pad($month, 2, '0', STR_PAD_LEFT);
  $sql  = "SELECT s.qty,";
  $sql .= " DATE_FORMAT(s.date, '%Y-%m-%e') AS date,p.name,";
  $sql .= "SUM(p.sale_price * s.qty) AS total_saleing_price";
  $sql .= " FROM sales s";
  $sql .= " LEFT JOIN products p ON s.product_id = p.id";
  $sql .= " WHERE DATE_FORMAT(s.date, '%Y-%m' ) = ?";
  $sql .= " GROUP BY DATE_FORMAT( s.date,  '%e' ),s.product_id";
  $stmt = $db->query_prepared($sql, [$date_filter]);
  return $db->while_loop($stmt);
}
/*--------------------------------------------------------------*/
/* Función para generar informe de ventas mensuales
/*--------------------------------------------------------------*/
function  monthlySales($year){
  global $db;
  $sql  = "SELECT s.qty,";
  $sql .= " DATE_FORMAT(s.date, '%Y-%m-%e') AS date,p.name,";
  $sql .= "SUM(p.sale_price * s.qty) AS total_saleing_price";
  $sql .= " FROM sales s";
  $sql .= " LEFT JOIN products p ON s.product_id = p.id";
  $sql .= " WHERE DATE_FORMAT(s.date, '%Y' ) = ?";
  $sql .= " GROUP BY DATE_FORMAT( s.date,  '%c' ),s.product_id";
  $sql .= " ORDER BY date_format(s.date, '%c' ) ASC";
  $stmt = $db->query_prepared($sql, [$year]);
  return $db->while_loop($stmt);
}

?>
