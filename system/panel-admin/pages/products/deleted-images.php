<?php
require_once("../../../../config/connection.php");

if (empty($_POST['id_photo_img'])) {
  http_response_code(400);
  exit('ID inválido');
}
$id = (int) $_POST['id_photo_img'];

$stmt = $pdo->prepare("DELETE FROM images WHERE id = :id");
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();

echo "Excluído com Sucesso!!";
