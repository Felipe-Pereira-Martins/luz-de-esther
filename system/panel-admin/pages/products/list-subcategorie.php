<?php
ini_set('display_errors', 0);
error_reporting(E_ALL ^ E_WARNING);

require_once("../../../../config/connection.php");
$categorie = $_POST['txtCategorie'];

echo "<select class='sm-width form-control form-control-sm' name='sub_categorie' id='sub_categorie'>";

$res = $pdo->query("SELECT * FROM sub_categories where id_categories = $categorie order by name asc");
          $data = $res->fetchAll(PDO::FETCH_ASSOC);
          for ($i=0; $i < count($data); $i++) { 
            foreach ($data[$i] as $key => $value) {
            }

           echo "<option value='" . $data[$i]['id'] . "'>" . $data[$i]['name'] . "</option>";
       }
       echo "</select>";
?>