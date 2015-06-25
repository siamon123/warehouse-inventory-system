<?php
  require_once('includes/load.php');
  /*--------------------------------------------------------------*/
  /* Function for check mysqli query
  /*--------------------------------------------------------------*/
  function check_query($result){
    if(!$result){
      die("Database query failed");
    }
  }
/*--------------------------------------------------------------*/
/* Function for While loop
/*--------------------------------------------------------------*/
  function while_loop($loop){
    $results = array();
    while ($result = mysqli_fetch_array($loop)) {
       $results[] = $result;
    }
    return $results;
  }
  /*--------------------------------------------------------------*/
  /* Function for user login
  /*--------------------------------------------------------------*/
  function authenticate($username='', $password='') {
    global $con;
    $username = real_escape($username);
    $password = real_escape($password);

    $sql  = sprintf("SELECT id, username, password FROM users WHERE username ='%s' LIMIT 1", $username);
    $result = mysqli_query($con,$sql);
    if(mysqli_num_rows($result)){
      $user = mysqli_fetch_assoc($result);
      $password_request = sha1($password);
      if($password_request === $user['password'] ){
        return $user['id'];
      }
    }

   return false;
  }
  /*--------------------------------------------------------------*/
  /* Function for Current login user
  /*--------------------------------------------------------------*/
  function current_user(){
    static $current_user;
    global $con;
    if(!$current_user){
     if(isset($_SESSION['user_id'])){
       $user_id = intval($_SESSION['user_id']);
       $sql  = "SELECT * FROM ";
       $sql .= "users WHERE ";
       $sql .= " id=".real_escape($user_id);
       $result = mysqli_query($con, $sql);
       if(mysqli_num_rows($result)){
         $current_user = mysqli_fetch_assoc($result);
         return $current_user;
       }
     }

    }
    return $current_user;
  }
  /*--------------------------------------------------------------*/
  /* Function for Count users by id
  /*--------------------------------------------------------------*/

  function count_users(){
    global $con;
    $sql    = "SELECT COUNT(id) AS total_user FROM users";
    $result = mysqli_query($con,$sql);
    $result = mysqli_fetch_assoc($result);
    return $result;
  }
  /*--------------------------------------------------------------*/
  /* Function for Find all categories
  /*--------------------------------------------------------------*/
  function all_catgories(){
    global $con;
    $sql  = "SELECT * ";
    $sql .= "FROM categories";
    $sql .= " ORDER BY name";
    $cat_result = mysqli_query($con,$sql);
    if($cat_result){

      $results = while_loop($cat_result);

    } else {
      check_query($cat_result);
    }
    return $results;
  }
  /*--------------------------------------------------------------*/
  /* Function for Find categorie by id
  /*--------------------------------------------------------------*/
  function find_by_cat_id($id){
    global $con;
    $cat_id = remove_junk($id);
    $sql = "SELECT * FROM categories WHERE id='{$id}'";
    $row = mysqli_query($con,$sql);
    check_query($row);
    if($result = mysqli_fetch_assoc($row)){
      return $result;
    } else {
      return null;
    }

  }
  /*--------------------------------------------------------------*/
  /* Function for Count categorie by id
  /*--------------------------------------------------------------*/

  function count_categories(){
    global $con;

    $sql    = "SELECT COUNT(id) AS total_cat FROM categories";
    $result = mysqli_query($con,$sql);
    $result = mysqli_fetch_assoc($result);
    return $result;
  }

  /*--------------------------------------------------------------*/
  /* Function for All products
  /*--------------------------------------------------------------*/
  function find_all_product(){
    global $con;
    $sql  = " SELECT * FROM product_views";
    $result = mysqli_query($con,$sql);
    if($result){

      $results = while_loop($result);

    } else {
      check_query($result);
    }
    return $results;
  }
  /*--------------------------------------------------------------*/
  /* Function for Find product by id
  /*--------------------------------------------------------------*/
  function find_by_product_id($id){
    global $con;
    $p_id = (int)$id;
    $sql  = " SELECT * FROM products";
    $sql .= " WHERE ";
    $sql .= "id = '{$p_id}'";
    $row = mysqli_query($con,$sql);
    check_query($row);
    if($result = mysqli_fetch_assoc($row)){
      return $result;
    } else {
      return null;
    }

  }
  /*--------------------------------------------------------------*/
  /* Function for Count products by id
  /*--------------------------------------------------------------*/

  function count_products(){
    global $con;
    $sql    = "SELECT COUNT(id) AS total_pro FROM products";
    $result = mysqli_query($con,$sql);
    $result = mysqli_fetch_assoc($result);
    return $result;
  }
  /*--------------------------------------------------------------*/
  /* Function for Find product name by product title
  /*--------------------------------------------------------------*/
  function find_product_views_by_name($title){
    global $con;
    $sql  = "SELECT * FROM product_views ";
    $sql .= " WHERE name ='{$title}'";
    $sql .=" LIMIT 1";
    $result = mysqli_query($con,$sql);
    if($result){
      $results = while_loop($result);
    } else {
      check_query($result);
    }
    return $results;
  }

  /*--------------------------------------------------------------*/
  /* Function for Update product quantity
  /*--------------------------------------------------------------*/
  function update_product_qty($qty,$p_id){
    global $con;
    $qty = (int) $qty;
    $id  = (int)$p_id;
    $sql = "UPDATE products SET quantity=quantity -'{$qty}' WHERE id = '{$id}'";
    $result = mysqli_query($con,$sql);
    if(mysqli_affected_rows($con) == 1){
      return true;
    } else {
      return false;
    }
  }
  /*--------------------------------------------------------------*/
  /* Function for Display Recent product Added
  /*--------------------------------------------------------------*/
 function find_recent_product_added(){
   global $con;
   $sql = "SELECT id,name,categorie_name,sale_price FROM product_views ORDER BY name DESC LIMIT 10";
   $result = mysqli_query($con,$sql);
   if($result){
     $results = while_loop($result);
   } else {
     check_query($result);
   }
   return $results;
 }
  /*--------------------------------------------------------------*/
  /* Function for Find all sales
  /*--------------------------------------------------------------*/
 function find_all_sale(){
   global $con;
   $sql = "SELECT * FROM sale_views";
   $result = mysqli_query($con,$sql);
   if($result){
     $results = while_loop($result);
   } else {
     check_query($result);
   }
   return $results;
 }
 /*--------------------------------------------------------------*/
 /* Function for Find sale by id
 /*--------------------------------------------------------------*/
 function find_by_sale_id($id){
   global $con;
   $s_id = (int)$id;
   $sql  = " SELECT * FROM sales";
   $sql .= " WHERE ";
   $sql .= "id = '{$s_id}'";
   $row = mysqli_query($con,$sql);
   check_query($row);
   if($result = mysqli_fetch_assoc($row)){
     return $result;
   } else {
     return null;
   }

 }
 /*--------------------------------------------------------------*/
 /* Function for Count sales by id
 /*--------------------------------------------------------------*/

 function count_sales(){
   global $con;
   $sql    = "SELECT COUNT(id) AS total_sale FROM sales";
   $result = mysqli_query($con,$sql);
   $result = mysqli_fetch_assoc($result);
   return $result;
 }
 /*--------------------------------------------------------------*/
 /* Function for Find Highest saleing Product
 /*--------------------------------------------------------------*/
 function find_higest_sale_product(){
   global $con;
   $sql  = "SELECT name,";
   $sql .= "COUNT(name) AS Totalsold,";
   $sql .= "SUM(qty) AS Totalquantity";
   $sql .= " FROM sale_views";
   $sql .= " GROUP BY name";
   $sql .= " ORDER BY name ASC";
   $result = mysqli_query($con,$sql);
   if($result){
     $results = while_loop($result);
   } else {
     check_query($result);
   }
   return $results;
 }
 /*--------------------------------------------------------------*/
 /* Function for Display Recent product Added
 /*--------------------------------------------------------------*/
function find_recent_sale_added(){
  global $con;
  $sql = "SELECT id,name,date,price FROM sale_views ORDER BY date DESC LIMIT 20";
  $result = mysqli_query($con,$sql);
  if($result){
    $results = while_loop($result);
  } else {
    check_query($result);
  }
  return $results;
}

function find_sale_by_dates($start_date,$end_date){
  global $con;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = "SELECT s.date, p.name,p.sale_price,p.buy_price,";
  $sql .= "COUNT(s.product_id) AS total_records,";
  $sql .= "SUM(s.qty) AS total_sales,";
  $sql .= "SUM(p.sale_price * s.qty) AS total_saleing_price,";
  $sql .= "SUM(p.buy_price * s.qty) AS total_buying_price ";
  $sql .= "FROM sales s ";
  $sql .= "LEFT JOIN products p ON s.product_id = p.id";
  $sql .= " WHERE s.date BETWEEN '{$start_date}' AND '{$end_date}'";
  $sql .= " GROUP BY DATE(s.date),p.name";
  $sql .= " ORDER BY DATE(s.date) DESC";

  $result = mysqli_query($con,$sql);
  if($result){
    $results = while_loop($result);
  } else {
    check_query($result);
  }
  return $results;
}
?>
