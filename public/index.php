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
      <label for="year">Data: </label>
      <select id="year"> 
        <option value="2024">2024</option>
        <option value="2023">2023</option>
        <!-- Adicione mais anos aqui -->
      </select>
    </div>
  </div>

  <div class="month-grid">


    <!-- Exemplo de um mês (repita para os outros) -->
      <?php
            $sql = "SELECT 
                    MES,
                    PERIODO0A30_TITULO,
                    PERIODO0A90_TITULO,
                    PERIODO0A365_TITULO,

                    PERIODO0A30_PAGO,
                    PERIODO0A90_PAGO,
                    PERIODO0A365_PAGO
                FROM FTVENCIDO(2024)
        ";
        ?>
            <tbody>
        <?php
         $stmt = sqlsrv_query($conn, $sql);
         $tabela = "";
         while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
             $tabela .= "<div class='month-card'>";
             $tabela .= "<div class='month-title1'>$row[MES]</div>";
             $tabela .= "<table>";
             $tabela .= "<thead>";
             $tabela .= "<tr>";
             $tabela .= "<th>Períodos</th>";
             $tabela .= "<th>Valor Aberto</th>";
             $tabela .= "<th>Valor Pago</th>";
             $tabela .= "</tr>";
             $tabela .= "</thead>";
             $tabela .= "<tr><td>0 a 30 dias</td><td>$row[PERIODO0A30_TITULO]</td><td>$row[PERIODO0A30_PAGO]</td></tr>";
             $tabela .= "<tr><td>0 a 90 dias</td><td>$row[PERIODO0A90_TITULO]</td><td>$row[PERIODO0A90_PAGO]</td></tr>";
             $tabela .= "<tr><td>0 a 365 dias</td><td>10.000,00</td><td>60.000,00</td></tr>";
             $tabela .= "<tr class='total-row'><td>Total</td><td>350.000,00</td><td>160.000,00</td></tr>";
             $tabela .= "</tbody>";
             $tabela .= "</table>";
             $tabela .= " </div>";
             }
 
         echo $tabela;
        
        ?> 

    <!-- Copie e edite o conteúdo acima para FEVEREIRO a DEZEMBRO -->
    
    </div>
  </div>
  <script src="JS/script.js" charset="utf-8"></script>
</body>
</html>
