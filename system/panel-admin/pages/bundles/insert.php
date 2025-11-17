<?php
ini_set('display_errors', 0);
error_reporting(E_ALL ^ E_WARNING);

require_once("../../../../config/connection.php");

// Obtém os dados do formulário
$name = $_POST['name-category'] ?? '';
$id_categorie = $_POST['categorie'] ?? '';
$id_sub_categorie = $_POST['sub_categorie'] ?? '';
$description = $_POST['description'] ?? '';
$description_long = $_POST['description_long'] ?? '';
$value = $_POST['value'] ?? '';
$stock = $_POST['stock'] ?? '';
$shipping_type = $_POST['shipping_type'] ?? '';
$enable = $_POST['enable'] ?? '';
$word = $_POST['word'] ?? '';
$weight = $_POST['weight'] ?? '';
$width = $_POST['width'] ?? '';
$height = $_POST['height'] ?? '';
$model = $_POST['model'] ?? '';
$shipping_value = $_POST['shipping-value'] ?? '';
$length = $_POST['length'] ?? '';
$id2 = $_POST['txtid2'] ?? '';

// ---- NOVO: flags e imagem atual do banco (fonte da verdade) ----
$hasNewImage   = 0;     // indica se houve upload novo
$newImageName  = null;  // guarda o nome do novo arquivo, se houver
$currentImageDB = null; // imagem atual do produto no banco

if (!empty($id2)) { // modo edição
    $stmtCur = $pdo->prepare("SELECT image FROM products WHERE id = :id");
    $stmtCur->execute([':id' => $id2]);
    $currentImageDB = $stmtCur->fetchColumn() ?: 'no-photo.jpg';
}



/* Troca o . pela , relacionado ao valor */
$value = str_replace(',', '.', $value);
$shipping_value = str_replace(',', '.', $shipping_value);
$weight = str_replace(',', '.', $weight);
$width = str_replace(',', '.', $width);
$height = str_replace(',', '.', $height);
$length = str_replace(',', '.', $length);

// Gera o name_url (slug)
$name_new = strtr(trim($name), [
    'à' => 'a',
    'á' => 'a',
    'â' => 'a',
    'ã' => 'a',
    'ä' => 'a',
    'ç' => 'c',
    'è' => 'e',
    'é' => 'e',
    'ê' => 'e',
    'ë' => 'e',
    'ì' => 'i',
    'í' => 'i',
    'î' => 'i',
    'ï' => 'i',
    'ò' => 'o',
    'ó' => 'o',
    'ô' => 'o',
    'õ' => 'o',
    'ö' => 'o',
    'ù' => 'u',
    'ú' => 'u',
    'û' => 'u',
    'ü' => 'u',
    'ñ' => 'n',
    'À' => 'A',
    'Á' => 'A',
    'Â' => 'A',
    'Ã' => 'A',
    'Ä' => 'A',
    'Ç' => 'C',
    'È' => 'E',
    'É' => 'E',
    'Ê' => 'E',
    'Ë' => 'E',
    'Ì' => 'I',
    'Í' => 'I',
    'Î' => 'I',
    'Ï' => 'I',
    'Ò' => 'O',
    'Ó' => 'O',
    'Ô' => 'O',
    'Õ' => 'O',
    'Ö' => 'O',
    'Ù' => 'U',
    'Ú' => 'U',
    'Û' => 'U',
    'Ü' => 'U',
    'Ñ' => 'N'
]);
$name_url = strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', $name_new));
$old = $_POST['old-name'] ?? ''; // Corrigido para refletir o novo name no formulário

// Validação
// Required fields and messages based on your variables
$requiredFields = [
    'name-category'     => 'PREENCHA O CAMPO NOME!',
    'categorie'         => 'SELECIONE A CATEGORIA!',
    'sub_categorie'     => 'SELECIONE A SUBCATEGORIA!',
    'description'       => 'PREENCHA A DESCRIÇÃO CURTA!',
    'description_long'  => 'PREENCHA A DESCRIÇÃO LONGA!',
    'value'             => 'PREENCHA O VALOR!',
    'stock'             => 'PREENCHA O ESTOQUE!',
    'shipping_type'     => 'SELECIONE O TIPO DE ENVIO!',
    'enable'            => 'SELECIONE SE O PRODUTO ESTÁ ATIVO!',
    'word'              => 'PREENCHA AS PALAVRAS-CHAVE!',
    'weight'            => 'PREENCHA O PESO!',
    'width'             => 'PREENCHA A LARGURA!',
    'height'            => 'PREENCHA A ALTURA!',
    'model'             => 'PREENCHA O MODELO!',
    'shipping-value'    => 'PREENCHA O VALOR DO FRETE!'
];

