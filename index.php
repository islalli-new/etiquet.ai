<?php require('processabd.php'); ?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Impressao de Etiquetas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
</head>

<body>
    <?php
    // Obtém os parâmetros from e to da URL, ou define valores padrão se não estiverem definidos
    $from = isset($_GET['from']) ? (int)$_GET['from'] : 1;
    $to = isset($_GET['to']) ? (int)$_GET['to'] : 2000;

    if ($xml) : ?>
        <?php foreach ($xml->item as $item) : ?>
            <?php 
            $sequencia = (int) $item->sequencia; // Converte o valor para inteiro para comparação
            if ($sequencia >= $from && $sequencia <= $to) : ?>
                <div class="d-flex flex-column justify-content-center align-items-center gap-2 label-container page-break">
                    <div class="cod fw-bolder"><?= htmlspecialchars($item->destino) ?>:<?= htmlspecialchars($item->cod) ?></div>
                    <div class="d-flex justify-content-center w-100 gap-2 small" style="font-weight: 600;">
                        <div class="dest"><?= htmlspecialchars($item->sequencia) ?></div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php else : ?>
        <p>Não foi possível carregar os dados das etiquetas.</p>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
