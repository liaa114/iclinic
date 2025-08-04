<h1>Dashboard Klinik</h1>

<div class="cards">
  <div class="card">
    <h3>Jumlah Obat Tersedia</h3>
    <p><?= CHtml::encode($totalObat) ?></p>
  </div>
  <div class="card">
    <h3>Pasien Hari Ini</h3>
    <p><?= CHtml::encode($jumlahPasienHariIni) ?></p>
  </div>
  <div class="card">
    <h3>Kunjungan Bulan Ini</h3>
    <p><?= CHtml::encode($jumlahKunjunganBulanIni) ?></p>
  </div>
  <div class="card">
    <h3>Total Tindakan</h3>
    <p><?= CHtml::encode($totalTindakan) ?></p>
  </div>
</div>

<!-- Grafik -->
<div class="charts">
  <div class="chart-card">
    <h3 style="text-align:center;">Obat Paling Sering Diresepkan</h3>
    <canvas id="obatChart"></canvas>
  </div>

  <div class="chart-card">
    <h3 style="text-align:center;">Kunjungan Pasien per Bulan</h3>
    <canvas id="kunjunganChart"></canvas>
  </div>
</div>

<div class="charts">
  <div class="chart-card pie-chart-card">
    <h3 style="text-align:center;">Tindakan Medis Terbanyak</h3>
    <canvas id="tindakanChart"></canvas>
  </div>
  <div class="chart-card calendar-card">
    <h3 style="text-align:center;">
      <button id="prevMonthBtn">&#8249;</button>
      <span id="calendarTitle"></span>
      <button id="nextMonthBtn">&#8250;</button>
    </h3>
    <table id="calendarTable" class="calendar-table">
      <thead>
        <tr>
          <th>Min</th>
          <th>Sen</th>
          <th>Sel</th>
          <th>Rab</th>
          <th>Kam</th>
          <th>Jum</th>
          <th>Sab</th>
        </tr>
      </thead>
      <tbody id="calendarBody"></tbody>
    </table>
  </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  const dataObat = {
    labels: <?= json_encode(array_column($obatSering, 'nama_obat')) ?>,
    data: <?= json_encode(array_map(fn($item) => (int)$item['total_resep'], $obatSering)) ?>
  };

  const dataKunjungan = {
    labels: <?= json_encode(array_column($kunjunganBulan, 'bulan')) ?>,
    data: <?= json_encode(array_map(fn($item) => (int)$item['jumlah'], $kunjunganBulan)) ?>
  };

  const dataTindakan = {
    labels: <?= json_encode(array_column($tindakanTerbanyak, 'nama_tindakan')) ?>,
    data: <?= json_encode(array_map(fn($item) => (int)$item['jumlah'], $tindakanTerbanyak)) ?>
  };

  new Chart(document.getElementById('obatChart'), {
    type: 'bar',
    data: {
      labels: dataObat.labels,
      datasets: [{
        label: 'Jumlah Resep',
        data: dataObat.data,
        backgroundColor: '#76BA99'
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          display: false
        }
      },
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });

  new Chart(document.getElementById('kunjunganChart'), {
    type: 'line',
    data: {
      labels: dataKunjungan.labels,
      datasets: [{
        label: 'Jumlah Pasien',
        data: dataKunjungan.data,
        borderColor: '#305f72',
        backgroundColor: 'rgba(48,95,114,0.1)',
        fill: true,
        tension: 0.3
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          display: false
        }
      },
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });

  new Chart(document.getElementById('tindakanChart'), {
    type: 'pie',
    data: {
      labels: dataTindakan.labels,
      datasets: [{
        data: dataTindakan.data,
        backgroundColor: ['#76BA99', '#ADCFB6', '#F4EBC1', '#F5A25D', '#D97D54']
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'bottom'
        }
      }
    }
  });

  const calendarTitle = document.getElementById('calendarTitle');
  const calendarBody = document.getElementById('calendarBody');
  let currentDate = new Date();
  let currentMonth = currentDate.getMonth();
  let currentYear = currentDate.getFullYear();

  function renderCalendar(month, year) {
    const monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
      'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];

    const firstDay = new Date(year, month).getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    calendarTitle.textContent = `${monthNames[month]} ${year}`;
    calendarBody.innerHTML = '';

    let date = 1;
    for (let i = 0; i < 6; i++) {
      const row = document.createElement('tr');
      for (let j = 0; j < 7; j++) {
        const cell = document.createElement('td');
        if (i === 0 && j < (firstDay === 0 ? 6 : firstDay - 1)) {
          cell.innerHTML = '';
        } else if (date > daysInMonth) {
          break;
        } else {
          cell.textContent = date;
          if (date === currentDate.getDate() && month === currentDate.getMonth() && year === currentDate.getFullYear()) {
            cell.style.backgroundColor = '#9BE8D8';
            cell.style.color = 'white';
          }
          date++;
        }
        row.appendChild(cell);
      }
      calendarBody.appendChild(row);
      if (date > daysInMonth) break;
    }
  }

  document.getElementById('prevMonthBtn').addEventListener('click', function() {
    currentMonth--;
    if (currentMonth < 0) {
      currentMonth = 11;
      currentYear--;
    }
    renderCalendar(currentMonth, currentYear);
  });

  document.getElementById('nextMonthBtn').addEventListener('click', function() {
    currentMonth++;
    if (currentMonth > 11) {
      currentMonth = 0;
      currentYear++;
    }
    renderCalendar(currentMonth, currentYear);
  });

  renderCalendar(currentMonth, currentYear);
</script>