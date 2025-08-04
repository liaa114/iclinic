<?php $this->pageTitle = 'Data Pengguna'; ?>

<!-- Pesan Flash -->
<?php if (Yii::app()->user->hasFlash('success')): ?>
  <div class="alert alert-success">
    <?= Yii::app()->user->getFlash('success'); ?>
  </div>
<?php endif; ?>

<?php if (Yii::app()->user->hasFlash('error')): ?>
  <div class="alert alert-danger">
    <?= Yii::app()->user->getFlash('error'); ?>
  </div>
<?php endif; ?>

<?php if (Yii::app()->user->hasFlash('warning')): ?>
  <div class="alert alert-warning">
    <?= Yii::app()->user->getFlash('warning'); ?>
  </div>
<?php endif; ?>

<div class="url-section">
  <h2>Data Pengguna</h2>
  <span>|</span>
  <a href="<?php echo Yii::app()->createUrl('site/dashboard'); ?>"><i class="fa-solid fa-house"></i></a>
  <span class="url-rout">></span>
  <a href="<?php echo Yii::app()->createUrl('site/userList'); ?>">Pengguna</a>
</div>

<div class="add-btn">
  <a href="<?php echo Yii::app()->createUrl('site/addUser'); ?>" class="btn-add-user">
    Tambah Data
  </a>
</div>

<div class="table-container">
  <table class="table-style display" id="user-table">
    <thead>
      <tr>
        <th>No</th>
        <th>Username</th>
        <th>Role</th>
        <th>Nama Lengkap</th>
        <th>Created At</th>
        <th style="text-align: center;">Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($users as $index => $user): ?>
        <tr>
          <td><?= $index + 1; ?></td>
          <td><?= CHtml::encode($user->username); ?></td>
          <td><?= CHtml::encode($user->role); ?></td>
          <td><?= CHtml::encode($user->nama_lengkap); ?></td>
          <td><?= CHtml::encode($user->created_at); ?></td>
          <td style="text-align: center;">
            <div class="action-btns">
              <?php if ($user->role !== 'Admin'): ?>
                <a href="<?php echo Yii::app()->createUrl('site/editUser', ['id' => $user->id]); ?>" title="Edit">
                  <button><i class="fas fa-pen"></i></button>
                </a>
                <a href="javascript:void(0);" class="btn-delete" data-id="<?= $user->id; ?>" title="Delete">
                  <button><i class="fas fa-trash"></i></button>
                </a>
              <?php else: ?>
                <span style="color: gray;">-</span>
              <?php endif; ?>
            </div>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  $(document).ready(function () {
    $('#user-table').DataTable({
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
      const deleteUrl = '<?php echo Yii::app()->createUrl("site/deleteUser"); ?>' + '?id=' + id;

      Swal.fire({
        title: 'Yakin ingin menghapus?',
        text: "Data akan dihapus permanen!",
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
