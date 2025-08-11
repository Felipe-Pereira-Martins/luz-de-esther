<?php 
require_once("../config/connection.php");

// Captura o e-mail do AJAX
$email = trim($_POST['email'] ?? '');

// Validação simples
if ($email == "") {
    echo "PREENCHA O CAMPO EMAIL!";
    exit();
}

// Consulta no banco de dados
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
$stmt->bindValue(":email", $email);
$stmt->execute();

// Traz o usuário
$data = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if user data was found (i.e., email exists in database)
if ($data) {

    // Get the user's password
    $password = $data['password'];

    // Set email details
    $recipient = $email; // Email entered by the user
    $subject   = $name_store . ' - Recuperação de Senha! ';
    $name = $data['name'] ?? 'Usuário';

    // Compose the email message (optional fields for testing)
    $message  = "Name: $name\r\n";
    $message .= "Phone: $phone_number\r\n\r\n";
    $message .= "Message:\r\n$message";

    // Email headers (sender)
    $headers = "From: $email_shop\r\n";

    // Send the email (only works if server is configured properly)
    $sent = mail($recipient, $subject, $message, $headers);

    // Show the password on screen (for local testing only)
    echo "SENHA ENVIADA PARA O EMAIL";

} else {
    // If email is not found in the database
    echo "O EMAIL NÃO ESTÁ CADASTRADO";
}   

?>
