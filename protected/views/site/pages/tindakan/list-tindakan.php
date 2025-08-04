<?php $this->pageTitle = 'Data Tindakan'; ?>

<div class="url-section">
  <h2>Data Tindakan</h2>
  <span>|</span>
  <a href="<?php echo Yii::app()->createUrl('site/dashboard'); ?>"><i class="fa-solid fa-house"></i></a>
  <span class="url-rout">></span>
  <a href="<?php echo Yii::app()->createUrl('site/tindakan'); ?>">Tindakan</a>
</div>

<div class="add-btn">
  <a href="<?php echo Yii::app()->createUrl('site/addTindakan'); ?>" class="btn-add-user">
    Tambah Data
  </a>
</div>

<div class="table-container">
  <table id="tindakan-table" class="table-style display">
    <thead>
      <tr>
        <th>No</th>
        <th>Nama Tindakan</th>
        <th>Deskripsi</th>
        <th>Harga</th>
        <th style="text-align: center;">Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($tindakan as $index => $t): ?>
        <tr>
          <td><?= $index + 1; ?></td>
          <td><?= CHtml::encode($t->nama_tindakan); ?></td>
          <td><?= CHtml::encode($t->deskripsi); ?></td>
          <td>Rp <?= number_format($t->harga, 0, ',', '.'); ?></td>
          <td style="text-align: center;">
            <div class="action-btns">
              <a href="<?= Yii::app()->createUrl('site/editTindakan', ['id' => $t->id]); ?>">
                <button><i class="fas fa-pen"></i></button>
              </a>
              <a href="javascript:void(0);" class="btn-delete" data-id="<?= $t->id; ?>">
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
    $('#tindakan-table').DataTable({
      responsive: true,
      pageLength: 10,
      language: {
        search: "Cari:",
        zeroRecords: "Tidak ada data ditemukan",
        infoEmpty: "Tidak ada data tersedia",
        infoFiltered: "(difilter dari total data)",
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
      const deleteUrl = '<?php echo Yii::app()->createUrl("site/deleteTindakan"); ?>' + '?id=' + id;

      Swal.fire({
        title: 'Yakin ingin menghapus?',
        text: "Data yang dihapus tidak bisa dikembalikan!",
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
