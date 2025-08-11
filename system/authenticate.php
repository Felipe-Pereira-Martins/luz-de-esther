<?php 
require_once("../config/connection.php");
session_start(); //Recuperar dados de sessão de usuárioi

$email = $_POST['email'] ?? '';
$password =  md5($_POST['password'] ?? '');

$res = $pdo->query("SELECT * FROM users where email = '$email' and password_cript = '$password'");
$data = $res->fetchAll(PDO::FETCH_ASSOC); // Recebe o retorno da consulta que foi feita
 
if (count($data) > 0) {
    $_SESSION['id_user'] = $data[0]['id'];
    $_SESSION['name_user'] = $data[0]['name']; // Extrai o dado no caso o nome na primeira coluna
    $_SESSION['email_user'] = $data[0]['email']; 
    $_SESSION['cpf_user'] = $data[0]['cpf']; 
    $_SESSION['level_user'] = $data[0]['level']; 
    
    if($_SESSION['level_user'] == 'Admin'){ // Logado com ADMIN //PAINEL ADMIN
        echo "<script language='javascript'> window.location='panel-admin'</script>"; //Está redirecionando para o painelç do admin
    }

    if($_SESSION['level_user'] == 'Client'){ // Logado com CLIENT  //PAINEL CLIENTE
        echo "<script language='javascript'> window.location='panel-admin'</script>";
    }

}else {  //REDIRECIONA PARA O INDEX.PHP
    echo "<script language='javascript'> window.alert('DADOS INCORRETOS')</script>";
    echo "<script language='javascript'> window.location='index.php'</script>";
}

?>


