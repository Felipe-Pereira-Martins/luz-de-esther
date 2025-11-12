<?php
$pag = $_GET['pag'] ?? 'shipping-type';
require_once(realpath(__DIR__ . '/../../../config/config.php'));
// ✅ Verificação de autenticação e autorização
// Garante que apenas usuários autenticados com nível 'Admin' possam acessar esta página.
if (!isset($_SESSION['id_user']) || $_SESSION['level_user'] !== 'Admin') {
    // ✅ Redireciona para página inicial se não estiver autenticado ou não for admin
    header("Location: ../index.php");
    exit;
}
?>

<!-- HTML e BootStrap da página -->
<div class="row mt-4 mb-4">
    <a type="button" class="btn-primary btn-sm ml-3 d-none d-md-block" href="index.php?pag=<?php echo $pag ?>&function=new">Nova Característica</a>
    <a type="button" class="btn-primary btn-sm ml-3 d-block d-sm-none" href="index.php?pag=<?php echo $pag ?>&function=new">+</a>
</div> <!-- A function new chama uma modal e tem 2, pelo motivo de um deles ser oculto, recebe o + -->
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = $pdo->query("SELECT * FROM feature order by id desc ");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);
                    for ($i = 0; $i < count($res); $i++) {
                        foreach ($res[$i] as $key => $value) {
                        }
                        $name = $res[$i]['name'] ?? '';
                        $id = $res[$i]['id'] ?? '';

                    ?>
                        <tr>
                            <td><?php echo $name ?></td>
                            <td>
                                <a href="index.php?pag=<?php echo $pag ?>&function=edit&id=<?php echo $id ?>" class='text-primary mr-1' title='Editar Dados'><i class='far fa-edit'></i></a>
                                <a href="index.php?pag=<?php echo $pag ?>&function=deleted&id=<?php echo $id ?>" class='text-danger mr-1' title='Excluir Registro'><i class='far fa-trash-alt'></i></a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalData" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <?php
                // Inicializa variáveis para evitar warnings
                $name2 = '';
                $id2 = '';
                $title = "Inserir Registro";

                // Só preenche se for edição
                if (isset($_GET['function']) && $_GET['function'] === 'edit') {
                    $title = "Editar Registro";
                    $id2 = $_GET['id'] ?? '';
                    $query = $pdo->query("SELECT * FROM feature WHERE id = '$id2'");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);
                    if (!empty($res)) {
                        $name2 = $res[0]['name'] ?? '';
                    }
                }
                ?>
                <h5 class="modal-title" id="exampleModalLabel"><?php echo $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nome</label>
                        <input value="<?php echo $name2 ?>" type="text" class="form-control" id="name-category" name="name-category" placeholder="Nome">
                    </div>
                    <small>
                        <div id="message">
                        </div>
                    </small>
                </div>
                <div class="modal-footer">
                    <input value="<?php echo $_GET['id'] ?? '' ?>" type="hidden" name="txtid2" id="txtid2">
                    <input value="<?php echo $name2 ?>" type="hidden" name="old-name" id="old-name">
                    <button type="button" id="btn-closed" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" name="btn-save" id="btn-save" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal" id="modal-delete" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Excluir Registro</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Deseja realmente Excluir este Registro?</p>
                <div align="center" id="message_delete" class="">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btn-cancel-delete">Cancelar</button>
                <form method="post" id="form-delete">
                    <input type="hidden" id="id" name="id" value="<?php echo $_GET['id'] ?>" required>
                    <button type="button" id="btn-delete" name="btn-delete" class="btn btn-danger">Excluir</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php if (isset($_GET["function"]) && $_GET["function"] == "new") {
    echo "<script>$('#modalData').modal('show');</script>";
} ?>

<?php if (isset($_GET["function"]) && $_GET["function"] == "edit") {
    echo "<script>$('#modalData').modal('show');</script>";
} ?>

<?php if (isset($_GET["function"]) && $_GET["function"] == "deleted") {
    echo "<script>$('#modal-delete').modal('show');</script>";
} ?>


<!--SCRIPT PARA CARREGAR IMAGEM -->
<script type="text/javascript">
    function uploadImage() {
        var target = document.getElementById('target');
        var file = document.querySelector("input[type=file]").files[0];
        var reader = new FileReader();
        reader.onloadend = function() {
            target.src = reader.result;
        };
        if (file) {
            reader.readAsDataURL(file);
        } else {
            target.src = "";
        }
    }
</script>

<!-- SCRIPT PARA DESABILITAR A ORDENAÇÃO AUTOMÁTICA DA DATATABLE -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTable').dataTable({
            "ordering": false
        })
    });
</script>

<!--AJAX PARA INSERÇÃO DOS DADOS -->
<script type="text/javascript">
    $(document).ready(function() {
        var pag = "<?= $pag ?>";
        $('#btn-save').click(function(event) {
            event.preventDefault();
            var formData = new FormData($('#form')[0]); // coleta todos os campos, incluindo imagem
            $.ajax({
                url: "pages/" + pag + "/insert.php", // caminho do script PHP
                method: "POST",
                data: formData,
                dataType: "text",
                contentType: false,
                processData: false,
                cache: false,
                success: function(message) {
                    $('#message').removeClass();

                    if (message.trim() === "SALVO COM SUCESSO!!") {
                        $('#message').addClass('text-success').text(message);
                        $('#name-category').val('');
                        setTimeout(function() {
                            $('#btn-closed').click();
                            window.location = "index.php?pag=" + pag;
                        }, 1500);

                    } else {
                        $('#message').addClass('text-danger').text(message);
                    }
                },
                xhr: function() {
                    var myXhr = $.ajaxSettings.xhr();
                    if (myXhr.upload) {
                        myXhr.upload.addEventListener('progress', function() {
                            // progresso do upload (opcional)
                        }, false);
                    }
                    return myXhr;
                }
            });
        });
    });
</script>

<!-- AJAX PARA EXCLUSÃO DOS DADOS -->
<script type="text/javascript">
    $(document).ready(function() {
        var pag = "<?= $pag ?>";

        $('#btn-delete').click(function(event) {
            event.preventDefault();

            $.ajax({
                url: "pages/" + pag + "/deleted.php",
                method: "post",
                data: $('#form-delete').serialize(),
                dataType: "text",
                success: function(message) {
                    $('#message_delete').removeClass();

                    if (message.trim() === "SALVO COM SUCESSO!!") {
                        // Fecha a modal e recarrega imediatamente
                        $('#modal-delete').modal('hide');
                        window.location = "index.php?pag=" + pag;
                    } else {
                        $('#message_delete').addClass('text-danger').text(message);
                    }
                }
            });
        });
    });
</script>