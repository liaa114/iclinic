<?php
$this->pageTitle = 'Tambah Pasien';
?>

<div class="form-wrapper">
    <div class="section">
        <div class="url-section">
            <h2>Tambah Pasien</h2>
            <span>|</span>
            <a href="#"><i class='bx bx-home-alt'></i></a>
            <span class="url-rout">></span>
            <a href="<?php echo Yii::app()->createUrl('site/pasien'); ?>">Pasien</a>
            <span class="url-rout">></span>
            <span>Tambah</span>
        </div>

        <div class="action-card-header">
            <h2>Informasi Pasien</h2>
            <p>Masukkan data pasien dengan lengkap dan benar.</p>
        </div>
    </div>

    <div class="form-container">
        <?php echo CHtml::beginForm(); ?>

        <div class="form-group">
            <?php echo CHtml::label('Nama', 'nama'); ?>
            <?php echo CHtml::textField('Pasien[nama]', $model->nama); ?>
            <?php echo CHtml::error($model, 'nama'); ?>
        </div>

        <div class="form-group">
            <?php echo CHtml::label('NIK', 'nik'); ?>
            <?php echo CHtml::textField('Pasien[nik]', $model->nik, array('maxlength' => 16)); ?>
            <?php echo CHtml::error($model, 'nik'); ?>
        </div>

        <div class="form-group">
            <?php echo CHtml::label('Wilayah', 'alamat'); ?>
            <?php
            $wilayahList = CHtml::listData(Wilayah::model()->findAll(), 'id', function ($wilayah) {
                return $wilayah->provinsi . ' - ' . $wilayah->kabupaten . ' - ' . $wilayah->kecamatan;
            });
            echo CHtml::dropDownList('Pasien[alamat]', $model->alamat, $wilayahList, ['prompt' => '-- Pilih Wilayah --']);
            ?>
            <?php echo CHtml::error($model, 'alamat'); ?>
        </div>


        <div class="form-group">
            <?php echo CHtml::label('Tanggal Lahir', 'tanggal_lahir'); ?>
            <input type="date" name="Pasien[tanggal_lahir]" value="<?php echo CHtml::encode($model->tanggal_lahir); ?>">
            <?php echo CHtml::error($model, 'tanggal_lahir'); ?>
        </div>

        <div class="form-group">
            <?php echo CHtml::label('Jenis Kelamin', 'jenis_kelamin'); ?>
            <?php echo CHtml::dropDownList('Pasien[jenis_kelamin]', $model->jenis_kelamin, ['L' => 'Laki-laki', 'P' => 'Perempuan'], ['prompt' => '-- Pilih Jenis Kelamin --']); ?>
            <?php echo CHtml::error($model, 'jenis_kelamin'); ?>
        </div>

        <div class="form-group">
            <?php echo CHtml::label('Jenis Kunjungan', 'kunjungan_id'); ?>
            <?php echo CHtml::dropDownList(
                'Pasien[kunjungan_id]',
                $model->kunjungan_id,
                CHtml::listData(Kunjungan::model()->findAll(), 'id', 'jenis_kunjungan'),
                ['prompt' => '-- Pilih Jenis Kunjungan --']
            ); ?>
            <?php echo CHtml::error($model, 'kunjungan_id'); ?>
        </div>

        <div class="form-group">
            <?php echo CHtml::label('Keterangan Kunjungan', 'keterangan_kunjungan'); ?>
            <?php echo CHtml::textArea('Pasien[keterangan_kunjungan]', $model->keterangan_kunjungan); ?>
            <?php echo CHtml::error($model, 'keterangan_kunjungan'); ?>
        </div>

        <div class="form-group">
            <?php echo CHtml::label('Dokter Penanggung Jawab', 'user_id'); ?>
            <?php
            $dokterList = CHtml::listData(
                Users::model()->findAll("role = 'Dokter'"),
                'id',
                'nama_lengkap'
            );
            echo CHtml::dropDownList('Pasien[user_id]', $model->user_id, $dokterList, ['prompt' => '-- Pilih Dokter --']);
            ?>
            <?php echo CHtml::error($model, 'user_id'); ?>
        </div>

        <div class="form-actions">
            <?php echo CHtml::submitButton('Simpan', ['class' => 'btn btn-save']); ?>
            <button type="button" class="btn btn-cancel" onclick="window.history.back()">Batal</button>
        </div>

        <?php echo CHtml::endForm(); ?>
    </div>
</div>