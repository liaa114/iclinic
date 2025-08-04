<?php $this->pageTitle = 'Edit Kunjungan'; ?>

<div class="form-wrapper">
  <div class="section">
    <div class="url-section">
      <h2>Edit Kunjungan</h2>
      <span>|</span>
      <a href="#"><i class='bx bx-home-alt'></i></a>
      <span class="url-rout">></span>
      <a href="<?php echo Yii::app()->createUrl('site/kunjungan'); ?>">Kunjungan</a>
      <span class="url-rout">></span>
      <span>Edit</span>
    </div>

    <div class="action-card-header">
      <h2>Informasi Kunjungan</h2>
      <p>Perbarui data kunjungan sesuai kebutuhan.</p>
    </div>
  </div>

  <div class="form-container">
    <?php echo CHtml::beginForm(); ?>

    <div class="form-group">
      <?php echo CHtml::label('Jenis Kunjungan', 'jenis_kunjungan'); ?>
      <?php echo CHtml::textField('Kunjungan[jenis_kunjungan]', $model->jenis_kunjungan); ?>
      <?php echo CHtml::error($model, 'jenis_kunjungan'); ?>
    </div>

    <div class="form-group">
      <?php echo CHtml::label('Keterangan', 'keterangan'); ?>
      <?php echo CHtml::textArea('Kunjungan[keterangan]', $model->keterangan); ?>
      <?php echo CHtml::error($model, 'keterangan'); ?>
    </div>

    <div class="form-actions">
      <?php echo CHtml::submitButton('Simpan', ['class' => 'btn btn-save']); ?>
      <button type="button" class="btn btn-cancel" onclick="window.history.back()">Batal</button>
    </div>

    <?php echo CHtml::endForm(); ?>
  </div>
</div>
