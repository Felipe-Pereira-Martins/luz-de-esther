<?php
/* Conexão */
require_once("../../../../config/connection.php");
$id = $_POST['id'];
$pag = "products";

$query = $pdo->query("SELECT * FROM images where id_product = '" . $id . "' ");
echo "<div class='row'>";
$res = $query->fetchAll(PDO::FETCH_ASSOC);
for ($i = 0; $i < count($res); $i++) {
    foreach ($res[$i] as $key => $value) {
    } 
    echo "<img class='ml-4 mb-2' src='../../store/assets/img/products/details/"
        . $res[$i]['image'] . "' width='70'> 
    <a href='#' onClick='deletedImg(" . $res[$i]['id'] . ")'> 
    <i class='text-danger fas fa-times ml-1'></i></a>";
}
echo "</div>";

/* Comment 
Botão para excluir o produto
<a href='#' onClick='deletedImg(" . $res[$i]['id'] . ")'> <i class='text-danger fas fa-times ml-1'></i></a>"
*/
