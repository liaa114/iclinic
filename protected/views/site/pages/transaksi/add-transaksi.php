<?php

/** @var Transaksi $model */
$this->pageTitle = 'Tambah Transaksi';
?>

<!-- Tambahkan ini di head jika belum -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div class="form-wrapper">
    <div class="section">
        <div class="url-section">
            <h2>Tambah Transaksi</h2>
            <span>|</span>
            <a href="#"><i class='bx bx-home-alt'></i></a>
            <span class="url-rout">></span>
            <a href="<?php echo Yii::app()->createUrl('site/dashboard'); ?>">Dashboard</a>
            <span class="url-rout">></span>
            <span>Tambah Transaksi</span>
        </div>

        <div class="action-card-header">
            <h2>Form Transaksi</h2>
            <p>Masukkan data transaksi pasien</p>
        </div>
    </div>

    <div class="form-container">
        <?php echo CHtml::beginForm('', 'post', ['id' => 'form-transaksi']); ?>

        <div class="form-group">
            <label for="pasien_id">Pasien</label>
            <select name="Transaksi[pasien_id]" required>
                <option value="">-- Pilih Pasien --</option>
                <?php foreach ($pasienList as $p): ?>
                    <option value="<?= $p->id ?>"
                        <?= isset($postData['Transaksi']['pasien_id']) && $postData['Transaksi']['pasien_id'] == $p->id ? 'selected' : '' ?>>
                        <?= CHtml::encode($p->nama); ?>
                    </option>
                <?php endforeach; ?>
            </select>

        </div>

        <div class="form-group">
            <?php echo CHtml::label('Tindakan', 'tindakan_id'); ?>
            <?php echo CHtml::dropDownList(
                'Transaksi[tindakan_id]',
                isset($postData['Transaksi']['tindakan_id']) ? $postData['Transaksi']['tindakan_id'] : '',
                CHtml::listData($tindakanList, 'id', 'nama_tindakan'),
                ['prompt' => '-- Pilih Tindakan --']
            ); ?>

        </div>

        <div class="form-group">
            <label>Obat & Jumlah</label>
            <div id="obat-container">
                <?php
                $obatIds = isset($postData['obat_id']) ? $postData['obat_id'] : [''];
                $jumlahObat = isset($postData['jumlah_obat']) ? $postData['jumlah_obat'] : ['1'];

                foreach ($obatIds as $index => $obatId):
                ?>
                    <div class="obat-row" style="margin-bottom: 8px;">
                        <select name="obat_id[]" required>
                            <option value="">-- Pilih Obat --</option>
                            <?php foreach ($obatList as $obat): ?>
                                <option value="<?= $obat->id ?>"
                                    <?= $obatId == $obat->id ? 'selected' : '' ?>>
                                    <?= CHtml::encode($obat->nama_obat); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <input type="number" name="jumlah_obat[]" placeholder="Jumlah" min="1"
                            value="<?= isset($jumlahObat[$index]) ? $jumlahObat[$index] : '1' ?>" required>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php if (Yii::app()->user->hasFlash('error')): ?>
                <div class="alert alert-danger">
                    <?php echo Yii::app()->user->getFlash('error'); ?>
                </div>
            <?php endif; ?>

            <button type="button" id="add-obat" class="btn btn-secondary" style="margin-top: 10px;">+ Tambah Obat</button>
        </div>

        <div class="form-actions" style="margin-top: 20px;">
            <?php echo CHtml::submitButton('Simpan', ['class' => 'btn btn-save']); ?>
            <button type="button" class="btn btn-cancel" onclick="window.history.back()">Batal</button>
        </div>

        <?php echo CHtml::endForm(); ?>
    </div>
</div>

<script>
    const container = document.getElementById('obat-container');

    function refreshRemoveButtons() {
        const rows = container.querySelectorAll('.obat-row');
        rows.forEach((row, index) => {
            let btn = row.querySelector('.btn-remove-obat');

            if (index === 0) {
                if (btn) btn.remove();
            } else {
                if (!btn) {
                    btn = document.createElement('button');
                    btn.type = 'button';
                    btn.className = 'btn-remove-obat';
                    btn.style.cssText = `
                    background-color: white;
                    color: black;
                    border: 1px solid #ccc;
                    padding: 4px 8px;
                    border-radius: 4px;
                    cursor: pointer;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    height: 32px;
                `;
                    btn.innerHTML = '<i class="fa-solid fa-window-minimize"></i>';
                    row.appendChild(btn);
                }
            }
        });
    }

    document.getElementById('add-obat').addEventListener('click', function() {
        const row = document.createElement('div');
        row.classList.add('obat-row');
        row.style.cssText = `
        margin-bottom: 5px;
        display: flex;
        align-items: center;
        gap: 5px;
    `;
        row.innerHTML = `
        <select name="obat_id[]" required>
            <option value="">-- Pilih Obat --</option>
            <?php foreach ($obatList as $obat): ?>
                <option value="<?= $obat->id; ?>"><?= CHtml::encode($obat->nama_obat); ?></option>
            <?php endforeach; ?>
        </select>
        <input type="number" name="jumlah_obat[]" placeholder="Jumlah" min="1" value="1" required>
    `;
        container.appendChild(row);
        refreshRemoveButtons();
    });


    container.addEventListener('click', function(e) {
        if (e.target.closest('.btn-remove-obat')) {
            e.target.closest('.obat-row').remove();
            refreshRemoveButtons();
        }
    });

    window.addEventListener('load', refreshRemoveButtons);
</script>