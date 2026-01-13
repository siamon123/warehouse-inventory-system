<?php
require_once(LIB_PATH_INC.DS."config.php");

class Database {

    private $pdo;
    public $stmt;

    function __construct() {
      $this->db_connect();
    }

/*--------------------------------------------------------------*/
/* Función para abrir la conexión a la base de datos (PDO)
/*--------------------------------------------------------------*/
public function db_connect()
{
  try {
    $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $this->pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
  } catch (\PDOException $e) {
     $error_message = $e->getMessage();
     // Buscamos el archivo db_error.php en la raíz
     $error_page = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'db_error.php';
     if (file_exists($error_page)) {
         include($error_page);
     } else {
         die("La conexión a la base de datos falló: " . $error_message);
     }
     exit;
  }
}

/*--------------------------------------------------------------*/
/* Función para cerrar la conexión a la base de datos
/*--------------------------------------------------------------*/
public function db_disconnect()
{
  $this->pdo = null;
}

/*--------------------------------------------------------------*/
/* Función para ejecutar consultas (Soporta consultas directas)
/*--------------------------------------------------------------*/
public function query($sql)
{
  try {
    if (trim($sql) != "") {
        $this->stmt = $this->pdo->query($sql);
    }
    return $this->stmt;
  } catch (\PDOException $e) {
     // Solo para modo desarrollo
     die("Error en esta consulta :<pre> " . $sql ."</pre><br>Error: " . $e->getMessage());
  }
}

/*--------------------------------------------------------------*/
/* Función para consultas preparadas (Seguridad mejorada)
/*--------------------------------------------------------------*/
public function query_prepared($sql, $params = [])
{
  try {
    $this->stmt = $this->pdo->prepare($sql);
    $this->stmt->execute($params);
    return $this->stmt;
  } catch (\PDOException $e) {
    die("Error en consulta preparada: <pre>" . $sql . "</pre><br>Error: " . $e->getMessage());
  }
}

/*--------------------------------------------------------------*/
/* Funciones auxiliares para compatibilidad
/*--------------------------------------------------------------*/
public function fetch_array($statement)
{
  return $statement->fetch(PDO::FETCH_BOTH);
}

public function fetch_object($statement)
{
  return $statement->fetch(PDO::FETCH_OBJ);
}

public function fetch_assoc($statement)
{
  return $statement->fetch(PDO::FETCH_ASSOC);
}

public function num_rows($statement)
{
  return $statement->rowCount();
}

public function insert_id()
{
  return $this->pdo->lastInsertId();
}

public function affected_rows()
{
  return $this->stmt ? $this->stmt->rowCount() : 0;
}

/*--------------------------------------------------------------*/
/* Función para escapar (Legacy - El uso de PDO lo hace redundante)
/*--------------------------------------------------------------*/
 public function escape($str){
   // Todavía lo mantenemos para compatibilidad con código antiguo
   return $str !== null ? str_replace(["\\", "\x00", "\n", "\r", "'", '"', "\x1a"], ["\\\\", "\\0", "\\n", "\\r", "\'", '\"', "\\Z"], $str) : null;
 }

/*--------------------------------------------------------------*/
/* Función para bucle while
/*--------------------------------------------------------------*/
public function while_loop($loop){
   $results = array();
   while ($result = $this->fetch_assoc($loop)) {
      $results[] = $result;
   }
 return $results;
}

}

$db = new Database();

?>
