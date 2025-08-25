<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content">
        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>
            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Nav Item - User Information -->
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="user-name mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $userName ?></span>
                        <img class="img-profile rounded-circle" src="/store/system/panel-admin/img/no-image.jpg"
                            alt="Image profile">
                    </a>
                    <!-- Dropdown - User Information -->
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="" data-toggle="modal" data-target="#ModalProfile">
                            <i class="fas fa-user fa-sm fa-fw mr-2 text-primary"></i>
                            Editar Perfil
                        </a>

                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="../logout.php">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-danger"></i>
                            Sair
                        </a>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->

        <!-- Container Fluido -->
        <div class="container-fluid">

            <?php if ($pag == null) {
                include_once("home.php");
            } else if ($pag == $menu1) {
                include_once($menu1 . ".php");
            } else if ($pag == $menu2) {
                include_once($menu2 . ".php");
            } else if ($pag == $menu3) {
                include_once($menu3 . ".php");
            } else if ($pag == $menu4) {
                include_once($menu4 . ".php");
            } else if ($pag == $menu5) {
                include_once($menu5 . ".php");
            } else if ($pag == $menu6) {
                include_once($menu6 . ".php");
            } else if ($pag == $menu7) {
                include_once($menu7 . ".php");
            } else if ($pag == $menu8) {
                include_once($menu8 . ".php");
            } else if ($pag == $menu9) {
                include_once($menu9 . ".php");
            } else {
                include_once("home.php");
            }
            ?>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- End of Main Content -->
</div>
<!-- End of Content Wrapper -->
</div>
<!-- End of Page Wrapper -->
<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>
<!--  Modal Perfil-->
<div class="modal fade" id="ModalProfile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Perfil</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="form-profile" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nome</label>
                        <input
                            value="<?php echo isset($userName) ? htmlspecialchars($userName) : ''; ?>"
                            type="text"
                            class="form-control"
                            id="name_user"
                            name="name_user"
                            placeholder="Nome">
                    </div>
                    <div class="form-group">
                        <label>CPF</label>
                        <input
                            value="<?php echo isset($userCpf) ? htmlspecialchars($userCpf) : ''; ?>"
                            type="text"
                            class="form-control"
                            id="cpf_user"
                            name="cpf_user"
                            placeholder="CPF">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input
                            value="<?php echo isset($userEmail) ? htmlspecialchars($userEmail) : ''; ?>"
                            type="email"
                            class="form-control"
                            id="email_user"
                            name="email_user"
                            placeholder="Email">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Senha</label>
                                <input
                                    type="password"
                                    class="form-control"
                                    id="password"
                                    name="password"
                                    placeholder="Senha"
                                    autocomplete="current-password">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Confirmar Senha</label>
                                <input
                                    type="password"
                                    class="form-control"
                                    id="confirm-password"
                                    name="confirm_password"
                                    placeholder="Confirmar Senha">
                            </div>
                        </div>
                    </div>
                    <small>
                        <div id="message-profile" class="mr-4"></div>
                    </small>
                </div>
                <div class="modal-footer">
                    <input
                        value="<?php echo isset($_SESSION['id_user']) ? htmlspecialchars($_SESSION['id_user']) : ''; ?>"
                        type="hidden"
                        name="txtid"
                        id="txtid">
                    <input
                        value="<?php echo isset($_SESSION['cpf_user']) ? htmlspecialchars($_SESSION['cpf_user']) : ''; ?>"
                        type="hidden"
                        name="old"
                        id="old">
                    <button
                        type="button"
                        id="btn-closed-profile"
                        class="btn btn-secondary"
                        data-dismiss="modal">Cancelar</button>
                    <button
                        type="submit"
                        name="btn-save-profile"
                        id="btn-save-profile"
                        class="btn btn-primary">Salvar</button>
                </div>
            </form>

        </div>
    </div>
</div>
<script src="/store/system/panel-admin/assets/vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script src="/store/system/panel-admin/assets/js/sb-admin-2.min.js"></script>
<script src="/store/system/panel-admin/assets/vendor/chart.js/Chart.min.js"></script>
<script src="/store/system/panel-admin/assets/js/demo/chart-area-demo.js"></script>
<script src="/store/system/panel-admin/assets/js/demo/chart-pie-demo.js"></script>
<script src="/store/system/panel-admin/assets/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="/store/system/panel-admin/assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="/store/system/panel-admin/assets/js/demo/datatables-demo.js"></script>

<script>
    $(document).ready(function() {
        $('#cpf_user').mask('000.000.000-00');
    });
</script>
<script>
    $('#btn-save-profile').click(function(event) {
        event.preventDefault();

        $('#message-profile')
            .removeClass('text-danger text-success text-warning text-primary')
            .css('font-weight', 'bold')
            .addClass('text-primary')
            .text('Enviando...');

        $('#name, #email, #phone, #message').removeClass('is-invalid');
        $.ajax({
            url: "/store/system/panel-admin/edited-profile.php",
            method: "post",
            data: $('#form-profile').serialize(),
            dataType: "text",
            success: function(msg) {
                const message = msg.trim();
                $('#message-profile').removeClass('text-primary');

                if (message === 'SALVO COM SUCESSO!') {
                    $('#message-profile')
                        .addClass('text-success')
                        .css('font-weight', 'bold')
                        .text(message);

                    // Atualiza o nome na tela
                    $('.user-name').text($('#form-profile input[name="name_user"]').val());
                    // Variavel que ao enviar a mensagem salvo com sucesso ela atualiza o nome de usuário no input
                    var newName = $('#form-profile input[name="name_user"]').val();
                    // Chama no campo do formulário no input id name e chamando a variavel no php name_user
                    $('.user-name').text(newName);
                    $('#form-profile input[name="name_user"]').val(newName);

                    setTimeout(function() {
                        $('#message-profile').text('');
                        $('#btn-closed-profile').click();
                    }, 1500);

                } else {
                    $('#message-profile')
                        .addClass('text-danger')
                        .css('font-weight', 'bold')
                        .text(message);
                }
            }
        });

    });

    // Ao abrir o modal → limpa a mensagem e sincroniza com o nome da navbar
    $('#ModalProfile').on('show.bs.modal', function() {
        $('#message-profile').text('');
        $('#name_user').val($('.user-name').text().trim());
    });
</script>

</body>

</html>