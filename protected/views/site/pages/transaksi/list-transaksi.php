<?php $this->pageTitle = 'Riwayat Transaksi'; ?>

<div class="url-section">
  <h2>Riwayat Transaksi</h2>
  <span>|</span>
  <a href="<?php echo Yii::app()->createUrl('site/dashboard'); ?>"><i class="fa-solid fa-house"></i></a>
  <span class="url-rout">></span>
  <a href="#">Transaksi</a>
</div>

<?php if (Yii::app()->user->hasFlash('success')): ?>
  <div class="alert alert-success">
    <?php echo Yii::app()->user->getFlash('success'); ?>
  </div>
<?php endif; ?>

<div class="table-container">
  <table class="table-style display" id="transaksi-table">
    <thead>
      <tr>
        <th>No</th>
        <th>Pasien</th>
        <th>Dokter</th>
        <th>Tindakan</th>
        <th>Harga Tindakan</th>
        <th>Obat</th>
        <th>Jumlah Obat</th>
        <th>Harga Obat</th>
        <th>Tanggal Kunjungan</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($transaksiList as $index => $t): ?>
        <tr>
          <td><?= $index + 1; ?></td>
          <td><?= CHtml::encode($t->pasien->nama); ?></td>
          <td><?= CHtml::encode($t->users ? $t->users->nama_lengkap : '-'); ?></td>
          <td><?= CHtml::encode($t->tindakan->nama_tindakan); ?></td>
          <td>Rp <?= number_format($t->total_harga, 0, ',', '.'); ?></td>
          <td>
            <?php foreach ($t->transaksiObats as $i => $to): ?>
              <?= ($i + 1) . '. ' . CHtml::encode($to->obat->nama_obat); ?><br>
            <?php endforeach; ?>
          </td>
          <td>
            <?php foreach ($t->transaksiObats as $to): ?>
              <?= CHtml::encode($to->jumlah); ?><br>
            <?php endforeach; ?>
          </td>
          <td>
            <?php foreach ($t->transaksiObats as $to): ?>
              Rp <?= number_format($to->total_harga, 0, ',', '.'); ?><br>
            <?php endforeach; ?>
          </td>
          <td>
            <?= date('Y-m-d', strtotime($t->tanggal_kunjungan)); ?><br>
            <?= date('H:i:s', strtotime($t->tanggal_kunjungan)); ?>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<script>
  $(document).ready(function () {
    $('#transaksi-table').DataTable({
      responsive: true,
      pageLength: 10,
      language: {
        search: "Cari:",
        zeroRecords: "Tidak ada data ditemukan",
        infoEmpty: "Tidak ada data tersedia",
        infoFiltered: "(difilter dari total data)",
        paginate: {
          first: "Awal",
          last: "Akhir",
          next: "Berikutnya",
          previous: "Sebelumnya"
        },
      }
    });
  });
</script>
