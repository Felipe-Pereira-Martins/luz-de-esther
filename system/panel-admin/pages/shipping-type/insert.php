<?php
// Corrige warnings de diretórios não encontrados e impede que "Salvo com Sucesso!!" seja suprimido
ini_set('display_errors', 0);
error_reporting(E_ALL ^ E_WARNING);

require_once("../../../../config/connection.php");

// Obtém os dados do formulário
$name = $_POST['name-category'] ?? '';
// Gera slug/URL amigável
$name_url = strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', $name_new));
$old = $_POST['old-name'] ?? ''; // Corrigido para refletir o novo name no formulário
$id2 = $_POST['txtid2'] ?? '';

// Validação de campo obrigatório
if (trim($name) === "") {
    echo 'PREENCHA O CAMPO NOME!';
    exit();
}

// Verifica duplicidade de nome (evita sobrescrita acidental)
if ($name !== $old) {
    $stmt = $pdo->prepare("SELECT * FROM shipping_type WHERE name = :name");
    $stmt->bindValue(":name", $name);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo "TIPO JÁ CADASTRADA NO BANCO";
        exit();
    }
}

// Atualiza ou insere registro no banco
if (!empty($id2)) {
    $stmt = $pdo->prepare("UPDATE shipping_type SET name = :name WHERE id = :id");
    $stmt->bindValue(":name", $name);
    $stmt->bindValue(":id", $id2);
} else {
    $stmt = $pdo->prepare("INSERT INTO shipping_type (name) VALUES (:name)");
    $stmt->bindValue(":name", $name);
}

try {
    $stmt->execute();
    echo "SALVO COM SUCESSO!!";
} catch (PDOException $e) {
    echo "ERRO AO SALVAR: " . $e->getMessage();
}
?>
