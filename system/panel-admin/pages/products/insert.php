<?php
ini_set('display_errors', 0);
error_reporting(E_ALL ^ E_WARNING);

require_once("../../../../config/connection.php");

// Obtém os dados do formulário
$name = $_POST['name-category'] ?? '';
$categorie = $_POST['categorie'] ?? '';
$id2 = $_POST['txtid2'] ?? '';
$old = $_POST['old-name'] ?? '';
$image = $_POST['old-image'] ?? 'no-photo.jpg';

// Gera o name_url (slug)
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
$name_url = strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', $name_new));

// Validação
if (trim($name) === "") {
    echo 'PREENCHA O CAMPO NOME!';
    exit();
}

// Verifica duplicidade de subcategoria (na mesma tabela de subcategorias)
if ($name !== $old) {
    $stmt = $pdo->prepare("SELECT * FROM sub_categories WHERE name = :name AND id_categories = :id_cat");
    $stmt->bindValue(":name", $name);
    $stmt->bindValue(":id_cat", $categorie);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo "SUBCATEGORIA JÁ CADASTRADA PARA ESSA CATEGORIA!";
        exit();
    }
}

// Upload da imagem (se tiver)
if (!empty($_FILES['image']['name'])) {
    $imagem = $_FILES['image']['name'];
    $image_time = $_FILES['image']['tmp_name'];
    $ext = strtolower(pathinfo($imagem, PATHINFO_EXTENSION));

    $allowed = ['png', 'jpg', 'jpeg', 'gif'];
    if (in_array($ext, $allowed)) {
        $image = uniqid() . '.' . $ext;
        $path = __DIR__ . "/../../../../assets/img/sub-categories/" . $image;

        if (!move_uploaded_file($image_time, $path)) {
            echo 'Erro ao salvar a imagem!';
            exit();
        }
    } else {
        echo 'Extensão de Imagem não permitida!';
        exit();
    }
}

// Atualizar ou inserir na tabela correta: sub_categories
if (!empty($id2)) {
    $stmt = $pdo->prepare("UPDATE sub_categories SET name = :name, name_url = :name_url, image = :image, id_categories = :id_categories WHERE id = :id");
    $stmt->bindValue(":name", $name);
    $stmt->bindValue(":name_url", $name_url);
    $stmt->bindValue(":image", $image);
    $stmt->bindValue(":id_categories", $categorie);
    $stmt->bindValue(":id", $id2);
} else {
    $stmt = $pdo->prepare("INSERT INTO sub_categories (name, name_url, image, items, id_categories) VALUES (:name, :name_url, :image, 0, :id_categories)");
    $stmt->bindValue(":name", $name);
    $stmt->bindValue(":name_url", $name_url);
    $stmt->bindValue(":image", $image);
    $stmt->bindValue(":id_categories", $categorie);
}

try {
    $stmt->execute();
    echo "SALVO COM SUCESSO!!";
} catch (PDOException $e) {
    echo "ERRO AO SALVAR: " . $e->getMessage();
}
?>
