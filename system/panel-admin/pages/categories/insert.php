<?php
// Corrige warnings de diretórios não encontrados e impede que "Salvo com Sucesso!!" seja suprimido
ini_set('display_errors', 0);
error_reporting(E_ALL ^ E_WARNING);

require_once("../../../../config/connection.php");

// Obtém os dados do formulário
$name = $_POST['name-category'] ?? '';
$name_new = strtr(trim($name), [
    'à'=>'a','á'=>'a','â'=>'a','ã'=>'a','ä'=>'a','ç'=>'c',
    'è'=>'e','é'=>'e','ê'=>'e','ë'=>'e',
    'ì'=>'i','í'=>'i','î'=>'i','ï'=>'i',
    'ò'=>'o','ó'=>'o','ô'=>'o','õ'=>'o','ö'=>'o',
    'ù'=>'u','ú'=>'u','û'=>'u','ü'=>'u','ñ'=>'n',
    'À'=>'A','Á'=>'A','Â'=>'A','Ã'=>'A','Ä'=>'A','Ç'=>'C',
    'È'=>'E','É'=>'E','Ê'=>'E','Ë'=>'E',
    'Ì'=>'I','Í'=>'I','Î'=>'I','Ï'=>'I',
    'Ò'=>'O','Ó'=>'O','Ô'=>'O','Õ'=>'O','Ö'=>'O',
    'Ù'=>'U','Ú'=>'U','Û'=>'U','Ü'=>'U','Ñ'=>'N'
]);
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
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE name = :name");
    $stmt->bindValue(":name", $name);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo "CATEGORIA JÁ CADASTRADA NO BANCO";
        exit();
    }
}

// Tratamento de upload de imagem
// Mantém a imagem anterior, a menos que uma nova seja enviada
$image = $_POST['old-image'] ?? 'no-photo.jpg';

if (!empty($_FILES['image']['name'])) {
    $imagem = $_FILES['image']['name'];
    $image_time = $_FILES['image']['tmp_name'];
    $ext = strtolower(pathinfo($imagem, PATHINFO_EXTENSION));

    $allowed = ['png', 'jpg', 'jpeg', 'gif'];
    if (in_array($ext, $allowed)) {
        $image = uniqid() . '.' . $ext;
        $path = __DIR__ . "/../../../../assets/img/categories/" . $image;

        if (!move_uploaded_file($image_time, $path)) {
            echo 'Erro ao salvar a imagem!';
            exit();
        }
    } else {
        echo 'Extensão de Imagem não permitida!';
        exit();
    }
}

// Atualiza ou insere registro no banco
if (!empty($id2)) {
    $stmt = $pdo->prepare("UPDATE categories SET name = :name, name_url = :name_url, image = :image WHERE id = :id");
    $stmt->bindValue(":name", $name);
    $stmt->bindValue(":name_url", $name_url);
    $stmt->bindValue(":image", $image);
    $stmt->bindValue(":id", $id2);
} else {
    $stmt = $pdo->prepare("INSERT INTO categories (name, name_url, image) VALUES (:name, :name_url, :image)");
    $stmt->bindValue(":name", $name);
    $stmt->bindValue(":name_url", $name_url);
    $stmt->bindValue(":image", $image);
}

try {
    $stmt->execute();
    echo "SALVO COM SUCESSO!!";
} catch (PDOException $e) {
    echo "ERRO AO SALVAR: " . $e->getMessage();
}
?>
