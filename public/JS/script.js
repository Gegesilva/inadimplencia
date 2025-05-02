  function enviarDetalhes(ano, mes, periodo) {
    document.getElementById('formAno').value = ano;
    document.getElementById('formMes').value = mes;
    document.getElementById('formPeriodo').value = periodo;
    document.getElementById('detalForm').submit();
  }
