<?php
require_once("../../../../config/connection.php");

$id_feature_prod = $_POST['id_feature_item2'] ?? '';

error_log("ID Recebido no list-items.php: " . $id_feature_prod);

if (empty($id_feature_prod)) {
    echo "<p class='text-danger'>ID da característica não recebido</p>";
    exit;
}

echo "<div class='ml-2'>";

try {
    // Busca os itens da característica
    $query = $pdo->query("SELECT * FROM feature_items WHERE id_feature_prod = '" . $id_feature_prod . "'");
    $res = $query->fetchAll(PDO::FETCH_ASSOC);

    $total_registros = count($res);

    if ($total_registros > 0) {
        echo "<h6>Itens Cadastrados:</h6>";

        for ($i = 0; $i < $total_registros; $i++) {
            $item_id = $res[$i]['id'];
            $item_name = $res[$i]['name'] ?? '';
            $item_value = $res[$i]['value'] ?? '';

            // Exibe cada item - VERSÃO FINAL UX
            echo "<div class='mb-2 p-2 border-start border-secondary bg-light'>";
            echo "<i class='text-dark fas fa-chevron-right fa-xs fa-fw me-2'></i>";
            echo "<span class='text-dark fw-medium'>" . htmlspecialchars($item_name) . "</span>";

            if (!empty($item_value)) {
                echo " <span class='text-muted'>-</span> <code class='bg-white px-1 rounded border'>" . htmlspecialchars($item_value) . "</code>";
            }

            // Botão excluir - posicionamento consistente
            echo " <span class='float-end'>";
            echo "<a href='#' onclick='deletedItem(" . $item_id . ")' class='text-danger text-decoration-none' title='Excluir Item'>";
            echo "<i class='fas fa-times fa-xs'></i>";
            echo "</a>";
            echo "</span>";

            echo "</div>";
        }
    } else {
        echo "<p class='text-muted'>Nenhum item cadastrado</p>";
    }
} catch (Exception $e) {
    echo "<p class='text-danger'>Erro: " . $e->getMessage() . "</p>";
}

echo "</div>";
