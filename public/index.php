<?php
header('Content-type: text/html; charset=ISO-8895-1');

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../public/CSS/index.css">
  <title>TINSEI - Painel Financeiro</title>
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
    <div class="month-card">
      <div class="month-title">JANEIRO</div>
      <table>
        <thead>
          <tr>
            <th>Períodos</th>
            <th>Valor Aberto</th>
            <th>Valor Pago</th>
          </tr>
        </thead>
        <tbody>
          <tr><td>0 a 30 dias</td><td>100.000,00</td><td>50.000,00</td></tr>
          <tr><td>31 a 90 dias</td><td>80.000,00</td><td>30.000,00</td></tr>
          <tr><td>91 a 365 dias</td><td>120.000,00</td><td>60.000,00</td></tr>
          <tr><td>Acima de 365 dias</td><td>50.000,00</td><td>20.000,00</td></tr>
          <tr class="total-row"><td>Total</td><td>350.000,00</td><td>160.000,00</td></tr>
        </tbody>
      </table>
    </div>

    <!-- Copie e edite o conteúdo acima para FEVEREIRO a DEZEMBRO -->
    
    </div>
  </div>

</body>
</html>
