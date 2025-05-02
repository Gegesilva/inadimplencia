<?php
header('Content-type: text/html; charset=ISO-8895-1');
include "../Config/config.php";
include "../Config/database.php";
include "../app/models/models.php";

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../public/CSS/index.css">
  <title>TINSEI</title>
</head>

<body>

  <div class="header">
    <h2>TINSEI</h2>
    <div>
      <form method="POST">
        <label for="year">Ano: </label>
        <select id="year" name="ano" onchange="this.form.submit()">
          <?php
          $anoAtual = date('Y');
          $anoSelecionado = $_POST['ano'] ?? $anoAtual;
          for ($ano = $anoAtual; $ano >= 2020; $ano--) {
            $selected = ($ano == $anoSelecionado) ? 'selected' : '';
            echo "<option value='$ano' $selected>$ano</option>";
          }
          ?>
        </select>
      </form>
    </div>
  </div>

  <div class="month-grid">

    <?php
    $sql = "SELECT 
        MES,
        PERIODO0A30_TITULO,
        PERIODO0A90_TITULO,
        PERIODO0A365_TITULO,
        PERIODO0A30_PAGO,
        PERIODO0A90_PAGO,
        PERIODO0A365_PAGO
    FROM FTVENCIDO($anoSelecionado)";

    $stmt = sqlsrv_query($conn, $sql);
    $tabela = "";

    $nomesMeses = [
      1 => 'JANEIRO',
      2 => 'FEVEREIRO',
      3 => 'MARÇO',
      4 => 'ABRIL',
      5 => 'MAIO',
      6 => 'JUNHO',
      7 => 'JULHO',
      8 => 'AGOSTO',
      9 => 'SETEMBRO',
      10 => 'OUTUBRO',
      11 => 'NOVEMBRO',
      12 => 'DEZEMBRO'
    ];

    // Função para formatar em reais
    function formatarMoeda($valor)
    {
      return 'R$ ' . number_format((float) $valor, 2, ',', '.');
    }

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
      $mes = (int) $row['MES'];
      $mesNome = $nomesMeses[$mes] ?? 'MÊS ' . $mes;

      $aberto30 = (float) $row['PERIODO0A30_TITULO'];
      $aberto90 = (float) $row['PERIODO0A90_TITULO'];
      $aberto365 = (float) $row['PERIODO0A365_TITULO'];
      $totalAberto = $aberto30 + $aberto90 + $aberto365;

      $pago30 = (float) $row['PERIODO0A30_PAGO'];
      $pago90 = (float) $row['PERIODO0A90_PAGO'];
      $pago365 = (float) $row['PERIODO0A365_PAGO'];
      $totalPago = $pago30 + $pago90 + $pago365;

      $tabela .= "<div class='month-card'>";
      $tabela .= "<div class='month-title1'>{$mesNome}</div>";
      $tabela .= "<table>";
      $tabela .= "<thead><tr><th>Períodos</th><th>Valor Aberto</th><th>Valor Pago</th></tr></thead>";
      $tabela .= "<tbody>";
      $tabela .= "<tr><td>0 a 30 dias</td><td>" . formatarMoeda($aberto30) . "</td><td>" . formatarMoeda($pago30) . "</td></tr>";
      $tabela .= "<tr><td>31 a 90 dias</td><td>" . formatarMoeda($aberto90) . "</td><td>" . formatarMoeda($pago90) . "</td></tr>";
      $tabela .= "<tr><td>91 a 365 dias</td><td>" . formatarMoeda($aberto365) . "</td><td>" . formatarMoeda($pago365) . "</td></tr>";
      $tabela .= "<tr class='total-row'><td>Total</td><td>" . formatarMoeda($totalAberto) . "</td><td>" . formatarMoeda($totalPago) . "</td></tr>";
      $tabela .= "</tbody></table></div>";
    }

    echo $tabela;
    ?>

  </div>
  </div>
  <script src="JS/script.js" charset="utf-8"></script>
</body>

</html>