<?php
$pag = $_GET['pag'] ?? 'bundles'; /* pega a tabela do banco de dados */
require_once(realpath(__DIR__ . '/../../../config/config.php'));
// Garante que apenas usuários autenticados com nível 'Admin' possam acessar esta página.
if (!isset($_SESSION['id_user']) || $_SESSION['level_user'] !== 'Admin') {
    // ✅ Redireciona para página inicial se não estiver autenticado ou não for admin
    header("Location: ../index.php");
    exit;
}
?>

<!-- HTML e BootStrap da página -->
<div class="row mt-4 mb-4">
    <a type="button" class="btn-primary btn-sm ml-3 d-none d-md-block" href="index.php?pag=<?php echo $pag ?>&function=new">Novo Combo</a>
    <a type="button" class="btn-primary btn-sm ml-3 d-block d-sm-none" href="index.php?pag=<?php echo $pag ?>&function=new">+</a>
</div>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Valor</th>
                        <th>Produtos</th>
                        <th>Imagem</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php /* Seleciona a tabela bundles que vem do banco de dados */
                    $query = $pdo->query("SELECT * FROM bundles ORDER BY id DESC");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);

                    /* Campos do datatables funcionando no PHP */
                    for ($i = 0; $i < count($res); $i++) {
                        $name = $res[$i]['name'] ?? '';
                        $value = $res[$i]['value'] ?? '';
                        $images = !empty($res[$i]['image']) ? $res[$i]['image'] : 'no-photo.jpg';
                        $enable = $res[$i]['enable'] ?? '';
                        $id = $res[$i]['id'] ?? '';
                        $value = number_format($value, 2, ',', '.');

                        /* Seleciona a tabela bundles que vem do banco de dados */
                        /* Explicação do que será feito, imagine o combo de 5 camisetas, a tabela products_bundles vai ter 5 registro relacionado ao combo,
                         no caso o combo é de id1, por ser o primeiro que criamos, vai passar e verficar que as 5 camisetas irão ter o id 1, quando ele passar 
                         vai retornar essa quantidade na váriavel $total_products  */
                        $query2 = $pdo->query("SELECT * FROM products_bundles where id_bundles = '$id'"); //Tabela que vai armazenar os produtos do combo
                        $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                        $total_products = count($res2); // Conta o total de produtos no combo
                        /* classe, se o produto tiver ativo fica verde se não fica vermelho */
                        $class = "";
                        if ($enable == "Sim") {
                            $class = "text-success";
                        } else {
                            $class = "text-danger";
                        }
                    ?>
                        <tr> <!-- Passa a função de característica e o ID -- Campo de Adiconar Característica -->
                            <td><i class="fas fa-check-circle <?= $class ?>"></i> <a href="index.php?pag=<?php echo $pag ?>&function=feature&id=<?= $id ?>" class="text-info"><?= $name ?></a></td>
                            <td>R$ <?php echo $value ?></td>
                            <td> <?php echo $total_products ?></td>
                            <td><img src="../../../store/assets/img/bundles/<?= $images ?>" alt="Imagem dos itens" width="50"></td>
                            <td>
                                <a href="index.php?pag=<?= $pag ?>&function=edit&id=<?= $id ?>" class='text-primary mr-1' title='Editar Dados'>
                                    <i class='far fa-edit'></i>
                                </a>
                                <a href="index.php?pag=<?= $pag ?>&function=deleted&id=<?= $id ?>" class='text-danger mr-1' title='Excluir Registro'>
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

<!-- Modal Principal -->
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
                $words2 = '';
                $weight2 = '';
                $width2 = '';
                $height2 = '';
                $length2 = '';
                $shipping_value2 = '';
                $title = "Inserir Registro";

                if (isset($_GET['function']) && $_GET['function'] === 'edit') {
                    $title = "Editar Registro";
                    $id2 = $_GET['id'] ?? '';
                    $query = $pdo->query("SELECT * FROM bundles WHERE id = '$id2'");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);
                    if (!empty($res)) {
                        $name2 = $res[0]['name'] ?? '';
                        $image2 = $res[0]['image'] ?? '';
                        $value2 = $res[0]['value'] ?? '';
                        $description2 = $res[0]['description'] ?? '';
                        $description_long2 = $res[0]['description_long'] ?? '';
                        $shipping_type2 = $res[0]['shipping_type'] ?? '';
                        $words2 = $res[0]['words'] ?? '';
                        $enable2 = $res[0]['enable'] ?? '';
                        $weight2 = $res[0]['weight'] ?? '';
                        $width2 = $res[0]['width'] ?? '';
                        $height2 = $res[0]['height'] ?? '';
                        $length2 = $res[0]['length'] ?? '';
                        $shipping_value2 = $res[0]['shipping_value'] ?? '';
                    }
                }
                ?>

                <h5 class="modal-title" id="exampleModalLabel"><?php echo $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="form-product" method="POST" enctype="multipart/form-data">
    <div class="modal-body">
        <!-- Linha 1: Nome, Valor, Tipo Envio, Ativo -->
        <div class="row">
            <!-- Nome -->
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="form-group">
                    <label>Nome</label>
                    <input value="<?php echo $name2 ?>" type="text" class="form-control form-control-sm" id="name-category" name="name-category" placeholder="Nome">
                </div>
            </div>

            <!-- Valor -->
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="form-group">
                    <label>Valor</label>
                    <input value="<?php echo $value2 ?>" type="text" class="form-control form-control-sm" id="value" name="value" placeholder="Valor">
                </div>
            </div>

            <!-- Tipo Envio -->
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="form-group">
                    <label>Tipo Envio</label>
                    <select class="form-control form-control-sm" name="shipping_type" id="shipping_type">
                        <?php
                        if (isset($_GET['function']) && $_GET['function'] === 'edit') {
                            $query = $pdo->query("SELECT * FROM shipping_type WHERE id = $shipping_type2");
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
                                echo "<option value='" . $idType . "'>" . $nameType . "</option>";
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
                    <?php
                    $enable2 = isset($enable2) ? trim($enable2) : '';
                    $e = mb_strtolower($enable2, 'UTF-8');
                    if ($e === 'sim')            $enable2 = 'Sim';
                    elseif ($e === 'não' || $e === 'nao') $enable2 = 'Não';
                    else                         $enable2 = 'Sim';
                    ?>
                    <select class="form-control form-control-sm" name="enable" id="enable">
                        <option value="Sim" <?= $enable2 === 'Sim' ? 'selected' : '' ?>>Sim</option>
                        <option value="Não" <?= $enable2 === 'Não' ? 'selected' : '' ?>>Não</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Descrição Curta -->
        <div class="row">
            <div class="col-12 mb-3">
                <div class="form-group">
                    <label>Descrição Curta <small>(1000 caracteres)</small></label>
                    <textarea maxlength="1000" class="form-control form-control-sm" id="description" name="description" placeholder="Descrição curta do produto"><?php echo $description2 ?></textarea>
                </div>
            </div>
        </div>

        <!-- Descrição Longa -->
        <div class="row">
            <div class="col-12 mb-3">
                <div class="form-group">
                    <label>Descrição Longa</label>
                    <textarea class="form-control form-control-sm" id="description_long" name="description_long" placeholder="Descrição completa do produto"><?php echo $description_long2 ?></textarea>
                </div>
            </div>
        </div>

        <!-- Palavras Chaves -->
        <div class="row">
            <div class="col-12 mb-3">
                <div class="form-group">
                    <label>Palavras Chaves</label>
                    <input value="<?php echo $words2 ?>" type="text" class="form-control form-control-sm" id="word" name="word" placeholder="Palavras chave separadas por vírgula">
                </div>
            </div>
        </div>

        <!-- Dimensões e Peso -->
        <div class="row">
            <!-- Peso -->
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="form-group">
                    <label>Peso (kg)</label>
                    <input value="<?php echo $weight2 ?>" type="text" class="form-control form-control-sm" id="weight" name="weight" placeholder="Peso">
                </div>
            </div>

            <!-- Largura -->
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="form-group">
                    <label>Largura (cm)</label>
                    <input value="<?php echo $width2 ?>" type="text" class="form-control form-control-sm" id="width" name="width" placeholder="Largura">
                </div>
            </div>

            <!-- Altura -->
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="form-group">
                    <label>Altura (cm)</label>
                    <input value="<?php echo $height2 ?>" type="text" class="form-control form-control-sm" id="height" name="height" placeholder="Altura">
                </div>
            </div>

            <!-- Comprimento -->
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="form-group">
                    <label>Comprimento (cm)</label>
                    <input value="<?php echo $length2 ?>" type="text" class="form-control form-control-sm" id="length" name="length" placeholder="Comprimento">
                </div>
            </div>
        </div>

        <!-- Imagem -->
        <div class="row align-items-start">
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="form-group">
                    <label for="image">Imagem</label>
                    <input type="file" class="form-control-file w-100" id="image" name="image" onchange="uploadImage();">
                </div>
                <div class="form-group mt-2 mb-0">
                    <?php if (!empty($image2)) { ?>
                        <img src="../../../store/assets/img/products/<?php echo $image2 ?>" alt="Imagem do produto" width="100" id="target">
                    <?php } else { ?>
                        <img src="../../../store/assets/img/products/no-photo.jpg" alt="Sem imagem" width="100" id="target">
                    <?php } ?>
                </div>
            </div>
        </div>

        <small>
            <div id="message"></div>
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

<!-- Modal Delete -->
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
                <div align="center" id="message_delete" class=""></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btn-cancel-delete">Cancelar</button>
                <form method="post" id="form-delete">
                    <input type="hidden" id="id" name="id" value="<?= $_GET['id'] ?? '' ?>" required>
                    <button type="button" id="btn-delete" name="btn-delete" class="btn btn-danger">Excluir</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Products -->
<div class="modal" id="modal-products" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adicionar Produtos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-feature">
                <div class="modal-body">
                    <div class="row">
        
                    </div>
                    <div id="message_products" class=""></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btn-cancel-products">Cancelar</button>
                    <input type="hidden" id="txtid" name="txtid" value="<?= $_GET['id'] ?? '' ?>" required>
                    <button type="button" id="btn-add-products" name="btn-add-products" class="btn btn-info">Adicionar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal deletar característica -->
<div class="modal" id="modalDeletedFeature" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Excluir característica</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Deseja realmente excluir esta característica?</p>
                <div align="center" id="message-deleted-feature" class=""></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btn-cancel-feature">Cancelar</button>
                <form method="post" id="form-deleted-feature">
                    <input type="hidden" name="id_feature" id="id_feature">
                    <button type="button" id="btn-deleted-feature" name="btn-deleted-feature" class="btn btn-danger">Excluir</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal adicionar item -->
<div class="modal" id="modalAddItem" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" id="form-item-list">
                <input type="hidden" name="id_feature_item2" id="id_feature_item2">
                <button type="submit" id="btn-item-list" name="btn-item-list" style="display:none;"></button>
            </form>

            <!-- FORMULÁRIO PRINCIPAL -->
            <form method="post" id="form-add-item">
                <div class="modal-header">
                    <h5 class="modal-title">Adicionar Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>*Descrição</label>
                                <input type="text" class="form-control" id="name-item" name="name-item" placeholder="Descrição do Item">
                            </div>
                            <div class="form-group">
                                <label>Valor Item <small>Se Existir - (EX: Código Hexadecimal da Cor)</small></label>
                                <input type="text" class="form-control" id="value-item" name="value-item" placeholder="Valor do Item EX #FFFFFF">
                            </div>
                        </div>

                        <div class="col-md-6" id="list-items">

                        </div>
                    </div>
                    <div align="center" id="message_item" class=""></div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <input type="hidden" name="id_feature_item" id="id_feature_item">
                    <button type="button" id="btn-item" name="btn-item" class="btn btn-info">Adicionar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal deletar item -->
<div class="modal" id="modalDeletedItem" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Excluir Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Deseja realmente excluir este item?</p>
                <div align="center" id="message-deleted-item" class=""></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btn-cancel-item-deleted">Cancelar</button>
                <form method="post" id="form-deleted-item">
                    <input type="hidden" name="id_feature_item" id="id_feature_item">
                    <button type="button" id="btn-deleted-item" name="btn-deleted-item" class="btn btn-danger">Excluir</button>
                </form>
            </div>
        </div>
    </div>
</div>


<?php
if (isset($_GET["function"])) {
    $function = $_GET["function"];
    if ($function == "new" || $function == "edit") {
        echo "<script>$('#modalData').modal('show');</script>";
    } elseif ($function == "deleted") {
        echo "<script>$('#modal-delete').modal('show');</script>";
    } elseif ($function == "images") {
        echo "<script>$('#modal-images').modal('show');</script>";
    } elseif ($function == "feature") {
        echo "<script>$('#modal-feature').modal('show');</script>";
    }
}
?>

<!-- SCRIPTS JAVASCRIPT  -->
<!-- INICIALIZAÇÃO DA PÁGINA -->
<script type="text/javascript">
    /* Quando a página for carregada, executa estas funções */
    $(document).ready(function() {
        listImagesProduct(); // Carrega as imagens dos produtos
        listFeature(); // Carrega as características
        document.getElementById('txtCategorie').value = document.getElementById('categorie').value; // Sincroniza valores
        listSubCategorie(); // Carrega as subcategorias
    });
</script>

<!-- CARREGAR SUBCATEGORIAS VIA AJAX -->
<script type="text/javascript">
    function listSubCategorie() {
        var pag = "<?= $pag ?>"; // Obtém a página atual do PHP
        $.ajax({
            url: "pages/" + pag + "/list-subcategorie.php", // Endpoint para subcategorias
            method: "post",
            data: $('#form-product').serialize(), // Envia dados do formulário principal
            dataType: "html",
            success: function(result) {
                $('#list-subcategorie').html(result); /* Atualiza a div com as subcategorias */
            }
        })
    }
</script>

<!-- LISTAR IMAGENS DOS PRODUTOS -->
<script type="text/javascript">
    function listImagesProduct() {
        var pag = "<?= $pag ?>";
        $.ajax({
            url: "pages/" + pag + "/list-images.php", // Endpoint para listar imagens
            method: "post",
            data: $('#form-photos').serialize(), // Envia dados do formulário de fotos
            dataType: "html",
            success: function(result) {
                $('#list-img-products').html(result); /* Atualiza a div com as imagens */
            }
        })
    }
</script>

<!-- ABRIR MODAL PARA DELETAR IMAGEM -->
<script type="text/javascript">
    function deletedImg(img) {
        document.getElementById('id_photo_img').value = img; // Define o ID da imagem a ser deletada
        $('#modalDeletedImg').modal('show'); // Abre o modal de confirmação
    }
</script>

<!-- ABRIR MODAL PARA DELETAR CARACTERÍSTICA -->
<script type="text/javascript">
    function deletedFeature(id) {
        document.getElementById('id_feature').value = id; // Define o ID da característica
        $('#modalDeletedFeature').modal('show'); // Abre o modal de confirmação
    }
</script>

<!-- ABRIR MODAL PARA DELETAR ITEM DA CARACTERÍSTICA -->
<script type="text/javascript">
    function deletedItem(id) {
        var element = document.getElementById('id_feature_item');

        if (element) {
            element.value = id;
            $('#modalDeletedItem').modal('show');
        } else {
            console.error("❌ Elemento id_feature_item NÃO ENCONTRADO!");
        }
    }
</script>

<!-- ABRIR MODAL PARA ADICIONAR ITEM A CARACTERÍSTICA -->
<script type="text/javascript">
    function addItem(id) {
        // Define os IDs
        $('#id_feature_item').val(id);
        $('#id_feature_item2').val(id);

        $('#modalAddItem').one('shown.bs.modal', function() {
            $('#btn-item-list').click();
        });

        $('#modalAddItem').modal('show');
    }
</script>

<!-- ENVIAR FOTOS DO PRODUTO VIA AJAX (COM UPLOAD DE ARQUIVO) -->
<script type="text/javascript">
    $("#form-photos").on("submit", function(e) {
        e.preventDefault(); // Impede o envio tradicional do formulário

        var pag = "<?= $pag ?>";
        var formData = new FormData(this); // Cria FormData para upload de arquivos

        $.ajax({
            url: "pages/" + pag + "/insert-images.php",
            method: "POST",
            data: formData,
            contentType: false, // Necessário para FormData - não definir contentType
            processData: false, // Necessário para FormData - não processar dados
            cache: false, // Evita cache
            dataType: "text",
            success: function(message) {
                // Processa a resposta do servidor
                if (message.trim() === "SALVO COM SUCESSO!!") {
                    $('#message_photos').addClass('text-success').text(message);
                    listImagesProduct(); // Recarrega a lista de imagens após sucesso
                } else {
                    $('#message_photos').addClass('text-danger').text(message);
                }
            },
            error: function(xhr) {
                // Trata erros de requisição
                $('#message_photos')
                    .removeClass('text-success').addClass('text-danger')
                    .text(xhr.responseText || 'Erro no upload.');
            },
            xhr: function() {
                // Configuração adicional para acompanhar progresso (opcional)
                var myXhr = $.ajaxSettings.xhr();
                if (myXhr.upload) {
                    myXhr.upload.addEventListener('progress', function(evt) {
                        // Aqui poderia ser implementada uma barra de progresso
                    }, false);
                }
                return myXhr;
            }
        });
    });
</script>

<!-- ATUALIZAR SUBCATEGORIAS QUANDO CATEGORIA MUDAR -->
<script type="text/javascript">
    $('#categorie').change(function() {
        document.getElementById('txtCategorie').value = $(this).val(); // Atualiza campo oculto
        document.getElementById('txtSubCategorie').value = ""; /* Limpa subcategoria anterior */
        listSubCategorie(); // Recarrega subcategorias baseadas na nova categoria
    })
</script>

<!-- PREVIEW DA IMAGEM PRINCIPAL ANTES DO UPLOAD -->
<script type="text/javascript">
    function uploadImage() {
        var target = document.getElementById('target'); // Elemento img onde mostrar preview
        var file = document.querySelector("input[type=file]").files[0]; // Arquivo selecionado
        var reader = new FileReader(); // Para ler o arquivo

        reader.onloadend = function() {
            target.src = reader.result; // Atualiza src da imagem com dados do arquivo
        };

        if (file) {
            reader.readAsDataURL(file); // Converte arquivo para Data URL
        } else {
            target.src = ""; // Limpa imagem se nenhum arquivo selecionado
        }
    }
</script>

<!-- PREVIEW DA IMAGEM DO PRODUTO (GALERIA) -->
<script type="text/javascript">
    function uploadImageProduct() {
        var target = document.getElementById('targetImgProduct'); // Imagem da galeria
        var file = document.querySelector("input[id=imgproduct]").files[0]; // Arquivo específico
        var reader = new FileReader();

        reader.onloadend = function() {
            target.src = reader.result; // Atualiza preview
        };

        if (file) {
            reader.readAsDataURL(file);
        } else {
            target.src = "";
        }
    }
</script>

<!-- CONFIGURAÇÃO DA DATATABLE -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTable').dataTable({
            "ordering": false // Desabilita ordenação automática da tabela
        })
    });
