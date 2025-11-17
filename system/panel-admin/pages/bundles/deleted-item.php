<?php
require_once("../../../../config/connection.php");

// ✅ Nome correto do campo
if (empty($_POST['id_feature_item'])) {
  http_response_code(400);
  exit('ID inválido');
}

$id = (int) $_POST['id_feature_item']; // ✅ Nome correto

try {
    $stmt = $pdo->prepare("DELETE FROM feature_items WHERE id = :id");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    
    if ($stmt->execute()) {
        echo "Excluído com Sucesso!!";
    } else {
        echo "Erro ao excluir item";
    }
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>