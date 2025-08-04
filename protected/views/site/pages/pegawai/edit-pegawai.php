<?php
$this->pageTitle = 'Edit Pegawai';
?>

<div class="form-wrapper">
    <div class="section">
        <div class="url-section">
            <h2>Edit Pegawai</h2>
            <span>|</span>
            <a href="#"><i class='bx bx-home-alt'></i></a>
            <span class="url-rout">></span>
            <a href="<?php echo Yii::app()->createUrl('site/pegawai'); ?>">Pegawai</a>
            <span class="url-rout">></span>
            <span>Edit</span>
        </div>

        <div class="action-card-header">
            <h2>Informasi Pegawai</h2>
            <p>Perbarui informasi pegawai sesuai kebutuhan.</p>
        </div>
    </div>

    <div class="form-container">
        <?php echo CHtml::beginForm(); ?>

        <div class="form-group">
            <?php echo CHtml::label('Nama', 'nama'); ?>
            <?php echo CHtml::textField('Pegawai[nama]', $model->nama); ?>
            <?php echo CHtml::error($model, 'nama'); ?>
        </div>

        <div class="form-group">
            <?php echo CHtml::label('Jabatan', 'jabatan'); ?>
            <?php echo CHtml::textField('Pegawai[jabatan]', $model->jabatan); ?>
        </div>

        <div class="form-group">
            <?php echo CHtml::label('Alamat', 'alamat'); ?>
            <?php echo CHtml::textArea('Pegawai[alamat]', $model->alamat); ?>
            <?php echo CHtml::error($model, 'alamat'); ?>
        </div>

        <div class="form-group">
            <?php echo CHtml::label('No HP', 'no_hp'); ?>
            <?php echo CHtml::textField('Pegawai[no_hp]', $model->no_hp); ?>
        </div>

        <div class="form-group">
            <?php echo CHtml::label('Email', 'email'); ?>
            <?php echo CHtml::textField('Pegawai[email]', $model->email, ['type' => 'email']); ?>
            <?php echo CHtml::error($model, 'email'); ?>
        </div>

        <div class="form-actions">
            <?php echo CHtml::submitButton('Simpan', ['class' => 'btn btn-save']); ?>
            <button type="button" class="btn btn-cancel" onclick="window.history.back()">Batal</button>
        </div>

        <?php echo CHtml::endForm(); ?>
    </div>
</div>