</script>

<!-- SALVAR PRODUTO VIA AJAX (FORMULÁRIO PRINCIPAL) -->
<script type="text/javascript">
    $(document).ready(function() {
        var pag = "<?= $pag ?>";
        $('#btn-save').click(function(event) {
            event.preventDefault(); // Impede envio tradicional

            var formData = new FormData($('#form-product')[0]); // Captura todos os campos + imagem

            $.ajax({
                url: "pages/" + pag + "/insert.php", // Endpoint para salvar produto
                method: "POST",
                data: formData,
                dataType: "text",
                contentType: false, // Necessário para FormData
                processData: false, // Necessário para FormData
                cache: false,
                success: function(message) {
                    $('#message').removeClass(); // Limpa classes anteriores

                    if (message.trim() === "SALVO COM SUCESSO!!") {
                        $('#message').addClass('text-success').text(message);
                        $('#name-category').val(''); // Limpa campo nome

                        // Fecha modal e redireciona após 1.5 segundos
                        setTimeout(function() {
                            $('#btn-closed').click();
                            window.location = "index.php?pag=" + pag;
                        }, 1500);

                    } else {
                        $('#message').addClass('text-danger').text(message); // Mostra erro
                    }
                },
                xhr: function() {
                    // Configuração para possível acompanhamento de progresso
                    var myXhr = $.ajaxSettings.xhr();
                    if (myXhr.upload) {
                        myXhr.upload.addEventListener('progress', function() {
                            // Pode implementar barra de progresso aqui
                        }, false);
                    }
                    return myXhr;
                }
            });
        });
    });
