  function enviarDetalhes(ano, mes, periodo) {
    document.getElementById('formAno').value = ano;
    document.getElementById('formMes').value = mes;
    document.getElementById('formPeriodo').value = periodo;
    document.getElementById('detalForm').submit();
  }

  function voltar() {
    history.back();
  }


/* Grafico */
document.addEventListener('DOMContentLoaded', () => {
  const ctx = document.getElementById('lineChart').getContext('2d');

  const chart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: chartData.labels,
      datasets: [
        {
          label: '0 a 30 dias',
          data: chartData.datasets.perc0a30,
          borderColor: 'rgba(75, 192, 192, 1)',
          backgroundColor: 'rgba(75, 192, 192, 0.2)',
          tension: 0.3
        },
        {
          label: '0 a 90 dias',
          data: chartData.datasets.perc0a90,
          borderColor: 'rgba(255, 159, 64, 1)',
          backgroundColor: 'rgba(255, 159, 64, 0.2)',
          tension: 0.3
        },
        {
          label: '0 a 365 dias',
          data: chartData.datasets.perc0a365,
          borderColor: 'rgba(153, 102, 255, 1)',
          backgroundColor: 'rgba(153, 102, 255, 0.2)',
          tension: 0.3
        },
        {
          label: 'Global',
          data: chartData.datasets.percall,
          borderColor: 'rgba(255, 99, 132, 1)',
          backgroundColor: 'rgba(255, 99, 132, 0.2)',
          tension: 0.3
        }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            callback: value => value + '%'
          }
        }
      },
      plugins: {
        tooltip: {
          callbacks: {
            label: ctx => ctx.dataset.label + ': ' + ctx.raw + '%'
          },
          titleFont: {weight: 'bold', size: '20px'},
          footerFont: {weight: 'bold', size: '10px'}
        },
        legend: {
          position: 'bottom',
          labels: {
            boxWidth: 60,
            font: {
              size: 20
            }
          }
        },
        title: {
          display: true,
          text: 'Percentual de inadimplência por mês.',
          font: {weight: 'bold', size: '25px'}
        }
      }
    }
  });
});


/* desabilita a manutenção automatica de tamanho do Chart.js para respeitar o CSS */

/* const ctx = document.getElementById('grafico').getContext('2d');
const myChart = new Chart(ctx, {
  type: 'line',
  data: {
    // seus dados
  },
  options: {
    responsive: true,
    maintainAspectRatio: false, // ESSENCIAL para usar o aspect-ratio do CSS
    scales: {
      y: {
        beginAtZero: true
      }
    }
  }
}); */
