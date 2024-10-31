<?php require('processabd.php'); ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Configurador de Etiquetas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/styles.css" rel="stylesheet">
  <style>
    @media print {
      .no-print {
        display: none;
      }
    }

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

  <div class="container no-print">
    <h1>Configurador de Etiquetas</h1>
    <p>Preencha o formulário abaixo para gerar as etiquetas:</p>

    <form id="etiquetaForm" action="" method="GET">
      <input type="hidden" id="pmedia" name="pmedia">
      <input type="hidden" id="plabel" name="plabel">

      <div class="mb-3">
        <label for="from" class="form-label">Número da primeira etiqueta:</label>
        <input type="number" class="form-control" id="from" name="from" value="<?= isset($_GET['from']) ? $_GET['from'] : 1 ?>">
      </div>
      <div class="mb-3">
        <label for="to" class="form-label">Número da última etiqueta:</label>
        <input type="number" class="form-control" id="to" name="to" value="<?= isset($_GET['to']) ? $_GET['to'] : 2000 ?>">
      </div>

      <h2>Layout da Mídia</h2>

      <div class="mb-3">
        <label for="rows" class="form-label">Linhas por mídia:</label>
        <input type="number" class="form-control" id="rows" name="rows" value="<?= isset($_GET['rows']) ? $_GET['rows'] : 1 ?>">
      </div>
      <div class="mb-3">
        <label for="cols" class="form-label">Colunas por mídia:</label>
        <input type="number" class="form-control" id="cols" name="cols" value="<?= isset($_GET['cols']) ? $_GET['cols'] : 3 ?>">
      </div>
      <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="tmedia" name="tmedia" value="folha" <?= isset($_GET['tmedia']) && $_GET['tmedia'] == 'folha' ? 'checked' : '' ?>>
        <label class="form-check-label" for="tmedia">Quebra de página entre as mídias?</label>
      </div>

      <h2>Dimensões da Mídia</h2>

      <div class="mb-3">
        <label for="wmedia" class="form-label">Largura da mídia (mm):</label>
        <input type="number" class="form-control" id="wmedia" name="wmedia" value="<?= isset($_GET['wmedia']) ? $_GET['wmedia'] : 210 ?>">
      </div>
      <div class="mb-3">
        <label for="hmedia" class="form-label">Altura da mídia (mm):</label>
        <input type="number" class="form-control" id="hmedia" name="hmedia" value="<?= isset($_GET['hmedia']) ? $_GET['hmedia'] : 297 ?>">
      </div>

      <h3>Padding da Mídia (mm)</h3>

      <?php
      $pmedia = isset($_GET['pmedia']) ? explode(',', $_GET['pmedia']) : array(10, 10, 10, 10);
      ?>
      <div class="mb-3">
        <label for="pmediaTop" class="form-label">Topo:</label>
        <input type="number" class="form-control" id="pmediaTop" value="<?= $pmedia[0] ?>">
      </div>
      <div class="mb-3">
        <label for="pmediaRight" class="form-label">Direita:</label>
        <input type="number" class="form-control" id="pmediaRight" value="<?= $pmedia[1] ?>">
      </div>
      <div class="mb-3">
        <label for="pmediaBottom" class="form-label">Base:</label>
        <input type="number" class="form-control" id="pmediaBottom" value="<?= $pmedia[2] ?>">
      </div>
      <div class="mb-3">
        <label for="pmediaLeft" class="form-label">Esquerda:</label>
        <input type="number" class="form-control" id="pmediaLeft" value="<?= $pmedia[3] ?>">
      </div>

      <div class="mb-3">
        <label for="grmedia" class="form-label">Espaçamento entre linhas (mm):</label>
        <input type="number" class="form-control" id="grmedia" name="grmedia" value="<?= isset($_GET['grmedia']) ? $_GET['grmedia'] : 5 ?>">
      </div>
      <div class="mb-3">
        <label for="gcmedia" class="form-label">Espaçamento entre colunas (mm):</label>
        <input type="number" class="form-control" id="gcmedia" name="gcmedia" value="<?= isset($_GET['gcmedia']) ? $_GET['gcmedia'] : 5 ?>">
      </div>

      <h2>Dimensões da Etiqueta</h2>

      <div class="mb-3">
        <label for="wlabel" class="form-label">Largura da etiqueta (mm):</label>
        <input type="number" class="form-control" id="wlabel" name="wlabel" value="<?= isset($_GET['wlabel']) ? $_GET['wlabel'] : 70 ?>">
      </div>
      <div class="mb-3">
        <label for="hlabel" class="form-label">Altura da etiqueta (mm):</label>
        <input type="number" class="form-control" id="hlabel" name="hlabel" value="<?= isset($_GET['hlabel']) ? $_GET['hlabel'] : 35 ?>">
      </div>

      <h3>Padding da Etiqueta (mm)</h3>

      <?php
      $plabel = isset($_GET['plabel']) ? explode(',', $_GET['plabel']) : array(5, 5, 5, 5);
      ?>
      <div class="mb-3">
        <label for="plabelTop" class="form-label">Topo:</label>
        <input type="number" class="form-control" id="plabelTop" value="<?= $plabel[0] ?>">
      </div>
      <div class="mb-3">
        <label for="plabelRight" class="form-label">Direita:</label>
        <input type="number" class="form-control" id="plabelRight" value="<?= $plabel[1] ?>">
      </div>
      <div class="mb-3">
        <label for="plabelBottom" class="form-label">Base:</label>
        <input type="number" class="form-control" id="plabelBottom" value="<?= $plabel[2] ?>">
      </div>
      <div class="mb-3">
        <label for="plabelLeft" class="form-label">Esquerda:</label>
        <input type="number" class="form-control" id="plabelLeft" value="<?= $plabel[3] ?>">
      </div>

      <button type="submit" class="btn btn-primary">Gerar Etiquetas</button>
    </form>
    <hr>
  </div>

  <?php
  // Obtém os parâmetros da URL, ou define valores padrão se não estiverem definidos
  $from = isset($_GET['from']) ? (int)$_GET['from'] : 1;
  $to = isset($_GET['to']) ? (int)$_GET['to'] : 2000;
  $rows = isset($_GET['rows']) ? (int)$_GET['rows'] : 1; // Número de linhas por mídia
  $cols = isset($_GET['cols']) ? (int)$_GET['cols'] : 3; // Número de colunas por mídia
  $tmedia = isset($_GET['tmedia']) && $_GET['tmedia'] == 'folha' ? true : false; // Tipo de mídia (true para folha, false para contínuo)
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
            <div class="cod"><?= htmlspecialchars($item->destino) ?>:<?= htmlspecialchars($item->cod) ?></div>
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

  <script>
    document.getElementById('etiquetaForm').addEventListener('submit', function(event) {
      // Concatena os valores de pmedia
      let pmedia = `${document.getElementById('pmediaTop').value},${document.getElementById('pmediaRight').value},${document.getElementById('pmediaBottom').value},${document.getElementById('pmediaLeft').value}`;
      document.getElementById('pmedia').value = pmedia;

      // Concatena os valores de plabel
      let plabel = `${document.getElementById('plabelTop').value},${document.getElementById('plabelRight').value},${document.getElementById('plabelBottom').value},${document.getElementById('plabelLeft').value}`;
      document.getElementById('plabel').value = plabel;
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>