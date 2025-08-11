<?php
require_once("../config/connection.php");

// Verifica se há usuários
$res = $pdo->query("SELECT * FROM users");
$dados = $res->fetchAll(PDO::FETCH_ASSOC);
$password_cript = md5('7898#!use@@#');

if (count($dados) == 0) {
    $stmt = $pdo->prepare("INSERT INTO users (name, cpf, email, password, password_cript, level) 
                           VALUES (:name, :cpf, :email, :password, :password_cript, :level)");
    $stmt->bindValue(":name", "Administrator");
    $stmt->bindValue(":cpf", "000.000.000-00");
    $stmt->bindValue(":email", "user.luzdeesther@gmail.com");
    $stmt->bindValue(":password", '7898#!use@@#');
    $stmt->bindValue(":password_cript", $password_cript);
    $stmt->bindValue(":level", "Admin");
    $stmt->execute();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $name_store ?></title>
    <link rel="stylesheet" href="../assets/css/login.css" type="text/css">
    <link rel="shortcut icon" href="../assets/img/favicon.ico" type="image/x-icon">
    <link rel="icon" href="../assets/img/favicon.ico" type="image/x-icon">
</head>

<body>

<form action="authenticate.php" method="POST" class="main-form">
    <a href="../pages/index.php"><img src="../assets/img/logo/logo.png" alt="Logo da Loja"></a>

    <div class="container">
        <input id="email_login" type="email" name="email" required>
        <label>Email</label>
    </div>

    <div class="container">
        <input type="password" name="password" required>
        <label>Senha</label>
    </div>

    <button>Entrar</button>

    <a href="#" onclick="openModal('modal-register')">Criar conta</a>
    <a href="#" onclick="openModal('modal-recover')">Não Consegue Entrar</a>
</form>

<!-- Modal Criar Conta -->
<div class="modal" id="modal-register">
    <div class="modal-wrapper">
        <div class="modal-header">
            <h2>Criar Conta</h2>
            <span class="close" onclick="closeModal('modal-register')">&times;</span>
        </div>
        <div class="modal-content">
            <form method="post" id="form-register">
                <div class="form-group">
                    <label for="name">Nome completo</label>
                    <input type="text" id="name" name="name" placeholder="Digite seu nome" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email_register" name="email_login" placeholder="Digite seu email" required>
                </div>
                <div class="form-group">
                    <label for="cpf">CPF</label>
                    <input type="text" id="cpf" name="cpf" placeholder="Digite seu CPF" required>
                </div>
                <div class="form-group">
                    <label for="password">Senha</label>
                    <input type="password" id="password" name="password" placeholder="Crie uma senha" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirmar senha</label>
                    <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirme sua senha" required>
                </div>

                <small><div id="div-message"></div></small>
                <button type="button" id="btn-close-register" onclick="closeModal('modal-register')">Fechar</button>
                <button type="submit" id="btn-register">Cadastrar</button>
            </form>
        </div>
    </div>
</div>

<!-- Modal Recuperar Senha -->
<div class="modal" id="modal-recover">
    <div class="modal-wrapper">
        <div class="modal-header">
            <h2>Recuperar Senha</h2>
            <span class="close" onclick="closeModal('modal-recover')">&times;</span>
        </div>

        <small><div id="div-message-recover" style="text-align: center;"></div></small>

        <div class="modal-content recover">
            <form id="form-recover">
                <div class="form-group">
                    <label for="email_recover">Email</label>
                    <input type="email" id="email_recover" placeholder="Digite seu Email" required>
                </div>
                <button type="button" id="btn-recover" style="width: 100%;">Enviar link de recuperação</button>
            </form>
        </div>
    </div>
</div>


<!-- Scripts -->
<script src="../assets/js/modal.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
<script src="../assets/js/mask.js"></script>

<script type="text/javascript">
    $('#btn-register').click(function(event){
        event.preventDefault();

        const name = $('#name').val().trim();
        const email = $('#email_register').val().trim(); // Pega o e-mail do cadastro corretamente
        const cpf = $('#cpf').val().trim();
        const password = $('#password').val().trim();
        const confirmPassword = $('#confirm_password').val().trim();

        $('#div-message').removeClass('text-danger text-success');

       /*  if (!name || !email || !cpf || !password || !confirmPassword) {
            $('#div-message').addClass('text-danger').text('PREENCHA TODOS OS CAMPOS!');
            return;
        }

        if (password !== confirmPassword) {
            $('#div-message').addClass('text-danger').text('AS SENHAS NÃO COINCIDEM!');
            return;
        } */

        $.ajax({
            url: "../action/register.php",
            method: "post",
            data: $('#form-register').serialize(),
            dataType: "text",
            success: function(msg){
                const message = msg.trim();

                if (message === 'Cadastrado com Sucesso!') {
                    $('#div-message').addClass('text-success').text(message);

                    // Fecha a modal de registro
                    closeModal('modal-register');

                    // Preenche automaticamente o campo de login
                    $('#email_login').val(email);

                    // Limpa o formulário de cadastro
                    $('#form-register')[0].reset();
                } else {
                    $('#div-message').addClass('text-danger').text(message);
                }
            }
        });
    });

    $('#btn-close-register').click(function() {
        closeModal('modal-register');
        $('#form-register')[0].reset();
        $('#div-message').removeClass('text-danger text-success').text('');
    });
</script>

<script type="text/javascript">
// Recuperar Senha por Email
$('#btn-recover').click(function(event){
  event.preventDefault();

  const email = $('#email_recover').val().trim();

  // Limpa classes anteriores da div de mensagem
  $('#div-message-recover').removeClass('text-danger text-success');

  // Verifica se o campo email está vazio
  if (!email) {
    $('#div-message-recover').addClass('text-danger').text('PREENCHA O CAMPO EMAIL!');
    return;
  }

  // Requisição AJAX
  $.ajax({
    url: "../action/recover.php",
    method: "post",
    data: { email: email },
    dataType: "text",
    success: function(msg){
      const message = msg.trim();

      if (message === 'SENHA ENVIADA PARA O EMAIL') {
        $('#div-message-recover').addClass('text-success').text(message);
        $('#email_recover').val('');
      } else if (message === 'PREENCHA O CAMPO EMAIL!') {
        $('#div-message-recover').addClass('text-danger').text(message);
      } else if (message === 'O EMAIL NÃO ESTÁ CADASTRADO') {
        $('#div-message-recover').addClass('text-danger').text(message);
      } else {
        // Mensagem padrão para erro genérico ou servidor local
        $('#div-message-recover').addClass('text-danger').text('❌ Deu erro ao Enviar o Formulário! Provavelmente seu servidor de hospedagem não está com permissão de envio habilitada ou você está em um servidor local.');
      }
    }
  });
});
</script>

</body>
</html> 
  