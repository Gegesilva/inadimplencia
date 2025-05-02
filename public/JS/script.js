  function parseValor(valor) {
    // Remove pontos de milhar e troca vírgula decimal por ponto
    return parseFloat(valor.replace(/\./g, '').replace(',', '.')) || 0;
  }

  const card = document.querySelector('.month-card');
  const linhas = card.querySelectorAll('tbody tr:not(.total-row)');
  let totalAberto = 0;
  let totalPago = 0;

  linhas.forEach(linha => {
    const celulas = linha.querySelectorAll('td');
    totalAberto += parseValor(celulas[1].innerText);
    totalPago += parseValor(celulas[2].innerText);
  });

  // Atualiza os valores na linha de total
  const linhaTotal = card.querySelector('tr.total-row');
  linhaTotal.cells[1].innerText = totalAberto.toLocaleString('pt-BR', { minimumFractionDigits: 2 });
  linhaTotal.cells[2].innerText = totalPago.toLocaleString('pt-BR', { minimumFractionDigits: 2 });
