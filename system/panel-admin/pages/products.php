<?php
$pag = $_GET['pag'] ?? 'products';
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
    <a type="button" class="btn-primary btn-sm ml-3 d-none d-md-block" href="index.php?pag=<?php echo $pag ?>&function=new">Novo Produto</a>
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
                        <th>Valor</th>
                        <th>Estoque</th>
                        <th>SubCategoria</th>
                        <th>Imagem</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = $pdo->query("SELECT * FROM products ORDER BY id DESC");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);

                    for ($i = 0; $i < count($res); $i++) {
                        $name = $res[$i]['name'] ?? '';
                        $value = $res[$i]['value'] ?? '';
                        $stock = $res[$i]['stock'] ?? '';
                        $sub_categorie = $res[$i]['sub_categorie'] ?? '';
                        $images = !empty($res[$i]['image']) ? $res[$i]['image'] : 'no-photo.jpg';
                        $enable = $res[$i]['enable '] ?? ''; // Irá ter um icone antes do nome para saber se o produto está ativo ou inativo
                        $id = $res[$i]['id'] ?? '';

                        // Recuperar o nome da categoria
                        $query2 = $pdo->query("SELECT * FROM sub_categories WHERE id = '$sub_categorie'");
                        $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                        if (!empty($res2)) {
                            $catName = $res2[0]['name'];
                        } else {
                            $catName = 'Categoria não encontrada';
                        }

                        $items = 0;
                    ?>
                        <tr>
                            <td><?php echo $name ?></td>
                            <td><?php echo $value ?></td>
                            <td><?php echo $stock ?></td>
                            <td><?php echo $catName ?></td>
                            <td><img src="../../../store/assets/img/products/ <?php echo $images ?>" alt="Imagem dos itens" width="50"></td>
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
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <?php
                $name2 = '';
                $image2 = '';
                $id2 = '';
                $value2 = '';
                $description2 = '';
                $description_long2 = '';
                $stock2 = '';
                $words2 = '';
                $weight2 = ''; 	
                $width2 = '';	
                $height2 = '';	
                $length2 = '';
                $title = "Inserir Registro";

                if (isset($_GET['function']) && $_GET['function'] === 'edit') {
                    $title = "Editar Registro";
                    $id2 = $_GET['id'] ?? '';
                    $query = $pdo->query("SELECT * FROM products WHERE id = '$id2'");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);
                    if (!empty($res)) {
                        $name2 = $res[0]['name'] ?? '';
                        $image2 = $res[0]['image'] ?? '';
                        $sub_categorie2 = $res[0]['sub_categorie'] ?? '';
                        $value2 = $res[0]['value'] ?? '';
                        $stock2 = $res[0]['stocl'] ?? '';
                        $description2 = $res[0]['description'] ?? '';
                        $description_long2 = $res[0]['description_long'] ?? '';
                        $shipping_type2 = $res[0]['shipping_type'] ?? '';
                        $words2 = $res[0]['word'] ?? '';
                        $enable2 = $res[0]['enable'] ?? '';
                        $weight2 = $res[0]['weight'] ?? '';
                        $width2 = $res[0]['width'] ?? '';
                        $height2 = $res[0]['height'] ?? '';
                        $length2 = $res[0]['length'] ?? '';
                        $model2 = $res[0]['model'] ?? '';
                        $shipping_value2 = $res[0]['shipping_value'] ?? '';
                        $name_categorie2 = $res[0]['categorie'] ?? '';
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
                    <!-- Linha 1: Nome, Categoria, Subcategoria, Valor -->
                    <div class="row">
                        <!-- Nome -->
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="form-group">
                                <label>Nome</label>
                                <input value="<?php echo $name2 ?>" type="text" class="form-control form-control-sm" id="name-category" name="name-category" placeholder="Nome">
                            </div>
                        </div>

                        <!-- Categoria -->
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="form-group">
                                <label>Categoria</label>
                                <select class="form-control form-control-sm" name="categorie" id="categorie">
                                    <?php
                                    if (isset($_GET['function']) && $_GET['function'] === 'edit') {
                                        $query = $pdo->query("SELECT * FROM categories WHERE id = '$name_categorie2'");
                                        $res = $query->fetchAll(PDO::FETCH_ASSOC);
                                        if (!empty($res)) {
                                            $nameCategorie = $res[0]['name'];
                                            echo "<option value='" . $sub_categorie2 . "'>" . $nameCategorie . "</option>";
                                        }
                                    }
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
                                <input type="hidden" id="txtCategorie" name="txtCategorie">
                            </div>
                        </div>

                        <!-- Sub Categoria -->
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="form-group">
                                <label>Sub Categoria</label>
                                <span id="list-subcategorie"></span>
                            </div>
                        </div>

                        <!-- Valor -->
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="form-group">
                                <label>Valor</label>
                                <input value="<?php echo $value2 ?>" type="text" class="form-control form-control-sm" id="value" name="value" placeholder="Valor">
                            </div>
                        </div>

                        <!-- Descrição Curta -->
                        <div class="col-12 mb-3">
                            <div class="form-group">
                                <label>Descrição Curta <small>(500 caracteres)</small></label>
                                <textarea maxlength="500" class="form-control form-control-sm" id="description" name="description"><?php echo $description2 ?></textarea>
                            </div>
                        </div>

                        <div class="col-12 mb-3">
                            <div class="form-group">
                                <label>Descrição Longa</label>
                                <textarea class="form-control form-control-sm" id="$description_long" name="$description_long"><?php echo $description_long2 ?></textarea>
                            </div>
                        </div>

                        <!-- Estoque -->
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="form-group">
                                <label>Estoque</label>
                                <input value="<?php echo $stock2 ?>" type="text" class="form-control form-control-sm" id="stock" name="stock" placeholder="Quantidade">
                            </div>
                        </div>

                        <!-- Tipo Envio -->
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="form-group">
                                <label>Tipo Envio</label>
                                <select class="form-control form-control-sm" name="shipping_type" id="shipping_type">
                                    <?php
                                    if (isset($_GET['function']) && $_GET['function'] === 'edit') {
                                        $query = $pdo->query("SELECT * FROM shipping_type WHERE id = 'shipping_type2'");
                                        $res = $query->fetchAll(PDO::FETCH_ASSOC);
                                        if (!empty($res)) {
                                            $nameType = $res[0]['name'];
                                            echo "<option value='" . $shipping_type2 . "'>" . $nameType . "</option>";
                                        }
                                    }
                                    $query2 = $pdo->query("SELECT * FROM shipping_type ORDER BY name ASC");
                                    $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                                    for ($i = 0; $i < count($res2); $i++) {
                                        $idType = $res2[$i]['id'];
                                        $nameType = $res2[$i]['name'];
                                        if (!isset($shipping_type2) || $shipping_type2 != $idType) {
                                            echo "<option value='" . $idCat . "'>" . $nameType . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                        </div>

                        <!-- Ativo -->
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="form-group">
                                <label>Ativo</label>
                                <select class="form-control form-control-sm" name="shipping_type" id="shipping_type">
                                    <?php
                                    if (isset($_GET['function']) && $_GET['function'] == 'edit') {
                                        echo "<option value='" . $enable2 . "'>" . $enable2 . "</option>";
                                    }

                                    if ($enable2 != "SIM") {
                                        echo "<option value='Sim'>Sim</option>";
                                    }

                                    if ($enable2 != "NÃO") {
                                        echo "<option value='Não'>Não</option>";
                                    }
                                    ?>

                                </select>
                            </div>
                        </div>
                         <div class="col-lg-3 col-md-6 mb-3">
                            <div class="form-group">
                                <label>Palavras Chave</label>
                                <input value="<?php echo $words2 ?>" type="text" class="form-control form-control-sm" id="word" name="word" placeholder="Palavras Chave">
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="form-group">
                                <label>Peso</label>
                                <input value="<?php echo $weight2 ?>" type="text" class="form-control form-control-sm" id="weight" name="weight" placeholder="Peso">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="form-group">
                                <label>Largura</label>
                                <input value="<?php echo $widht2 ?>" type="text" class="form-control form-control-sm" id="width" name="width" placeholder="Largura">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="form-group">
                                <label>Altura</label>
                                <input value="<?php echo $height2 ?>" type="text" class="form-control form-control-sm" id="height" name="height" placeholder="Altura">
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="form-group">
                                <label>Comprimento</label>
                                <input value="<?php echo $length2 ?>" type="text" class="form-control form-control-sm" id="length" name="length" placeholder="Comprimento">
                            </div>
                        </div>


                    </div>

                    <!-- Linha 2: Imagem e Preview -->
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Imagem</label>
                                <input type="file" class="form-control-file" id="image" name="image" onchange="uploadImage();">
                            </div>

                            <div class="form-group mt-2">
                                <?php if (!empty($image2)) { ?>
                                    <img src="../../../store/assets/img/products/<?php echo $image2 ?>" alt="Imagem do produto" width="100" id="target">
                                <?php } else { ?>
                                    <img src="../../assets/img/sub-categories/no-photo.jpg" alt="Sem imagem" width="100" id="target">
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                    <small>
                        <div id="message"></div>
                    </small>

                </div> <!-- Fecha modal-body -->

                <div class="modal-footer">
                    <input value="<?php echo $_GET['id'] ?? '' ?>" type="hidden" name="txtid2" id="txtid2">
                    <input value="<?php echo $name2 ?>" type="hidden" name="old-name" id="old-name">
                    <input type="hidden" name="old-image" value="<?php echo $image2 ?>">
                    <button type="button" id="btn-closed" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" name="btn-save" id="btn-save" class="btn btn-primary">Salvar</button>
                </div>
            </form>

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

            <!--AJAX PARA LISTAR OS DADOS DA SUB CATEGORIA NO SELECT -->
            <script type="text/javascript">
                $(document).ready(function() {
                    document.getElementById('txtCategorie').value = document.getElementById('categorie').value;
                    listSubCategorie();
                })
            </script>

            <script type="text/javascript">
                function listSubCategorie() {
                    var pag = "<?= $pag ?>";
                    $.ajax({
                        url: "pages/" + pag + "/list-subcategorie.php",
                        method: "post",
                        data: $('form').serialize(),
                        dataType: "html",
                        success: function(result) {
                            $('#list-subcategorie').html(result); /* Div onde vai trazer a informação */
                        }
                    })
                }
            </script>

            <!-- Script para buscar pelo select -->
            <script type="text/javascript">
                $('#categorie').change(function() {
                    document.getElementById('txtCategorie').value = $(this).val();
                    listSubCategorie();
                })
            </script>

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