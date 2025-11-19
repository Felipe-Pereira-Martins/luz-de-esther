<?php
// Desativa warnings em produção
ini_set('display_errors', 0);
error_reporting(E_ALL ^ E_WARNING);

require_once("../../../../config/connection.php");

// ID via POST (validar e tipar)
$id = $_POST['id'] ?? '';
if (!ctype_digit((string)$id)) {
    echo "ID inválido!";
    exit();
}
$id = (int)$id;

// Exclui o registro na tabela bundles
$stmt = $pdo->prepare("DELETE FROM bundles WHERE id = :id");
$stmt->bindValue(":id", $id, PDO::PARAM_INT);
$stmt->execute();

// Resposta que o seu JS espera
echo "EXCLUÍDO COM SUCESSO!!";