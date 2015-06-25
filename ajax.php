<?php
  require_once('includes/load.php');
  if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
?>
<?php
$html = '';
 if(isset($_POST['product_name']) && strlen($_POST['product_name']))
 {

    $p_name = remove_junk(real_escape($_POST['product_name']));
    $sql = "SELECT name FROM products WHERE name like '%$p_name%' LIMIT 3 ";
    $result = mysqli_query($con,$sql);

    if(mysqli_num_rows($result) > 0){

      while($row = mysqli_fetch_array($result)){
        $html .= "<li class=\"list-group-item\">";
        $html .= $row['name'];
        $html .= "</li>";
      }

    } else {

      $html .= '<li onClick=\"fill(\''.addslashes().'\')\" class=\"list-group-item\">';
      $html .= 'Not found';
      $html .= "</li>";

    }

    echo json_encode($html);
 }
 ?>
 <?php

  if(isset($_POST['p_name']) && strlen($_POST['p_name']))
  {
    $product_title = remove_junk(real_escape($_POST['p_name']));
    if($results = find_product_views_by_name($product_title)){
        foreach ($results as $result) {

          $html .= "<tr>";

          $html .= "<td id=\"s_name\">".$result['name']."</td>";
          $html .= "<input type=\"hidden\" name=\"s_id\" value=\"{$result['id']}\">";
          $html  .= "<td>";
          $html  .= "<input type=\"text\" class=\"form-control\" name=\"price\" value=\"{$result['sale_price']}\">";
          $html  .= "</td>";
          $html .= "<td id=\"s_qty\">";
          $html .= "<input type=\"text\" class=\"form-control\" name=\"quantity\" value=\"1\">";
          $html  .= "</td>";
          $html  .= "<td>";
          $html  .= "<input type=\"text\" class=\"form-control\" name=\"total\" value=\"{$result['sale_price']}\">";
          $html  .= "</td>";
          $html  .= "<td>";
          $html  .= "<input type=\"date\" class=\"form-control datePicker\" name=\"date\" data-date data-date-format=\"yyyy-mm-dd\">";
          $html  .= "</td>";
          $html  .= "<td>";
          $html  .= "<button type=\"submit\" name=\"add_sale\" class=\"btn btn-primary\">Add sale</button>";
          $html  .= "</td>";
          $html  .= "</tr>";

        }
    } else {
        $html ='<tr><td>product name not resgister in database</td></tr>';
    }

    echo json_encode($html);
  }
 ?>
