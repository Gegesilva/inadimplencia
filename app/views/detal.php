<?php
header('Content-type: text/html; charset=ISO-8895-1');
include "../../Config/config.php";
include "../../Config/database.php";

/* $ano = $_POST[];
$mes = $_POST[];
$periodo = $_POST[]; */
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/CSS/detal.css">
    <title>TINSEI</title>
</head>

<body>
<div class="month-grid">
    <!-- Exemplo de um mês (repita para os outros) -->
    <div class="month-card">
      <div class="month-title">JANEIRO <?= $ano ?> Periodo: <?= $periodo ?></div>
      <table>
        <thead>
          <tr>
            <th>Titulo</th>
            <th>CodEmp</th>
            <th>Venc Original</th>
            <th>Codcli</th>
            <th>Valor Titulo</th>
            <th>Valor Pago</th>
          </tr>
        </thead>
        <?php
            $sql= "SELECT 
                        TB04010_CODIGO,
                        TB04010_CODEMP,
                        TB04010_DTVENCORIGINAL,
                        TB04010_CODCLI,
                        TB04010_VLRTITULO,
                        TB04010_VLRPAGO
                    FROM FTVENCIDO_DETAL_2(2024, 1, '0A30')";

            $stmt = sqlsrv_query($conn, $sql);
        ?>
        <tbody>
         <?php
            $tabela = "";

            while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $tabela .= "<tr>";
                $tabela .= "<td>$row[TB04010_CODIGO]</td>";
                $tabela .= "<td>$row[TB04010_CODEMP]</td>";
                $tabela .= "<td>$row[TB04010_DTVENCORIGINAL]</td>";
                $tabela .= "<td>$row[TB04010_CODCLI]</td>";
                $tabela .= "<td>$row[TB04010_VLRTITULO]</td>";
                $tabela .= "<td>$row[TB04010_VLRPAGO]</td>";
                $tabela .= "</tr>";
            }
            print($tabela);
         ?>
        </tbody>
      </table>
    </div>

    <!-- Copie e edite o conteúdo acima para FEVEREIRO a DEZEMBRO -->
  </div>
</body>

</html>