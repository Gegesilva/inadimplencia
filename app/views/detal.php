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
                        <th>Empresa</th>
                        <th>Data Emissão</th>
                        <th>Vencimento</th>
                        <th>Venc Original</th>
                        <th>Data Baixa</th>
                        <th>Dif Dias</th>
                        <th>Cliente</th>
                        <th>Valor Titulo</th>
                        <th>Valor Pago</th>
                        <th>Tipo Documento</th>
                        <th><button class="btn-voltar-detal" onclick="voltar()"></button></th>
                    </tr>
                </thead>
                <?php
                $sql = "SELECT 
                            Func.TB04010_CODIGO,
                            Func.TB04010_CODEMP,
                            FORMAT(Func.TB04010_DTCAD, 'dd/MM/yyyy') TB04010_DTCAD,
                            FORMAT(Tab.TB04010_DTVENC,'dd/MM/yyyy') TB04010_DTVENC,
                            FORMAT(Func.TB04010_DTVENCORIGINAL, 'dd/MM/yyyy') TB04010_DTVENCORIGINAL,
                            ISNULL(DATEDIFF(D, Func.TB04011_DTBAIXA ,Func.TB04010_DTVENCORIGINAL), 0) DIEFEREÇA_DIAS,
                            ISNULL(FORMAT(Func.TB04011_DTBAIXA, 'dd/MM/yyyy'), 'Aberto') TB04011_DTBAIXA,
                            NOMECLIENTE,
                            Func.TB04010_VLRTITULO,
                            Func.TB04010_VLRPAGO,
						    TipoDoc.TB04003_NOME
                        FROM FTVENCIDO_DETAL_2($ano, $mes, '$periodo') as Func
                        LEFT JOIN TB04010 Tab ON Tab.TB04010_CODIGO = Func.TB04010_CODIGO
                        LEFT JOIN TB04003 TipoDoc ON TipoDoc.TB04003_CODIGO = Tab.TB04010_TIPDOC
                    ";
                    
                $stmt = sqlsrv_query($conn, $sql);
                ?>
                <tbody>
                    <?php
                    function formatarMoeda($valor)
                    {
                        return 'R$ ' . number_format((float) $valor, 2, ',', '.');
                    }
                    $totalTitulo = 0;
                    $totalPago = 0;

                    $tabela = "";

                    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                        $titulo = (float) $row['TB04010_VLRTITULO'];
                        $pago = (float) $row['TB04010_VLRPAGO'];

                        $totalTitulo += $titulo;
                        $totalPago += $pago;

                        $tabela .= "<tr>";
                        $tabela .= "<td>$row[TB04010_CODIGO]</td>";
                        $tabela .= "<td>$row[TB04010_CODEMP]</td>";
                        $tabela .= "<td>$row[TB04010_DTCAD]</td>";
                        $tabela .= "<td>$row[TB04010_DTVENC]</td>";
                        $tabela .= "<td>$row[TB04010_DTVENCORIGINAL]</td>";
                        $tabela .= "<td>$row[DIEFEREÇA_DIAS]</td>";
                        $tabela .= "<td>$row[TB04011_DTBAIXA]</td>";
                        $tabela .= "<td>$row[NOMECLIENTE]</td>";
                        $tabela .= "<td>" . formatarMoeda($titulo) . "</td>";
                        $tabela .= "<td>" . formatarMoeda($pago) . "</td>";
                        $tabela .= "<td>$row[TB04003_NOME]</td>";
                        $tabela .= "<td></td>";
                        $tabela .= "</tr>";
                    }
                    print ($tabela);
                    ?>

                </tbody>
                <tfoot>
                    <tr style="font-size: 0.75rem; font-weight: normal; color: #555;">
                        <th colspan="8" style="text-align: right;">Totais:</th>
                        <th><?= formatarMoeda($totalTitulo) ?></th>
                        <th><?= formatarMoeda($totalPago) ?></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <script src="../../public/JS/script.js" charset="utf-8"></script>
</body>

</html>