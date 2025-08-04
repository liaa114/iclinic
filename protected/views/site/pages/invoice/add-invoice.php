<?php $this->pageTitle = 'Tambah Invoice'; ?>

<div class="form-wrapper">
  <div class="section">
    <div class="url-section">
      <h2>Tambah Invoice</h2>
      <span>|</span>
      <a href="#"><i class='bx bx-home-alt'></i></a>
      <span class="url-rout">></span>
      <a href="<?php echo Yii::app()->createUrl('site/listInvoice'); ?>">Invoice</a>
      <span class="url-rout">></span>
      <span>Tambah</span>
    </div>

    <div class="action-card-header">
      <h2>Tagihan <?= CHtml::encode($transaksi->pasien->nama); ?></h2>
      <p>Pastikan pembayaran sesuai dengan tagihan.</p>
    </div>
  </div>

  <div class="form-container">
    <?php echo CHtml::beginForm(); ?>

    <p><strong>Nama Pasien</strong>: <?= CHtml::encode($transaksi->pasien->nama); ?></p>
    <p><strong>Nama Dokter</strong>: <?= CHtml::encode($transaksi->users ? $transaksi->users->nama_lengkap : '-') ?></p>
    <p><strong>Tanggal Kunjungan</strong>: <?= $transaksi->tanggal_kunjungan; ?></p>
    <p><strong>Tindakan</strong>: <?= $transaksi->tindakan ? $transaksi->tindakan->nama_tindakan : '-'; ?> - Rp <?= number_format($transaksi->total_harga, 0, ',', '.'); ?></p>

    <p><strong>Obat</strong>:</p>
    <ul>
      <?php foreach ($transaksi->transaksiObats as $index => $to): ?>
        <li><?= ($index + 1) . '. ' . $to->obat->nama_obat . ' x' . $to->jumlah . ' - Rp ' . number_format($to->total_harga, 0, ',', '.'); ?></li>
      <?php endforeach; ?>
    </ul>

    <?php
      $totalTagihan = $transaksi->total_harga + array_sum(array_map(fn($to) => $to->total_harga, $transaksi->transaksiObats));
    ?>

    <p><strong>Total Tagihan</strong>: <span id="tagihan_text">Rp <?= number_format($totalTagihan, 0, ',', '.'); ?></span></p>

    <!-- Hidden tagihan value for JS -->
    <input type="hidden" id="total_tagihan" value="<?= $totalTagihan ?>">

    <div class="form-group">
      <?php echo CHtml::label('Total Bayar', 'total_bayar'); ?>
      <?php echo CHtml::textField('Invoice[total_bayar]', '', [
        'id' => 'total_bayar_input',
        'required' => true,
        'style' => 'border:1px solid #ccc;',
      ]); ?>
      <small id="total_bayar_error" style="color:red; display:none;">Total Bayar harus sama dengan Total Tagihan</small>
    </div>

    <div class="form-group">
      <?php echo CHtml::label('Metode Bayar', 'metode_bayar'); ?>
      <?php echo CHtml::textField('Invoice[metode_bayar]', '', ['required' => true]); ?>
    </div>

    <div class="form-actions">
      <?php echo CHtml::submitButton('Simpan', [
        'class' => 'btn btn-save',
        'id' => 'submit_button'
      ]); ?>
      <button type="button" class="btn btn-cancel" onclick="window.history.back()">Batal</button>
    </div>

    <?php echo CHtml::endForm(); ?>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const totalBayarInput = document.getElementById('total_bayar_input');
    const totalTagihan = parseInt(document.getElementById('total_tagihan').value);
    const errorText = document.getElementById('total_bayar_error');
    const submitButton = document.getElementById('submit_button');

    function validateTotalBayar() {
      const entered = parseInt(totalBayarInput.value.replace(/[^\d]/g, ''));

      if (entered === totalTagihan) {
        totalBayarInput.style.border = '2px solid green';
        errorText.style.display = 'none';
        submitButton.disabled = false;
      } else {
        totalBayarInput.style.border = '2px solid red';
        errorText.style.display = 'inline';
        submitButton.disabled = true;
      }
    }

    totalBayarInput.addEventListener('input', validateTotalBayar);
  });
</script>
