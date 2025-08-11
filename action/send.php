<?php
// Configurações do projeto e conexão com o banco
require_once("../config/connection.php");

// Validações de campos obrigatórios
if (empty($_POST['name'])) {
    echo 'O campo Nome Completo não pode estar vazio. Por favor, informe seu nome completo.';
    exit();
}

if (empty($_POST['email'])) {
    echo 'O campo Email não pode estar vazio. Por favor, informe um endereço de e-mail válido.';
    exit();
}

if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    echo 'O email informado é inválido.';
    exit();
}

if (empty($_POST['phone'])) {
    echo 'O campo Whatsapp não pode estar vazio. Por favor, informe seu número de contato.';
    exit();
}

if (empty($_POST['message'])) {
    echo 'O campo Mensagem não pode estar vazio. Por favor, escreva sua mensagem ou dúvida.';
    exit();
}

// Variáveis do formulário
$name        = trim($_POST['name']);
$emailClient = trim($_POST['email']);
$phone       = trim($_POST['phone']);
$message     = trim($_POST['message']);

// Variáveis do sistema
$recipient = $email; // vem do config.php
$subject   = $name_store . ' - Email de Contato';
$body      = "Nome: $name\r\n";
$body     .= "Telefone: $phone\r\n\r\n";
$body     .= "Mensagem:\r\n$message";
$headers   = "From: $emailClient\r\n";

// Enviando e-mail
 $sent = mail($recipient, $subject, $body, $headers);

if (!$sent) {
    echo "Erro ao enviar o Formulário! O erro está ocorrendo devido à hospedagem não estar com a permissão de envio habilitada ou você está em um servidor local!";
    exit();
} 

// Verifica se o e-mail já está no banco
$stmt = $pdo->prepare("SELECT id FROM emails WHERE email = :email");
$stmt->bindValue(":email", $emailClient);
$stmt->execute();

if ($stmt->rowCount() === 0) {
    // Inserindo no banco
    $insert = $pdo->prepare("INSERT INTO emails (name, email, enable) VALUES (:name, :email, :enable)");
    $insert->bindValue(":name", $name);
    $insert->bindValue(":email", $emailClient);
    $insert->bindValue(":enable", "Yes");
    $insert->execute();
}

// Resposta final
echo "Enviado com Sucesso!";


?>