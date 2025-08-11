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

// Remove o registro do banco
try {
    $stmt = $pdo->prepare("DELETE FROM shipping_type WHERE id = :id");
    $stmt->bindValue(":id", $id);
    $stmt->execute();

    // ✅ Mensagem esperada pelo AJAX para fechar a modal corretamente
    echo "SALVO COM SUCESSO!!";
} catch (PDOException $e) {
    echo "ERRO AO EXCLUIR: " . $e->getMessage();
}
?>
