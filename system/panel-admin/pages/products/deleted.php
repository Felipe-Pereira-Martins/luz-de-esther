<?php
// Corrige warnings
ini_set('display_errors', 0);
error_reporting(E_ALL ^ E_WARNING);

require_once("../../../../config/connection.php");

// Obtém o ID enviado
$id = $_POST['id'] ?? '';

if (empty($id)) {
    echo "ID inválido!";
    exit();
}

// Busca a imagem com segurança
$stmt = $pdo->prepare("SELECT image FROM sub_categories WHERE id = :id");
$stmt->bindValue(":id", $id);
$stmt->execute();
$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
$image = $res[0]['image'] ?? '';

// Remove a imagem física, se não for a padrão
if (!empty($image) && $image !== 'no-photo.jpg') {
    // Caminho ajustado com base na estrutura real
    $path = __DIR__ . "/../../../../assets/img/categories/" . $image;

    if (file_exists($path)) {
        unlink($path); // Exclui a imagem
    }
}

// Remove o registro do banco
$stmt = $pdo->prepare("DELETE FROM sub_categories WHERE id = :id");
$stmt->bindValue(":id", $id);
$stmt->execute();

echo "SALVO COM SUCESSO!!";
