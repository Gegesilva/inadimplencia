<?php
header('Content-type: text/html; charset=ISO-8895-1');
include "../../Config/config.php";
include "../../Config/database.php";

$ano = (INT) $_POST["ano"];
$mes = (INT) $_POST["mes"];
$periodo = (STRING) $_POST["periodo"];
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
            <div class="month-title">JANEIRO <?= $ano ?> Mês: <?= $mes ?> Periodo: <?= $periodo ?></div>
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
                $sql = "SELECT 
                        TB04010_CODIGO,
                        TB04010_CODEMP,
                        FORMAT(TB04010_DTVENCORIGINAL, 'dd/MM/yyyy') TB04010_DTVENCORIGINAL,
                        NOMECLIENTE,
                        TB04010_VLRTITULO,
                        TB04010_VLRPAGO
                    FROM FTVENCIDO_DETAL_2($ano, $mes, '$periodo')";
                $stmt = sqlsrv_query($conn, $sql);
                ?>
                <tbody>
                    <?php
                    function formatarMoeda($valor)
                    {
                        return 'R$ ' . number_format((float) $valor, 2, ',', '.');
                    }

                    $tabela = "";

                    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                        $titulo = (float) $row['TB04010_VLRTITULO'];
                        $pago = (float) $row['TB04010_VLRPAGO'];

                        $tabela .= "<tr>";
                        $tabela .= "<td>$row[TB04010_CODIGO]</td>";
                        $tabela .= "<td>$row[TB04010_CODEMP]</td>";
                        $tabela .= "<td>$row[TB04010_DTVENCORIGINAL]</td>";
                        $tabela .= "<td>$row[NOMECLIENTE]</td>";
                        $tabela .= "<td>$row[TB04010_VLRTITULO]</td>";
                        $tabela .= "<td>$row[TB04010_VLRPAGO]</td>";
                        $tabela .= "</tr>";
                    }
                    print ($tabela);
                    ?>
                    
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>