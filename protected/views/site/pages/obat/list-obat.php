<?php $this->pageTitle = 'Data Obat'; ?>

<div class="url-section">
  <h2>Data Obat</h2>
  <span>|</span>
  <a href="<?php echo Yii::app()->createUrl('site/dashboard'); ?>"><i class="fa-solid fa-house"></i></a>
  <span class="url-rout">></span>
  <a href="<?php echo Yii::app()->createUrl('site/obat'); ?>">Obat</a>
</div>

<div class="add-btn">
  <a href="<?php echo Yii::app()->createUrl('site/addObat'); ?>" class="btn-add-user">
    Tambah Obat
  </a>
</div>

<div class="table-container">
  <table class="table-style display" id="obat-table">
    <thead>
      <tr>
        <th>No</th>
        <th>Nama Obat</th>
        <th>Satuan</th>
        <th>Harga</th>
        <th>Stok</th>
        <th style="text-align:center;">Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($obat as $index => $o): ?>
        <tr>
          <td><?= $index + 1; ?></td>
          <td><?= CHtml::encode($o->nama_obat); ?></td>
          <td><?= CHtml::encode($o->satuan); ?></td>
          <td>Rp <?= number_format($o->harga, 0, ',', '.'); ?></td>
          <td><?= CHtml::encode($o->stok); ?></td>
          <td style="text-align:center;">
            <div class="action-btns">
              <a href="<?php echo Yii::app()->createUrl('site/editObat', ['id' => $o->id]); ?>">
                <button><i class="fas fa-pen"></i></button>
              </a>
              <a href="javascript:void(0);" class="btn-delete" data-id="<?= $o->id; ?>">
                <button><i class="fas fa-trash"></i></button>
              </a>
            </div>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<script>
  $(document).ready(function () {
    $('#obat-table').DataTable({
      responsive: true,
      pageLength: 10,
      language: {
        search: "Cari:",
        zeroRecords: "Tidak ada data ditemukan",
        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
        infoEmpty: "Tidak ada data tersedia",
        infoFiltered: "(difilter dari total _MAX_ data)",
        lengthMenu: "Tampilkan _MENU_ data",
        paginate: {
          first: "Awal",
          last: "Akhir",
          next: "Berikutnya",
          previous: "Sebelumnya"
        },
      }
    });

    $('.btn-delete').on('click', function () {
      const id = $(this).data('id');
      const deleteUrl = '<?php echo Yii::app()->createUrl("site/deleteObat"); ?>' + '?id=' + id;

      Swal.fire({
        title: 'Yakin ingin menghapus?',
        text: "Data obat akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#76BA99',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = deleteUrl;
        }
      });
    });
  });
</script>
