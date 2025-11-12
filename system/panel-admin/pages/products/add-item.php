<?php 
require_once("../../../../config/connection.php");
$name_item = $_POST['name-item'] ?? ''; 
$value_item = $_POST['value-item'] ?? ''; 
$id_feature_prod = $_POST['id_feature_item'] ?? ''; 

if (trim($name_item) == "") {
    echo 'Digite uma descrição para o item!';
    exit();
}

$query = $pdo->query("SELECT * FROM feature_items WHERE  name = '$name_item' and id_feature_prod = '$id_feature_prod' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

if (count($res) > 0) {
    echo "Item para essa característica já cadastrada!"; 
    exit();
}

$pdo->query("INSERT INTO feature_items (id_feature_prod, name, value_item) VALUES ('$id_feature_prod', '$name_item', '$value_item')");

echo 'Salvo com sucesso!!';

?>