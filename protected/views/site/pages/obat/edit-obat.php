<?php
$this->pageTitle = $this->action->id === 'addObat' ? 'Tambah Obat' : 'Edit Obat';
?>

<div class="form-wrapper">
    <div class="section">
        <div class="url-section">
            <h2><?php echo $this->action->id === 'addObat' ? 'Tambah' : 'Edit'; ?> Obat</h2>
            <span>|</span>
            <a href="#"><i class='bx bx-home-alt'></i></a>
            <span class="url-rout">></span>
            <a href="<?php echo Yii::app()->createUrl('site/obat'); ?>">Obat</a>
            <span class="url-rout">></span>
            <span><?php echo $this->action->id === 'addObat' ? 'Tambah' : 'Edit'; ?></span>
        </div>

        <div class="action-card-header">
            <h2>Informasi Obat</h2>
            <p>Silakan isi data obat dengan benar.</p>
        </div>
    </div>

    <div class="form-container">
        <?php echo CHtml::beginForm(); ?>

        <div class="form-group">
            <?php echo CHtml::label('Nama Obat', 'nama_obat'); ?>
            <?php echo CHtml::textField('Obat[nama_obat]', $model->nama_obat); ?>
            <?php echo CHtml::error($model, 'nama_obat'); ?>
        </div>

        <div class="form-group">
            <?php echo CHtml::label('Satuan', 'satuan'); ?>
            <?php echo CHtml::textField('Obat[satuan]', $model->satuan); ?>
            <?php echo CHtml::error($model, 'satuan'); ?>
        </div>

        <div class="form-group">
            <?php echo CHtml::label('Harga', 'harga'); ?>
            <?php echo CHtml::textField('Obat[harga]', $model->harga); ?>
            <?php echo CHtml::error($model, 'harga'); ?>
        </div>

        <div class="form-group">
            <?php echo CHtml::label('Stok', 'stok'); ?>
            <?php echo CHtml::textField('Obat[stok]', $model->stok); ?>
            <?php echo CHtml::error($model, 'stok'); ?>
        </div>

        <div class="form-actions">
            <?php echo CHtml::submitButton('Simpan', ['class' => 'btn btn-save']); ?>
            <button type="button" class="btn btn-cancel" onclick="window.history.back()">Batal</button>
        </div>

        <?php echo CHtml::endForm(); ?>
    </div>
</div>
