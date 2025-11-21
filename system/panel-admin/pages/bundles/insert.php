<?php
// Configuração para não exibir erros na tela (em produção)
ini_set('display_errors', 0);
error_reporting(E_ALL ^ E_WARNING);

// Inclui a conexão com o banco de dados
require_once("../../../../config/connection.php");

// =============================================
// CAPTURA DOS DADOS DO FORMULÁRIO
// =============================================
$name = $_POST['name-category'] ?? '';
$description = $_POST['description'] ?? '';
$description_long = $_POST['description_long'] ?? '';
$value = $_POST['value'] ?? '';
$shipping_type = $_POST['shipping_type'] ?? '';
$enable = $_POST['enable'] ?? '';
$word = $_POST['word'] ?? '';
$weight = $_POST['weight'] ?? '';
$width = $_POST['width'] ?? '';
$height = $_POST['height'] ?? '';
$shipping_value = $_POST['shipping_value'] ?? '';
$length = $_POST['length'] ?? '';
$id2 = $_POST['txtid2'] ?? ''; // ID para edição (vazio se for novo)

// =============================================
// CONTROLE DE IMAGEM - UPLOAD E EDIÇÃO
// =============================================
$hasNewImage   = 0;     // Flag: 1 se há nova imagem, 0 se não
$newImageName  = null;  // Nome do novo arquivo de imagem
$currentImageDB = null; // Imagem atual no banco (para edição)

// Se estiver editando, busca a imagem atual do banco
if (!empty($id2)) {
    $stmtCur = $pdo->prepare("SELECT image FROM bundles WHERE id = :id");
    $stmtCur->execute([':id' => $id2]);
    $currentImageDB = $stmtCur->fetchColumn() ?: 'no-photo.jpg';
}

// =============================================
// FORMATAÇÃO DE VALORES NUMÉRICOS
// =============================================
// Converte vírgula para ponto (formato brasileiro para internacional)
$value = str_replace(',', '.', $value);
$shipping_value = str_replace(',', '.', $shipping_value);
$weight = str_replace(',', '.', $weight);
$width = str_replace(',', '.', $width);
$height = str_replace(',', '.', $height);
$length = str_replace(',', '.', $length);

// =============================================
// GERAR SLUG (URL AMIGÁVEL) DO NOME
// =============================================
// Remove acentos e caracteres especiais
$name_new = strtr(trim($name), [
    'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a',
    'ç' => 'c',
    'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e',
    'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
    'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o',
    'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u',
    'ñ' => 'n',
    'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A',
    'Ç' => 'C',
    'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E',
    'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',
    'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O',
    'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U',
    'Ñ' => 'N'
]);
// Converte para minúsculas e substitui espaços por hífens
$name_url = strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', $name_new));
$old = $_POST['old-name'] ?? ''; // Nome antigo (para possíveis comparações)

// =============================================
// VALIDAÇÃO DE CAMPOS OBRIGATÓRIOS - CORRIGIDO
// =============================================
$requiredFields = [
    'name-category'     => 'PREENCHA O CAMPO NOME!',
    'description'       => 'PREENCHA A DESCRIÇÃO CURTA!',
    'description_long'  => 'PREENCHA A DESCRIÇÃO LONGA!',
    'value'             => 'PREENCHA O VALOR!',
    'shipping_type'     => 'SELECIONE O TIPO DE ENVIO!',
    'enable'            => 'SELECIONE SE O PRODUTO ESTÁ ATIVO!',
    'word'              => 'PREENCHA AS PALAVRAS-CHAVE!',
    'weight'            => 'PREENCHA O PESO!',
    'width'             => 'PREENCHA A LARGURA!',
    'height'            => 'PREENCHA A ALTURA!',
    'length'            => 'PREENCHA O COMPRIMENTO!',
    'shipping_value'    => 'PREENCHA O VALOR DO FRETE!'
]; 

