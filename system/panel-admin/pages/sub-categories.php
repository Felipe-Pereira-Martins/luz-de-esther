<?php
$pag = $_GET['pag'] ?? 'sub-categories';
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
    <a type="button" class="btn-primary btn-sm ml-3 d-none d-md-block" href="index.php?pag=<?php echo $pag ?>&function=new">Nova Sub-Categoria</a>
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
                        <th>Produtos</th>
                        <th>Categoria</th>
                        <th>Imagem</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = $pdo->query("SELECT * FROM sub_categories ORDER BY id DESC");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);

                    for ($i = 0; $i < count($res); $i++) {
                        $name = $res[$i]['name'] ?? '';
                        $images = !empty($res[$i]['image']) ? $res[$i]['image'] : 'no-photo.jpg';
                        $categorie = $res[$i]['id_categories'] ?? '';
                        $id = $res[$i]['id'] ?? '';

                        // Recuperar o nome da categoria
                        $query2 = $pdo->query("SELECT * FROM categories WHERE id = '$categorie'");
                        $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                        if (!empty($res2)) {
                            $catName = $res2[0]['name'];
                        } else {
                            $catName = 'Categoria não encontrada';
                        }
                        // Trazer o total de itens
                        $query3 = $pdo->query("SELECT * FROM products where sub_categorie = '$id' ");
                        $res3 = $query3->fetchAll(PDO::FETCH_ASSOC);    
                        $items = count($res3); 
                        $items = 0;
                        ?>
                        <tr>
                            <td><?php echo $name ?></td>
                            <td><?php echo $items ?></td>
                            <td><?php echo $catName ?></td>
                            <td><img src="../../../store/assets/img/sub-categories/<?php echo $images ?>" alt="Imagem dos itens" width="50"></td>
                            <td>
                                <a href="index.php?pag=<?php echo $pag ?>&function=edit&id=<?php echo $id ?>" class='text-primary mr-1' title='Editar Dados'>
                                    <i class='far fa-edit'></i>
                                </a>
                                <a href="index.php?pag=<?php echo $pag ?>&function=deleted&id=<?php echo $id ?>" class='text-danger mr-1' title='Excluir Registro'>
                                    <i class='far fa-trash-alt'></i>
                                </a>
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
                $image2 = '';
                $id2 = '';
                $title = "Inserir Registro";

                // Só preenche se for edição
                if (isset($_GET['function']) && $_GET['function'] === 'edit') {
                    $title = "Editar Registro";
                    $id2 = $_GET['id'] ?? '';
                    $query = $pdo->query("SELECT * FROM sub_categories WHERE id = '$id2'");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);
                    if (!empty($res)) {
                        $name2 = $res[0]['name'] ?? '';
                        $image2 = $res[0]['image'] ?? '';
                        $categorie2 = $res[0]['id_categories'] ?? '';
                    } else {
                        $title = "Inserir Registro";
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
                        <input value="<?php echo $name2 ?>" type="text" class="form-control form-control-sm" id="name-category" name="name-category" placeholder="Nome">
                    </div>
                    <!-- Campo select -->
                    <div class="form-group">
                        <label>Categorias</label>
                        <select class="form-control form-control-sm" name="categorie" id="categorie">
                            <?php
                            // ⚠️ Gambiarra: mostrar categoria atual no topo se for edição
                            if (isset($_GET['function']) && $_GET['function'] === 'edit') {
                                $query = $pdo->query("SELECT * FROM categories WHERE id = '$categorie2'");
                                $res = $query->fetchAll(PDO::FETCH_ASSOC);
                                if (!empty($res)) {
                                    $nameCategorie = $res[0]['name']; /* Primeira linha do id que ele pega ele exibe */
                                    echo "<option value='" . $categorie2 . "'>" . $nameCategorie . "</option>";
                                }
                            }

                            // ⚠️ Gambiarra: listar todas as outras categorias (menos a já selecionada)
                            $query2 = $pdo->query("SELECT * FROM categories ORDER BY name ASC");
                            $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);

                            for ($i = 0; $i < count($res2); $i++) {
                                $idCat = $res2[$i]['id'];
                                $nameCat = $res2[$i]['name'];
                                if (!isset($categorie2) || $categorie2 != $idCat) {
                                    echo "<option value='" . $idCat . "'>" . $nameCat . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Imagem</label>
                        <input value="<?php echo $image2 ?>" type="file" class="form-control-file" id="image" name="image" onchange="uploadImage();">
                    </div>

                    <?php if (!empty($image2)) { ?>
                        <img src="../../assets/img/sub-categories/<?php echo $image2 ?>" alt="Imagem da categoria" width="200" id="target">
                    <?php } else { ?>
                        <img src="../../assets/img/sub-categories/no-photo.jpg" alt="Imagem padrão" width="200" id="target">
                    <?php } ?>

                    <small>
                        <div id="message">
                        </div>
                    </small>
                </div>
                <div class="modal-footer">
                    <input value="<?php echo $_GET['id'] ?? '' ?>" type="hidden" name="txtid2" id="txtid2">
                    <input value="<?php echo $name2 ?>" type="hidden" name="old-name" id="old-name">
                    <input type="hidden" name="old-image" value="<?php echo $image2 ?>">
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