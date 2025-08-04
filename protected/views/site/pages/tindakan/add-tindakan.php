<?php
$this->pageTitle = 'Tambah Tindakan';
?>

<div class="form-wrapper">
    <div class="section">
        <div class="url-section">
            <h2>Tambah Tindakan</h2>
            <span>|</span>
            <a href="#"><i class='bx bx-home-alt'></i></a>
            <span class="url-rout">></span>
            <a href="<?php echo Yii::app()->createUrl('site/tindakan'); ?>">Tindakan</a>
            <span class="url-rout">></span>
            <span>Tambah</span>
        </div>

        <div class="action-card-header">
            <h2>Informasi Tindakan</h2>
            <p>Pastikan data tindakan diisi dengan benar.</p>
        </div>
    </div>

    <div class="form-container">
        <?php echo CHtml::beginForm(); ?>

        <div class="form-group">
            <?php echo CHtml::label('Nama Tindakan', 'nama_tindakan'); ?>
            <?php echo CHtml::textField('Tindakan[nama_tindakan]', $model->nama_tindakan); ?>
            <?php echo CHtml::error($model, 'nama_tindakan'); ?>
        </div>

        <div class="form-group">
            <?php echo CHtml::label('Deskripsi', 'deskripsi'); ?>
            <?php echo CHtml::textArea('Tindakan[deskripsi]', $model->deskripsi); ?>
        </div>

        <div class="form-group">
            <?php echo CHtml::label('Harga', 'harga'); ?>
            <?php echo CHtml::textField('Tindakan[harga]', $model->harga); ?>
            <?php echo CHtml::error($model, 'harga'); ?>
        </div>

        <div class="form-actions">
            <?php echo CHtml::submitButton('Simpan', ['class' => 'btn btn-save']); ?>
            <button type="button" class="btn btn-cancel" onclick="window.history.back()">Batal</button>
        </div>

        <?php echo CHtml::endForm(); ?>
    </div>
</div>
