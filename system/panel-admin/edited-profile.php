<?php
require_once("../../config/connection.php");

$name_user = $_POST['name_user'];
$email_user = $_POST['email_user'];
$cpf_user = $_POST['cpf_user'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];
$password_cript = md5($_POST['password']);

// Modal Perfil
$old = $_POST['old'];
$id_user = $_POST['txtid'];

// Validações
if ($name_user == "") {
    echo 'PREENCHA O CAMPO NOME!';
    exit();
}
if ($email_user == "") {
    echo 'PREENCHA O CAMPO EMAIL!';
    exit();
}

if ($cpf_user == "") {
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

if ($password != $_POST['confirm_password']) {
    echo 'AS SENHAS NÃO COINCIDEM!';
    exit();
}

if ($cpf_user != $old) {
    $stmt = $pdo->prepare("SELECT id FROM users WHERE cpf = :cpf");
    $stmt->bindValue(":cpf", $cpf_user);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo "CPF JÁ CADASTRADO NO BANCO";
        exit();
    };
}

  $update = $pdo->prepare("UPDATE users 
                         SET name = :name, 
                             cpf = :cpf, 
                             email = :email, 
                             password = :password, 
                             password_cript = :password_cript
                         WHERE id = :id");

$update->bindValue(":name", $name_user);
$update->bindValue(":cpf", $cpf_user);
$update->bindValue(":email", $email_user);
$update->bindValue(":password", $password);
$update->bindValue(":password_cript", $password_cript);
$update->bindValue(":id", $id_user);

$update->execute();

echo "SALVO COM SUCESSO!";

?>
