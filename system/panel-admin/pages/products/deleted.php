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

// Busca a imagem atual do produto
$stmt = $pdo->prepare("SELECT image FROM products WHERE id = :id");
$stmt->bindValue(":id", $id, PDO::PARAM_INT);
$stmt->execute();
$image = $stmt->fetchColumn() ?: '';

// Remove o arquivo físico (pasta CORRETA: products)
if ($image && $image !== 'no-photo.jpg') {
    $path = __DIR__ . "/../../../../assets/img/products/" . $image;
    if (is_file($path)) {
        @unlink($path);
    }
}

// Exclui o registro na tabela products
$stmt = $pdo->prepare("DELETE FROM products WHERE id = :id");
$stmt->bindValue(":id", $id, PDO::PARAM_INT);
$stmt->execute();

// Resposta que o seu JS espera
echo "EXCLUÍDO COM SUCESSO!!";
