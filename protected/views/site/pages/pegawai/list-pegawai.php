<?php $this->pageTitle = 'Data Pegawai'; ?>

<div class="url-section">
  <h2>Data Pegawai</h2>
  <span>|</span>
  <a href="<?php echo Yii::app()->createUrl('site/dashboard'); ?>"><i class="fa-solid fa-house"></i></a>
  <span class="url-rout">></span>
  <a href="<?php echo Yii::app()->createUrl('site/pegawai'); ?>">Pegawai</a>
</div>

<div class="add-btn">
  <a href="<?php echo Yii::app()->createUrl('site/addPegawai'); ?>" class="btn-add-user">
    Tambah Data
  </a>
</div>

<div class="table-container">
  <table class="table-style display" id="pegawai-table">
    <thead>
      <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Jabatan</th>
        <th>Alamat</th>
        <th>No HP</th>
        <th>Email</th>
        <th>Created At</th>
        <th style="text-align: center;">Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($pegawai as $index => $p): ?>
        <tr>
          <td><?= $index + 1; ?></td>
          <td><?= CHtml::encode($p->nama); ?></td>
          <td><?= CHtml::encode($p->jabatan); ?></td>
          <td><?= CHtml::encode($p->alamat); ?></td>
          <td><?= CHtml::encode($p->no_hp); ?></td>
          <td><?= CHtml::encode($p->email); ?></td>
          <td><?= CHtml::encode($p->created_at); ?></td>
          <td style="text-align: center;">
            <div class="action-btns">
              <a href="<?php echo Yii::app()->createUrl('site/editPegawai', ['id' => $p->id]); ?>" title="Edit">
                <button><i class="fas fa-pen"></i></button>
              </a>
              <a href="javascript:void(0);" class="btn-delete" data-id="<?= $p->id; ?>" title="Delete">
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
    $('#pegawai-table').DataTable({
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
        }
      }
    });

    $('.btn-delete').on('click', function () {
      const id = $(this).data('id');
      const deleteUrl = '<?php echo Yii::app()->createUrl("site/deletePegawai"); ?>' + '?id=' + id;

      Swal.fire({
        title: 'Yakin ingin menghapus?',
        text: "Data tidak dapat dikembalikan!",
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
