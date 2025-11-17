<?php
// Corrige warnings de diretórios não encontrados e impede que "Salvo com Sucesso!!" seja suprimido
ini_set('display_errors', 0);
error_reporting(E_ALL ^ E_WARNING);

require_once("../../../../config/connection.php");

// Obtém os dados do formulário
$feature = $_POST['feature'] ?? '';
$id = $_POST['txtid'] ?? ''; // Este é o id_product

// Validação de campo obrigatório
if (trim($feature) == "") {
    echo 'Escolha uma Característica!';
    exit();
}

// Verifica duplicidade 
// 💡 CORREÇÃO 1: Use $query e $res, não $stmt
$query = $pdo->query("SELECT * FROM feature_prod WHERE id_feature = '$feature' and id_product = '$id' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

// 💡 CORREÇÃO 2: Verifique o resultado com count($res)
if (count($res) > 0) {
    echo "Característica já cadastrada!"; // Mudei a msg de "TIPO" para "CARACTERÍSTICA"
    exit();
}

/* Relacionados a feature no banco de dados */
// 💡 CORREÇÃO 3: A sintaxe do INSERT estava errada, faltavam aspas no $id
$pdo->query("INSERT INTO feature_prod (id_feature, id_product) VALUES ('$feature', '$id')");

// 💡 CORREÇÃO 4: O try...catch estava no lugar errado e usando variável errada.
// Basta enviar a mensagem de sucesso se o código chegou até aqui.
echo "Salvo com sucesso!!";

?>