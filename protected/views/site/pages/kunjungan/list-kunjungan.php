<?php $this->pageTitle = 'Data Kunjungan'; ?>

<div class="url-section">
  <h2>Data Kunjungan</h2>
  <span>|</span>
  <a href="<?php echo Yii::app()->createUrl('site/dashboard'); ?>"><i class="fa-solid fa-house"></i></a>
  <span class="url-rout">></span>
  <a href="<?php echo Yii::app()->createUrl('site/kunjungan'); ?>">Kunjungan</a>
</div>

<div class="add-btn">
  <a href="<?php echo Yii::app()->createUrl('site/addKunjungan'); ?>" class="btn-add-user">
    Tambah Data
  </a>
</div>

<div class="table-container">
  <table class="table-style display" id="kunjungan-table">
    <thead>
      <tr>
        <th>No</th>
        <th>Jenis Kunjungan</th>
        <th>Keterangan</th>
        <th style="text-align: center;">Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($kunjungan as $index => $k): ?>
        <tr>
          <td><?= $index + 1; ?></td>
          <td><?= CHtml::encode($k->jenis_kunjungan); ?></td>
          <td><?= CHtml::encode($k->keterangan); ?></td>
          <td style="text-align: center;">
            <div class="action-btns">
              <a href="<?= Yii::app()->createUrl('site/editKunjungan', ['id' => $k->id]); ?>">
                <button><i class="fas fa-pen"></i></button>
              </a>
              <a href="javascript:void(0);" class="btn-delete" data-id="<?= $k->id; ?>">
                <button><i class="fas fa-trash"></i></button>
              </a>
            </div>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<!-- DataTables & SweetAlert Script -->
<script>
  $(document).ready(function () {
    $('#kunjungan-table').DataTable({
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
      const deleteUrl = '<?php echo Yii::app()->createUrl("site/deleteKunjungan"); ?>' + '?id=' + id;

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
