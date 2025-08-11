<?php
require_once("../config/connection.php");

// Recebendo os dados do formulário
$name = $_POST['name'] ?? '';
$email = $_POST['email_login'] ?? '';
$cpf = $_POST['cpf'] ?? '';
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

// Validações
if ($name == "") {
    echo 'PREENCHA O CAMPO NOME!';
    exit();
}

if ($email == "") {
    echo 'PREENCHA O CAMPO EMAIL!';
    exit();
}

if ($cpf == "") {
    echo 'PREENCHA O CAMPO CPF!';
    exit();
}

if ($password == "") {
    echo 'PREENCHA O CAMPO SENHA!';
    exit();
}

if ($confirm_password == "") {
    echo 'PREENCHA O CAMPO CONFIRMAR SENHA!';
    exit();
}

if ($password != $confirm_password) {
    echo 'AS SENHAS NÃO COINCIDEM!';
    exit();
}

// Verifica se o CPF já está cadastrado
$stmt = $pdo->prepare("SELECT id FROM users WHERE cpf = :cpf");
$stmt->bindValue(":cpf", $cpf);
$stmt->execute();

if ($stmt->rowCount() === 0) {
    // Criptografa a senha (recomendo trocar md5 por password_hash em produção)
    $password_cript = md5($password);
    $level = "Client";

    // Insere a tabela USERS
    $insert = $pdo->prepare("INSERT INTO users (name, cpf, email, password, password_cript, level) 
                             VALUES (:name, :cpf, :email, :password, :password_cript, :level)");
    $insert->bindValue(":name", $name);
    $insert->bindValue(":cpf", $cpf);
    $insert->bindValue(":email", $email);
    $insert->bindValue(":password", $password);
    $insert->bindValue(":password_cript", $password_cript);
    $insert->bindValue(":level", $level);
    $insert->execute();

    // Insere a tabela CLIENTS
    $insert = $pdo->prepare("INSERT INTO clients (name, cpf, email) 
                             VALUES (:name, :cpf, :email)");
    $insert->bindValue(":name", $name);
    $insert->bindValue(":cpf", $cpf);
    $insert->bindValue(":email", $email);
    $insert->execute();

    $stmt = $pdo->prepare("SELECT id FROM emails WHERE email = :email");
    $stmt->bindValue(":email", $email);
    $stmt->execute();

    if ($stmt->rowCount() === 0) {
    // Inserindo no banco
    $insert = $pdo->prepare("INSERT INTO emails (name, email, enable) VALUES (:name, :email, :enable)");
    $insert->bindValue(":name", $name);
    $insert->bindValue(":email", $email);
    $insert->bindValue(":enable", "Yes");
    $insert->execute();
}


    echo "Cadastrado com Sucesso!";
} else {
    echo "CPF JÁ CADASTRADO";
}
?>
