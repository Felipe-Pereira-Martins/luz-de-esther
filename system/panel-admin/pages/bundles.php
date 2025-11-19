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
                            <td><i class="fas fa-check-circle <?= $class ?>"></i> <a href="index.php?pag=<?php echo $pag ?>&function=products&id=<?= $id ?>" class="text-info"><?= $name ?></a></td>
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

                    <!-- Valor Frete e Imagem -->
                    <div class="row align-items-start">
                        <!-- Valor Frete -->
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="form-group">
                                <label for="shipping_value">Valor do Frete</label>
                                <input value="<?php echo $shipping_value2 ?>" type="text" class="form-control form-control-sm" id="shipping_value" name="shipping_value" placeholder="Valor do Frete">
                            </div>
                        </div>

                        <!-- Imagem -->
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="form-group">
                                <label for="image">Imagem</label>
                                <input type="file" class="form-control-file w-100" id="image" name="image" onchange="uploadImage();">
                            </div>
                            <div class="form-group mt-2 mb-0">
                                <?php if (!empty($image2)) { ?>
                                    <img src="../../../store/assets/img/bundles/<?php echo $image2 ?>" alt="Imagem do produto" width="100" id="target">
                                <?php } else { ?>
                                    <img src="../../../store/assets/img/bundles/no-photo.jpg" alt="Sem imagem" width="100" id="target">
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
                <h5 class="modal-title">Excluir combo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Deseja realmente excluir este combo?</p>
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

<!-- Modal deletar produtos -->
<div class="modal" id="modalDeletedProduct" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Excluir </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Deseja realmente excluir este produto?</p>
                <div align="center" id="message-deleted-product" class=""></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btn-cancel-product">Cancelar</button>
                <form method="post" id="form-deleted-product">
                    <input type="hidden" name="id_product" id="id_product">
                    <button type="button" id="btn-deleted-product" name="btn-deleted-product" class="btn btn-danger">Excluir</button>
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
    } elseif ($function == "products") {
        echo "<script>$('#modal-products').modal('show');</script>";
    }
?>
    <!-- SCRIPTS JAVASCRIPT PARA COMBOS -->
    <!-- INICIALIZAÇÃO DA PÁGINA -->
    <script type="text/javascript">
        /* Quando a página for carregada, executa estas funções */
        $(document).ready(function() {
            // Configuração da DataTable
            $('#dataTable').dataTable({
                "ordering": false // Desabilita ordenação automática da tabela
            });
        });
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

    <!-- SALVAR COMBO VIA AJAX -->
    <script type="text/javascript">
        $(document).ready(function() {
            var pag = "<?= $pag ?>";
            $('#btn-save').click(function(event) {
                event.preventDefault(); // Impede envio tradicional

                var formData = new FormData($('#form-product')[0]); // Captura todos os campos + imagem

                $.ajax({
                    url: "pages/" + pag + "/insert.php",
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

                            // Fecha modal e redireciona após 1.5 segundos
                            setTimeout(function() {
                                $('#btn-closed').click();
                                window.location = "index.php?pag=" + pag;
                            }, 1500);

                        } else {
                            $('#message').addClass('text-danger').text(message); // Mostra erro
                        }
                    }
                });
            });
        });
    </script>

    <!-- EXCLUIR COMBO VIA AJAX -->
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

    <!-- ADICIONAR PRODUTOS AO COMBO -->
    <script type="text/javascript">
        $('#btn-add-products').click(function(event) {
            event.preventDefault();
            var pag = "<?= $pag ?>";

            $.ajax({
                url: "pages/" + pag + "/add-products.php",
                method: "post",
                data: $('#form-feature').serialize(),
                dataType: "text",
                success: function(msg) {
                    const message = msg.trim();
                    if (message === 'Salvo com sucesso!!') {
                        $('#message_products').addClass('text-success').text(message);
                        // Aqui você pode adicionar função para recarregar a lista de produtos se necessário
                    } else {
                        $('#message_products').addClass('text-danger').text(message);
                    }
                }
            });
        });
    </script>

    <!-- EXCLUIR PRODUTO DO COMBO -->
    <script type="text/javascript">
        $(document).ready(function() {
            var pag = "<?= $pag ?>";

            $('#btn-deleted-product').click(function(event) {
                event.preventDefault();

                $.ajax({
                    url: "pages/" + pag + "/deleted-product.php",
                    method: "POST",
                    data: $('#form-deleted-product').serialize(),
                    dataType: "text",
                    success: function(message) {
                        message = $.trim(message);
                        $('#message-deleted-product').removeClass('text-danger text-success');

                        if (message === "Excluído com Sucesso!!") {
                            $('#modalDeletedProduct').modal('hide');
                            // Recarrega a página para atualizar a contagem de produtos
                            setTimeout(function() {
                                window.location.reload();
                            }, 500);
                        } else {
                            $('#message-deleted-product').addClass('text-danger').text(message || 'Falha ao excluir.');
                        }
                    }
                });
            });
        });
    </script>

    <!-- ABRIR MODAL PARA DELETAR PRODUTO DO COMBO -->
    <script type="text/javascript">
        function deletedProduct(id) {
            document.getElementById('id_product').value = id;
            $('#modalDeletedProduct').modal('show');
        }
    </script>

<?php } ?>