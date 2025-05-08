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
    <h2><img src="img/logo.jpg" alt="logo"></h2>
    <div>
      <form method="POST">
        <label for="year">Ano: </label>
        <select class="filtro" id="year" name="ano" onchange="this.form.submit()">
          <?php
          $anoAtual = date('Y');
          $anoSelecionado = isset($_POST['ano']) ? $_POST['ano'] : $anoAtual;
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
				        PERIODOALL_TITULO,

                PERIODO0A30_PAGO,
                PERIODO0A90_PAGO,
                PERIODO0A365_PAGO,
				        PERIODOALL_PAGO,

                INAD0A30,
                INAD0A90,
                INAD0A365,
                INADALL,

                PERC0A30,
                PERC0A90,
                PERC0A365,
                PERCALL
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
    $meses = [];
    $perc0a30 = [];
    $perc0a90 = [];
    $perc0a365 = [];
    $percall = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
      $mes = (int) $row['MES'];
      $mesNome = isset($nomesMeses[$mes]) ? $nomesMeses[$mes] : 'MÊS ' . $mes;

      $aberto30 = (float) $row['PERIODO0A30_TITULO'];
      $aberto90 = (float) $row['PERIODO0A90_TITULO'];
      $aberto365 = (float) $row['PERIODO0A365_TITULO'];
      $abertoAll = (float) $row['PERIODOALL_TITULO'];
      $totalAberto = $aberto30 + $aberto90 + $aberto365 + $abertoAll;

      $pago30 = (float) $row['PERIODO0A30_PAGO'];
      $pago90 = (float) $row['PERIODO0A90_PAGO'];
      $pago365 = (float) $row['PERIODO0A365_PAGO'];
      $pagoAll = (float) $row['PERIODOALL_PAGO'];
      $totalPago = $pago30 + $pago90 + $pago365 + $pagoAll;

      $inad30 = (float) $row['INAD0A30'];
      $inad90 = (float) $row['INAD0A90'];
      $inad365 = (float) $row['INAD0A365'];
      $inadAll = (float) $row['INADALL'];
      $inadTotal = $inad30 + $inad90 + $inad365 + $inadAll;

      $perc0a30Tab = (float) $row['PERC0A30'];
      $perc0a90Tab = (float) $row['PERC0A90'];
      $perc0a365Tab = (float) $row['PERC0A365'];
      $percallTab = (float) $row['PERCALL'];
      $totalPercTab = (float) ($perc0a30Tab + $perc0a90Tab + $perc0a365Tab + $percallTab);

      /* Variaveis do grafico */
      $meses[] = isset($nomesMeses[$mes]) ? $nomesMeses[$mes] : 'MÊS ' . $mes;
      $perc0a30[] = floatval($row['PERC0A30']);
      $perc0a90[] = floatval($row['PERC0A90']);
      $perc0a365[] = floatval($row['PERC0A365']);
      $percall[] = floatval($row['PERCALL']);



      $tabela .= "<div class='month-card'>";
      $tabela .= "<div class='month-title1'>{$mesNome}</div>";
      $tabela .= "<table>";
      $tabela .= "<thead><tr><th>Períodos</th><th>Contas a receber</th><th>Valor Recebido</th><th>Diferença</th><th>Índice</th></tr></thead>";
      $tabela .= "<tbody>";

      $tabela .= "<tr class='linha-click' onclick=\"enviarDetalhes('$anoSelecionado', '$mes', '0a30')\" style='cursor:pointer'>";
      $tabela .= "<td>0 a 30 dias</td><td>" . formatarMoeda($aberto30) . "</td><td>" . formatarMoeda($pago30) . "</td><td>" . formatarMoeda($inad30) . "</td><td> %" . $perc0a30Tab . "</td></tr>";

      $tabela .= "<tr class='linha-click' onclick=\"enviarDetalhes('$anoSelecionado', '$mes', '0a90')\" style='cursor:pointer'>";
      $tabela .= "<td>0 a 90 dias</td><td>" . formatarMoeda($aberto90) . "</td><td>" . formatarMoeda($pago90) . "</td><td>" . formatarMoeda($inad90) . "</td><td> %" . $perc0a90Tab . "</td></tr>";

      $tabela .= "<tr class='linha-click' onclick=\"enviarDetalhes('$anoSelecionado', '$mes', '0a365')\" style='cursor:pointer'>";
      $tabela .= "<td>0 a 365 dias</td><td>" . formatarMoeda($aberto365) . "</td><td>" . formatarMoeda($pago365) . "</td><td>" . formatarMoeda($inad365) . "</td><td> %" . $perc0a365Tab . "</td></tr>";

      $tabela .= "<tr class='total-row'>";
      $tabela .= "<td>Global</td><td>" . formatarMoeda($abertoAll) . "</td><td>" . formatarMoeda($pagoAll) . "</td><td>" . formatarMoeda($inadAll) . "</td><td> %" . $percallTab . "</td></tr>";

      /* $tabela .= "<tr class='total-row'><td>Total</td><td>" . formatarMoeda($totalAberto) . "</td><td>" . formatarMoeda($totalPago) . "</td><td>" . formatarMoeda($inadTotal) . "</td><td> %" .$totalPercTab . "</td></tr>"; */
      $tabela .= "</tbody></table></div>";
    }

    echo $tabela;

    
    ?>
  </div>
  <!-- Gráfico -->
  <div class="grafico">
    <div class="chart-container">
      <canvas id="lineChart"></canvas>
    </div>
  </div>

  <!-- Dados JS embutidos -->
  <script>
    const chartData = {
      labels: <?= json_encode($meses) ?>,
      datasets: {
        perc0a30: <?= json_encode($perc0a30) ?>,
        perc0a90: <?= json_encode($perc0a90) ?>,
        perc0a365: <?= json_encode($perc0a365) ?>,
        percall: <?= json_encode($percall) ?>
      }
    };
  </script>

  </div>
  <script src="JS/script.js" charset="utf-8"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <form id="detalForm" method="POST" action="../app/views/detal.php" style="display: none;">
    <input type="hidden" name="ano" id="formAno">
    <input type="hidden" name="mes" id="formMes">
    <input type="hidden" name="periodo" id="formPeriodo">
  </form>

</body>

</html>