</script>

<!-- EXCLUIR PRODUTO VIA AJAX -->
<script type="text/javascript">
    $(document).ready(function() {
        var pag = "<?= $pag ?>";
        $('#btn-delete').click(function(event) {
            event.preventDefault();

            $.ajax({
                url: "pages/" + pag + "/deleted.php", // Endpoint para excluir
                method: "post",
                data: $('#form-delete').serialize(), // Envia ID do produto
                dataType: "text",
                success: function(message) {
                    $('#message_delete').removeClass();

                    if (message.trim() === "EXCLUÍDO COM SUCESSO!!") {
                        // Fecha modal e recarrega página
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

<!-- ADICIONAR CARACTERÍSTICA AO PRODUTO -->
<script type="text/javascript">
    $('#btn-add-feature').click(function(event) {
        event.preventDefault();
        var pag = "<?= $pag ?>";

        $.ajax({
            url: "pages/" + pag + "/add-feature.php",
            method: "post",
            data: $('#form-feature').serialize(), // Envia dados da característica
            dataType: "text",
            success: function(msg) {
                const message = msg.trim();
                if (message === 'Salvo com sucesso!!') {
                    $('#message_feature').addClass('text-success').text(message);
                    listFeature(); // Recarrega lista de características
                } else {
                    $('#message_feature').addClass('text-danger').text(message);
                }
            }
        });
    });
</script>

<!-- ADICIONAR ITEM A CARACTERÍSTICA - MODAL ABERTO -->
<script type="text/javascript">
    $('#btn-item').click(function(event) {
        event.preventDefault();
        var pag = "<?= $pag ?>";

        // Limpa a mensagem anterior
        $('#message_item').removeClass('text-success text-danger').text('');

        $.ajax({
            url: "pages/" + pag + "/add-item.php",
            method: "post",
            data: $('#form-add-item').serialize(),
            dataType: "text",
            success: function(msg) {
                const message = msg.trim();

                if (message === 'Salvo com sucesso!!') {
                    // SUCESSO - MANTÉM MODAL ABERTO
                    $('#message_item').removeClass('text-danger').addClass('text-success').text('✅ Item adicionado com sucesso!');

                    // LIMPA OS CAMPOS para novo item
                    $('#name-item').val('');
                    $('#value-item').val('');
                    $('#name-item').focus(); // Foca no primeiro campo

                    // RECARREGA A LISTA de itens
                    $('#btn-item-list').click();

                } else {
                    // ERRO - Mostra mensagem
                    $('#message_item').removeClass('text-success').addClass('text-danger').text('❌ ' + message);
                }
            },
            error: function() {
                $('#message_item').removeClass('text-success').addClass('text-danger').text('❌ Erro ao adicionar item!');
            }
        });
    });

    // FOCUS AUTOMÁTICO NO CAMPO NOME QUANDO MODAL ABRIR
    $('#modalAddItem').on('shown.bs.modal', function() {
        $('#name-item').focus();
    });

    // LIMPAR CAMPOS QUANDO MODAL FECHAR
    $('#modalAddItem').on('hidden.bs.modal', function() {
        $('#name-item').val('');
        $('#value-item').val('');
        $('#message_item').removeClass('text-success text-danger').text('');
    });
</script>

<!-- LISTAR CARACTERÍSTICAS DO PRODUTO -->
<script type="text/javascript">
    function listFeature() {
        var pag = "<?= $pag ?>";
        $.ajax({
            url: "pages/" + pag + "/list-feature.php", // Endpoint para listar características
            method: "post",
            data: $('#form-feature').serialize(),
            dataType: "html",
            success: function(result) {
                $('#list-feature').html(result); /* Atualiza div com características */
            }
        })
    }
</script>

<!-- LISTAR ITEM COM DEBUG -->
<script type="text/javascript">
    $('#btn-item-list').click(function(event) {
        event.preventDefault();
        var pag = "<?= $pag ?>";

        $.ajax({
            url: "pages/" + pag + "/list-items.php",
            method: "post",
            data: $('#form-item-list').serialize(),
            dataType: "html",
            success: function(result) {
                $('#list-items').html(result);
            },
            error: function(xhr, status, error) {
                $('#list-items').html('<p class="text-danger">Erro ao carregar itens</p>');
            }
        });
    });
</script>

<!-- EXCLUIR IMAGEM DA GALERIA -->
<script type="text/javascript">
    $(document).ready(function() {
        var pag = "<?= $pag ?>";

        $('#btn-deleted-img').click(function(event) {
            event.preventDefault();

            $.ajax({
                url: "pages/" + pag + "/deleted-images.php", // Endpoint para excluir imagem
                method: "POST",
                data: $('#form-delete-img').serialize(), // Envia ID da imagem
                dataType: "text",
                success: function(message) {
                    message = $.trim(message);
                    $('#message-deleted-img').removeClass('text-danger text-success');

                    if (message === "Excluído com Sucesso!!") {
                        $('#btn-cancel-img').click(); // Fecha modal
                        listImagesProduct(); // Recarrega lista de imagens
                    } else {
                        $('#message-deleted-img').addClass('text-danger').text(message || 'Falha ao excluir.');
                    }
                },
                error: function() {
                    $('#message-deleted-img')
                        .removeClass('text-success').addClass('text-danger')
                        .text('Erro ao chamar o script de exclusão.');
                }
            });
        });
    });
</script>

<!-- EXCLUIR CARACTERÍSTICA DO PRODUTO -->
<script type="text/javascript">
    $(document).ready(function() {
        var pag = "<?= $pag ?>";

        // Remove event listeners anteriores e adiciona novo
        $('#btn-deleted-feature').off('click').on('click', function(event) {
            event.preventDefault();
            var dados = $('#form-deleted-feature').serialize(); // Serializa dados do form

            $.ajax({
                url: "pages/" + pag + "/deleted-feature.php", // Endpoint para excluir característica
                method: "POST",
                data: dados,
                dataType: "text",
                success: function(message) {
                    message = $.trim(message);
                    $('#message-deleted-feature').removeClass('text-danger text-success');

                    if (message === "Excluído com Sucesso!!") {
                        listFeature(); // Recarrega lista de características
                        $('#modalDeletedFeature').modal('hide'); // Fecha modal
                    } else {
                        $('#message-deleted-feature').addClass('text-danger').text(message || 'Falha ao excluir.');
                    }
                },
                error: function() {
                    $('#message-deleted-feature')
                        .removeClass('text-success').addClass('text-danger')
                        .text('Erro ao chamar o script de exclusão.');
                }
            });
        });
    });
</script>

<!-- EXCLUIR ITEM DA CARACTERÍSTICA -->
<script type="text/javascript">
    $(document).ready(function() {
        var pag = "<?= $pag ?>";

        $('#btn-deleted-item').off('click').on('click', function(event) {
            event.preventDefault();

            var id = $('#id_feature_item').val();

            $.ajax({
                url: "pages/" + pag + "/deleted-item.php",
                method: "POST",
                data: {
                    id_feature_item: id
                },
                dataType: "text",
                success: function(message) {
                    message = $.trim(message);
                    $('#message-deleted-item').removeClass('text-danger text-success');

                    if (message === "Excluído com Sucesso!!") {
                        $('#btn-item-list').click();
                        $('#modalDeletedItem').modal('hide');
                    } else {
                        $('#message-deleted-item').addClass('text-danger').text(message);
                    }
                },
                error: function(xhr, status, error) {
                    $('#message-deleted-item')
                        .removeClass('text-success').addClass('text-danger')
                        .text('Erro ao chamar o script de exclusão.');
                }
            });
        });
    });
</script>