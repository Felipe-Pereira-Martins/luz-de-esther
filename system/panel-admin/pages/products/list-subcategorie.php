<?php
ini_set('display_errors', 0);
error_reporting(E_ALL ^ E_WARNING);

require_once("../../../../config/connection.php");
$categorie = $_POST['txtCategorie'];
$subCategorie = $_POST['txtSubCategorie']; /* Vai receber o ID */

echo "<select class='sm-width form-control form-control-sm' name='sub_categorie' id='sub_categorie'>";
if ($subCategorie > 0) {
    $query2 = $pdo->query("SELECT * FROM sub_categories WHERE id = '$sub_categorie'");
    $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
     if (!empty($res)) {
        $nameSubCategorie = $res[0]['name'];
        echo "<option value='" . $subCategorie . "'>" . $nameSubCategorie . "</option>";
     }
}

$res = $pdo->query("SELECT * FROM sub_categories where id_categories = $categorie order by name asc");
          $data = $res->fetchAll(PDO::FETCH_ASSOC);
          for ($i=0; $i < count($data); $i++) { 
            foreach ($data[$i] as $key => $value) {
            }

            //Não mostra a subcategoria novamente
            if ($nameSubCategorie != $data[$i]['name']) {
           echo "<option value='" . $data[$i]['id'] . "'>" . $data[$i]['name'] . "</option>";
           }
       }
       echo "</select>";
?>