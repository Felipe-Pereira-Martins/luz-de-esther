<?php
/* Conexão */
require_once("../../../../config/connection.php");
/* Id com a caracteristica do produto */
$id_feature_prod = $_POST['txtid'];
 

echo $id_feature_prod;

/* Comment 
Botão para excluir o produto
<a href='#' onClick='deletedImg(" . $res[$i]['id'] . ")'> <i class='text-danger fas fa-times ml-1'></i></a>"
*/
 