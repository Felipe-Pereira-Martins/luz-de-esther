<?php
// Inicia a sessão se ainda não estiver iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Limpa todas as variáveis da sessão
$_SESSION = [];

// Se existir um cookie de sessão, remove-o de forma segura
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(), 
        '', 
        time() - 42000,
        $params["path"], 
        $params["domain"], 
        $params["secure"], 
        $params["httponly"]
    );
}

// Destrói a sessão
session_destroy();

// Redireciona e encerra o script
header("Location: index.php");
exit;
?>
