<?php
$this->pageTitle = 'Edit Wilayah';
?>

<div class="form-wrapper">
    <div class="section">
        <div class="url-section">
            <h2>Edit Wilayah</h2>
            <span>|</span>
            <a href="<?php echo Yii::app()->createUrl('site/dashboard'); ?>"><i class='bx bx-home-alt'></i></a>
            <span class="url-rout">></span>
            <a href="<?php echo Yii::app()->createUrl('site/wilayah'); ?>">Wilayah</a>
            <span class="url-rout">></span>
            <span>Edit</span>
        </div>

        <div class="action-card-header">
            <h2>Informasi Wilayah</h2>
            <p>Pastikan data wilayah diisi dengan lengkap dan benar.</p>
        </div>
    </div>

    <div class="form-container">
        <?php echo CHtml::beginForm(); ?>

        <div class="form-group">
            <?php echo CHtml::label('Provinsi', 'provinsi'); ?>
            <?php echo CHtml::textField('Wilayah[provinsi]', $model->provinsi); ?>
            <?php echo CHtml::error($model, 'provinsi'); ?>
        </div>

        <div class="form-group">
            <?php echo CHtml::label('Kabupaten', 'kabupaten'); ?>
            <?php echo CHtml::textField('Wilayah[kabupaten]', $model->kabupaten); ?>
            <?php echo CHtml::error($model, 'kabupaten'); ?>
        </div>

        <div class="form-group">
            <?php echo CHtml::label('Kecamatan', 'kecamatan'); ?>
            <?php echo CHtml::textField('Wilayah[kecamatan]', $model->kecamatan); ?>
            <?php echo CHtml::error($model, 'kecamatan'); ?>
        </div>

        <div class="form-actions">
            <?php echo CHtml::submitButton('Simpan', ['class' => 'btn btn-save']); ?>
            <button type="button" class="btn btn-cancel" onclick="window.history.back()">Batal</button>
        </div>

        <?php echo CHtml::endForm(); ?>
    </div>
</div>
