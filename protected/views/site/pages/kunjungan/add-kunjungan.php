<?php $this->pageTitle = 'Tambah Kunjungan'; ?>

<!-- CDN SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="form-wrapper">
  <div class="section">
    <div class="url-section">
      <h2>Tambah Kunjungan</h2>
      <span>|</span>
      <a href="#"><i class='bx bx-home-alt'></i></a>
      <span class="url-rout">></span>
      <a href="<?php echo Yii::app()->createUrl('site/kunjungan'); ?>">Kunjungan</a>
      <span class="url-rout">></span>
      <span>Tambah</span>
    </div>

    <div class="action-card-header">
      <h2>Informasi Kunjungan</h2>
      <p>Masukkan data kunjungan dengan lengkap dan benar.</p>
    </div>
  </div>

  <div class="form-container">
    <!-- Form start -->
    <?php echo CHtml::beginForm('', 'post', ['id' => 'form-kunjungan']); ?>

    <div class="form-group">
      <?php echo CHtml::label('Jenis Kunjungan', 'jenis_kunjungan'); ?>
      <?php echo CHtml::textField('Kunjungan[jenis_kunjungan]', $model->jenis_kunjungan, ['class' => 'form-control']); ?>
      <?php echo CHtml::error($model, 'jenis_kunjungan'); ?>
    </div>

    <div class="form-group">
      <?php echo CHtml::label('Keterangan', 'keterangan'); ?>
      <?php echo CHtml::textArea('Kunjungan[keterangan]', $model->keterangan, ['class' => 'form-control']); ?>
      <?php echo CHtml::error($model, 'keterangan'); ?>
    </div>

    <div class="form-actions">
      <!-- Ganti submitButton ke button biasa -->
      <button type="button" class="btn btn-save" id="submit-confirm">Simpan</button>
      <button type="button" class="btn btn-cancel" onclick="window.history.back()">Batal</button>
    </div>

    <?php echo CHtml::endForm(); ?>
    <!-- Form end -->
  </div>
</div>

<!-- JS SweetAlert Validation -->
<script>
  document.getElementById('submit-confirm').addEventListener('click', function () {
    const form = document.getElementById('form-kunjungan');

    // Ambil nilai input
    const jenisKunjungan = form.querySelector('[name="Kunjungan[jenis_kunjungan]"]').value.trim();
    const keterangan = form.querySelector('[name="Kunjungan[keterangan]"]').value.trim();

    // Validasi wajib isi
    if (!jenisKunjungan || !keterangan) {
      Swal.fire({
        icon: 'warning',
        title: 'Form tidak lengkap',
        text: 'Semua kolom harus diisi!',
        confirmButtonColor: '#3085d6'
      });
      return;
    }

    // Konfirmasi sebelum submit
    Swal.fire({
      title: 'Yakin ingin menyimpan?',
      text: "Pastikan data sudah benar.",
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Ya, simpan!',
      cancelButtonText: 'Batal',
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33'
    }).then((result) => {
      if (result.isConfirmed) {
        form.submit();
      }
    });
  });
</script>