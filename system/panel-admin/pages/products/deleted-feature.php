<?php
require_once("../../../../config/connection.php");

// 1. Você checa por 'id_feature'
if (empty($_POST['id_feature'])) {
  http_response_code(400);
  exit('ID inválido');
}

// 2. Você DEVE USAR 'id_feature' aqui também
$id = (int) $_POST['id_feature']; 

$stmt = $pdo->prepare("DELETE FROM feature_prod WHERE id = :id");
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();

echo "Excluído com Sucesso!!";