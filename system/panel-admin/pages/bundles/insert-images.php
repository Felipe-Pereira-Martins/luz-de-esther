<?php
ini_set('display_errors', 0);
error_reporting(E_ALL ^ E_WARNING);

require_once("../../../../config/connection.php");

// 1) Campos do POST
$id_product = $_POST['id'] ?? '';
if (empty($id_product)) {
  http_response_code(400);
  exit('ID do produto não informado.');
}

// 2) Verifica arquivo
if (!isset($_FILES['imgproduct']) || $_FILES['imgproduct']['error'] !== UPLOAD_ERR_OK) {
  http_response_code(400);
  exit('Nenhuma imagem enviada.');
}

// 3) Valida extensão (usa $imagem, não $image)
$imagem     = $_FILES['imgproduct']['name'];
$tmp        = $_FILES['imgproduct']['tmp_name'];
$ext        = strtolower(pathinfo($imagem, PATHINFO_EXTENSION));
$permitidas = ['png','jpg','jpeg','gif'];

if (!in_array($ext, $permitidas)) {
  http_response_code(400);
  exit('Extensão de imagem não permitida.');
}

// 4) Gera nome único e define pasta (bata com a exibida na view!)
$novoNome = uniqid() . '.' . $ext;
// Se suas imagens aparecem via ../../../store/assets/img/products/details/...
$destino  = __DIR__ . "/../../../../store/assets/img/products/details/" . $novoNome;

// Garante que a pasta exista
$dir = dirname($destino);
if (!is_dir($dir)) {
  if (!mkdir($dir, 0775, true)) {
    http_response_code(500);
    exit('Não foi possível criar a pasta de destino.');
  }
}

// 5) Move o arquivo
if (!move_uploaded_file($tmp, $destino)) {
  http_response_code(500);
  exit('Erro ao salvar a imagem no servidor.');
}

// 6) Insere no banco
try {
  $stmt = $pdo->prepare("
    INSERT INTO images (id_product, image)
    VALUES (:id_product, :image)
  ");
  $stmt->bindValue(':id_product', (int)$id_product, PDO::PARAM_INT);
  $stmt->bindValue(':image', $novoNome, PDO::PARAM_STR);
  $stmt->execute();

  echo "SALVO COM SUCESSO!!";
} catch (PDOException $e) {
  http_response_code(500);
  echo "ERRO AO SALVAR: " . $e->getMessage();
}
