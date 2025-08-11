$('#btn-send-email').click(function (event) {
    event.preventDefault();

    // Resetando mensagens e estilos dos campos
    $('#div-message')
        .removeClass('text-danger text-success text-warning text-primary')
        .css('font-weight', 'bold')
        .addClass('text-primary')
        .text('Enviando...');

    // Remove classes de erro dos campos
    $('#name, #email, #phone, #message').removeClass('is-invalid');

    $.ajax({
        url: "../action/send.php",
        method: "post",
        data: $('#form-contact').serialize(),
        dataType: "text",
        success: function (msg) {
            const message = msg.trim();
            $('#div-message').removeClass('text-primary');

            // Validação bem-sucedida
            if (message === 'Enviado com Sucesso!') {
                $('#div-message')
                    .addClass('text-success')
                    .css('font-weight', 'bold')
                    .text(message);
                $('#form-contact')[0].reset();
            } 
            // Erros específicos nos campos
            else if (message.includes('Nome')) {
                $('#name').addClass('is-invalid');
                showError(message);
            } 
            else if (message.includes('Email')) {
                $('#email').addClass('is-invalid');
                showError(message);
            }
            else if (message.includes('Whatsapp')) {
                $('#phone').addClass('is-invalid');
                showError(message);
            }
            else if (message.includes('Mensagem')) {
                $('#message').addClass('is-invalid');
                showError(message);
            } 
            // Erro genérico
            else {
                $('#div-message')
                    .addClass('text-danger')
                    .css('font-weight', 'bold')
                    .text("Erro ao enviar o Formulário! O erro está ocorrendo devido à hospedagem não estar com a permissão de envio habilitada ou você está em um servidor local!");
            }
        }
    });

    function showError(msg) {
        $('#div-message')
            .addClass('text-danger')
            .css('font-weight', 'bold')
            .text(msg);
    }
});