// Verifica cada campo obrigatório - USANDO VARIÁVEL DIFERENTE
foreach ($requiredFields as $field => $message) {
    $fieldValue = $_POST[$field] ?? ''; // ⭐ Mudei para $fieldValue
    if (trim($fieldValue) === '') {
        echo $message;
        exit();
    }
}
// =============================================
// PROCESSAMENTO DE UPLOAD DE IMAGEM
// =============================================
if (!empty($_FILES['image']['name'])) {
    $imagem = $_FILES['image']['name'];
    $image_time = $_FILES['image']['tmp_name'];
    $ext = strtolower(pathinfo($imagem, PATHINFO_EXTENSION));

    // Tipos de arquivo permitidos
    $allowed = ['png', 'jpg', 'jpeg', 'gif'];
    if (in_array($ext, $allowed)) {
        // Gera nome único para evitar sobrescrita
        $newImageName = uniqid() . '.' . $ext;
        $path = __DIR__ . "/../../../../assets/img/bundles/" . $newImageName;

        // Move o arquivo para o diretório destino
        if (!move_uploaded_file($image_time, $path)) {
            echo 'Erro ao salvar a imagem!';
            exit();
        }

        $hasNewImage = 1; // Marca que upload foi bem sucedido

    } else {
        echo 'Extensão de Imagem não permitida!';
        exit();
    }
}

// =============================================
// PREPARAÇÃO DOS DADOS PARA O BANCO
// =============================================
// Garante formatação correta dos valores decimais
$priceDB          = str_replace(',', '.', $value);
$shippingValueDB  = str_replace(',', '.', $shipping_value);

// =============================================
// QUERY DE UPDATE OU INSERT
// =============================================
if (!empty($id2)) {
    // UPDATE: Atualiza registro existente
    $stmt = $pdo->prepare("
        UPDATE bundles SET
            name             = :name,
            name_url         = :name_url,
            description      = :description,
            description_long = :description_long,
            value            = :value,
            image = CASE WHEN :has_new_image = 1 THEN :image ELSE image END,
            shipping_type    = :shipping_type,
            words            = :words,
            enable           = :enable,
            weight           = :weight,
            width            = :width,
            height           = :height,
            length           = :length,
            shipping_value   = :shipping_value
        WHERE id = :id
    ");
    $stmt->bindValue(':id', $id2, PDO::PARAM_INT);
} else {
    // INSERT: Cria novo registro
    $stmt = $pdo->prepare("
        INSERT INTO bundles (
         name, name_url, description, description_long,
            value, image, shipping_type, words, enable,
            weight, width, height, length, shipping_value
        ) VALUES (
            :name, :name_url, :description, :description_long,
            :value, :image, :shipping_type, :words, :enable,
            :weight, :width, :height, :length, :shipping_value
        )
    ");
}

// =============================================
// VINCULAÇÃO DOS PARÂMETROS (BIND VALUES)
// =============================================
$stmt->bindValue(':name',             $name);
$stmt->bindValue(':name_url',         $name_url);           
$stmt->bindValue(':description',      $description);
$stmt->bindValue(':description_long', $description_long);
$stmt->bindValue(':value',            $priceDB);   
$stmt->bindValue(':shipping_type',    $shipping_type);
$stmt->bindValue(':words',            $word);
$stmt->bindValue(':enable',           $enable);
$stmt->bindValue(':weight',           $weight);
$stmt->bindValue(':width',            $width);
$stmt->bindValue(':height',           $height);
$stmt->bindValue(':length',           $length);
$stmt->bindValue(':shipping_value',   $shippingValueDB);

// =============================================
// LÓGICA ESPECÍFICA PARA IMAGEM
// =============================================
if (!empty($id2)) { 
    // UPDATE: Mantém imagem atual ou usa nova
    $stmt->bindValue(':has_new_image', $hasNewImage, PDO::PARAM_INT);
    $stmt->bindValue(':image', $hasNewImage ? $newImageName : ($currentImageDB ?: 'no-photo.jpg'));
} else {            
    // INSERT: Usa nova imagem ou imagem padrão
    $stmt->bindValue(':image', $hasNewImage ? $newImageName : 'no-photo.jpg');
}

// =============================================
// EXECUÇÃO E TRATAMENTO DE RESULTADO
// =============================================
try {
    $stmt->execute();
    echo "SALVO COM SUCESSO!!";
} catch (PDOException $e) {
    echo "ERRO AO SALVAR: " . $e->getMessage();
}