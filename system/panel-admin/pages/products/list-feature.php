<?php
/* Conexão */
require_once("../../../../config/connection.php");
$id_product = $_POST['txtid'];
$pag = "products";

$query = $pdo->query("SELECT * FROM feature_prod where id_product = '" . $id_product . "' ");
echo "<div class='ml-2'>"; /* Input com selec -- x com as características */
$res = $query->fetchAll(PDO::FETCH_ASSOC);
for ($i = 0; $i < count($res); $i++) {
    foreach ($res[$i] as $key => $value) {
    }
    $id_feature = $res[$i]['id_feature'];
    // Recuperar o nome da característica
    $query2 = $pdo->query("SELECT * FROM feature WHERE id = '$id_feature'");
    $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);

    // <-- ESTA É A CORREÇÃO
    // Verifica se a consulta encontrou um resultado
    if (count($res2) > 0) {
        $name_feature = $res2[0]['name'];
        echo "<div class='mb-1'><i class='text-primary fas fa-circle fa-xs fa-fw mr-2'></i> <a title='Adicionar Item' 
        href='#' class='text-dark' style='text-decoration: none;' onClick='addItem(" . $res[$i]['id'] . ")'>" . $name_feature . "</a> 
        <a title='Deletar Caracteristica' href='#' onClick='deletedFeature(" . $res[$i]['id'] . ")'>
        <i class='text-danger fas fa-times fa-xs fa-fw ml-1'></i></a></div>";
    }
    // <-- FIM DA CORREÇÃO
}
echo "</div>";

/* Comment 
Botão para excluir o produto
<a href='#' onClick='deletedImg(" . $res[$i]['id'] . ")'> <i class='text-danger fas fa-times ml-1'></i></a>"
*/