// Dynamic validation
foreach ($requiredFields as $field => $message) {
    $value = $_POST[$field] ?? '';
    if (trim($value) === '') {
        echo $message;
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
        $newImageName = uniqid() . '.' . $ext;
        $path = __DIR__ . "/../../../../assets/img/products/" . $newImageName;

        if (!move_uploaded_file($image_time, $path)) {
            echo 'Erro ao salvar a imagem!';
            exit();
        }

        $hasNewImage = 1; // marca que temos imagem nova válida

    } else {
        echo 'Extensão de Imagem não permitida!';
        exit();
    }
}

// Atualizar ou inserir na tabela correta: sub_categories
// NORMALIZAÇÕES (opcional, caso venha com vírgula)
$priceDB          = str_replace(',', '.', $value);
$shippingValueDB  = str_replace(',', '.', $shipping_value);

// length não está no form; deixa nulo/zero conforme sua regra
$length = $_POST['length'] ?? null;

// UPDATE ou INSERT em products
// Atualiza a coluna 'image' somente quando foi feito upload novo.
// THEN :image ELSE image END,             
// Se :has_new_image = 0, o valor antigo é preservado. */   
if (!empty($id2)) {
    $stmt = $pdo->prepare("
        UPDATE products SET
            categorie        = :categorie,
            sub_categorie    = :sub_categorie,
            name             = :name,
            name_url         = :name_url,
            description      = :description,
            description_long = :description_long,
            value            = :value,
            image = CASE WHEN :has_new_image = 1 THEN :image ELSE image END,
            stock            = :stock,
            shipping_type    = :shipping_type,
            words            = :words,
            enable           = :enable,
            weight           = :weight,
            width            = :width,
            height           = :height,
            length           = :length,
            model            = :model,
            shipping_value   = :shipping_value
        WHERE id = :id
    ");
    $stmt->bindValue(':id', $id2, PDO::PARAM_INT);
} else {
    $stmt = $pdo->prepare("
        INSERT INTO products (
            categorie, sub_categorie, name, name_url, description, description_long,
            value, image, stock, shipping_type, words, enable,
            weight, width, height, length, model, shipping_value
        ) VALUES (
            :categorie, :sub_categorie, :name, :name_url, :description, :description_long,
            :value, :image, :stock, :shipping_type, :words, :enable,
            :weight, :width, :height, :length, :model, :shipping_value
        )
    ");
}

// BINDS (mesma ordem/nomes do schema)
$stmt->bindValue(':categorie',        $id_categorie);
$stmt->bindValue(':sub_categorie',    $id_sub_categorie);
$stmt->bindValue(':name',             $name);
$stmt->bindValue(':name_url',         $name_url);            // certifique-se de preencher $name_url
$stmt->bindValue(':description',      $description);
$stmt->bindValue(':description_long', $description_long);
$stmt->bindValue(':value',            $priceDB);     // caminho/nome do arquivo salvo
$stmt->bindValue(':stock',            $stock);
$stmt->bindValue(':shipping_type',    $shipping_type);
$stmt->bindValue(':words',            $word);
$stmt->bindValue(':enable',           $enable);
$stmt->bindValue(':weight',           $weight);
$stmt->bindValue(':width',            $width);
$stmt->bindValue(':height',           $height);
$stmt->bindValue(':length',           $length);
$stmt->bindValue(':model',            $model);
$stmt->bindValue(':shipping_value',   $shippingValueDB);

// ----- Binds extras para a lógica de imagem -----
// :has_new_image  -> 0 ou 1 indicando se houve upload de nova foto
// :image -> nome do novo arquivo se houve upload;
//caso contrário mantém o nome atual do banco
if (!empty($id2)) { // UPDATE
    $stmt->bindValue(':has_new_image', $hasNewImage, PDO::PARAM_INT);
    $stmt->bindValue(':image', $hasNewImage ? $newImageName : ($currentImageDB ?: 'no-photo.jpg'));
} else {            // INSERT
    $stmt->bindValue(':image', $hasNewImage ? $newImageName : 'no-photo.jpg');
}

try {
    $stmt->execute();
    echo "SALVO COM SUCESSO!!";
} catch (PDOException $e) {
    echo "ERRO AO SALVAR: " . $e->getMessage();
}
