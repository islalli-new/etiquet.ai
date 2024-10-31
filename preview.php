<?php require('processabd.php'); ?>

<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Impressao de Etiquetas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    <style>
        .media {
            width: <?= isset($_GET['wmedia']) ? $_GET['wmedia'] . 'mm' : '210mm' ?>;
            height: <?= isset($_GET['hmedia']) ? $_GET['hmedia'] . 'mm' : '297mm' ?>;
            <?php if (isset($_GET['pmedia'])) :
                $pmedia = explode(',', $_GET['pmedia']);
                $pmedia = array_map(function ($value) {
                    return trim($value) . 'mm';
                }, $pmedia);
                $pmedia = implode(' ', $pmedia);
            ?>padding: <?= $pmedia ?>;
            <?php else : ?>padding: 10mm;
            <?php endif; ?>display: grid;
            grid-template-columns: repeat(<?= isset($_GET['cols']) ? $_GET['cols'] : 3 ?>, 1fr);
            grid-template-rows: repeat(<?= isset($_GET['rows']) ? $_GET['rows'] : 1 ?>, 1fr);
            gap: <?= isset($_GET['grmedia']) ? $_GET['grmedia'] . 'mm' : '5mm' ?> <?= isset($_GET['gcmedia']) ? $_GET['gcmedia'] . 'mm' : '5mm' ?>;
        }

        .label-container {
            width: <?= isset($_GET['wlabel']) ? $_GET['wlabel'] . 'mm' : '70mm' ?>;
            height: <?= isset($_GET['hlabel']) ? $_GET['hlabel'] . 'mm' : '35mm' ?>;
            <?php if (isset($_GET['plabel'])) :
                $plabel = explode(',', $_GET['plabel']);
                $plabel = array_map(function ($value) {
                    return trim($value) . 'mm';
                }, $plabel);
                $plabel = implode(' ', $plabel);
            ?>padding: <?= $plabel ?>;
            <?php else : ?>padding: 5mm;
            <?php endif; ?>
        }
    </style>
</head>

<body>
    <?php
    // Obtém os parâmetros da URL, ou define valores padrão se não estiverem definidos
    $from = isset($_GET['from']) ? (int)$_GET['from'] : 1;
    $to = isset($_GET['to']) ? (int)$_GET['to'] : 2000;
    $rows = isset($_GET['rows']) ? (int)$_GET['rows'] : 1; // Número de linhas por mídia
    $cols = isset($_GET['cols']) ? (int)$_GET['cols'] : 3; // Número de colunas por mídia
    $tmedia = isset($_GET['tmedia']) && $_GET['tmedia'] == 'true' ? true : false; // Tipo de mídia (true para folha, false para contínuo)
    $maxLabels = $rows * $cols; // Máximo de etiquetas por mídia

    $count = 0; // Contador de etiquetas

    if ($xml) :
        foreach ($xml->item as $item) :
            $sequencia = (int) $item->sequencia;
            if ($sequencia >= $from && $sequencia <= $to) :
                if ($count % $maxLabels == 0) : // Verifica se é necessário abrir uma nova mídia
    ?>
                    <div class="media <?= ($count > 0 && $tmedia) ? 'page-break' : ''; ?>">
                    <?php endif; ?>

                    <div class="d-flex flex-column justify-content-center align-items-center gap-2 label-container">
                        <div class="cod fw-bolder"><?= htmlspecialchars($item->destino) ?>:<?= htmlspecialchars($item->cod) ?></div>
                        <div class="d-flex justify-content-center w-100 gap-2 small" style="font-weight: 600;">
                            <div class="dest"><?= htmlspecialchars($item->sequencia) ?></div>
                        </div>
                    </div>

                    <?php
                    $count++;
                    if ($count % $maxLabels == 0) : // Verifica se é necessário fechar a mídia atual
                    ?>
                    </div>
            <?php endif;

                endif;
            endforeach;

            // Fecha a última mídia, se necessário
            if ($count % $maxLabels != 0) :
            ?>
            </div>
        <?php endif;

        else : ?>
        <p>Não foi possível carregar os dados das etiquetas.</p>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>