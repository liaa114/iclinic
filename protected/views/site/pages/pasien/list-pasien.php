<?php $this->pageTitle = 'Data Pasien'; ?>

<div class="url-section">
  <h2>Data Pasien</h2>
  <span>|</span>
  <a href="<?php echo Yii::app()->createUrl('site/dashboard'); ?>"><i class="fa-solid fa-house"></i></a>
  <span class="url-rout">></span>
  <a href="<?php echo Yii::app()->createUrl('site/pasien'); ?>">Pasien</a>
</div>

<?php if (Yii::app()->session['user_role'] === 'Admin'): ?>
  <div class="add-btn">
    <a href="<?php echo Yii::app()->createUrl('site/addPasien'); ?>" class="btn-add-user">
      Tambah Data
    </a>
  </div>
<?php endif; ?>

<div class="table-container">
  <table class="table-style display" id="pasien-table">
    <thead>
      <tr>
        <th>No</th>
        <th>Nama</th>
        <th>NIK</th>
        <th>Alamat</th>
        <th>Tanggal Lahir</th>
        <th>Jenis Kelamin</th>
        <th>Jenis Kunjungan</th>
        <th>Keterangan Kunjungan</th>
        <th>Dokter</th>
        <th>Tanggal Kunjungan</th>
        <?php if (Yii::app()->session['user_role'] === 'Admin'): ?>
          <th style="text-align: center;">Aksi</th>
        <?php endif; ?>
      </tr>
    </thead>
    <tbody>
      <?php $no = 1; ?>
      <?php foreach ($pasien as $p): ?>
        <tr>
          <td><?= $no++; ?></td>
          <td><?= CHtml::encode($p->nama); ?></td>
          <td><?= CHtml::encode($p->nik); ?></td>
          <td><?= CHtml::encode($p->alamat); ?></td>
          <td><?= CHtml::encode($p->tanggal_lahir); ?></td>
          <td><?= CHtml::encode($p->jenis_kelamin); ?></td>
          <td><?= CHtml::encode($p->kunjungan ? $p->kunjungan->jenis_kunjungan : ''); ?></td>
          <td><?= CHtml::encode($p->keterangan_kunjungan); ?></td>
          <td><?= CHtml::encode($p->dokter ? $p->dokter->nama_lengkap : '-'); ?></td>
          <td>
            <?php
              if ($p->created_at) {
                  $dt = new DateTime($p->created_at, new DateTimeZone('UTC'));
                  $dt->setTimezone(new DateTimeZone('Asia/Jakarta'));

                  $bulanIndo = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

                  $tanggal = (int)$dt->format('d');
                  $bulan = $bulanIndo[(int)$dt->format('m') - 1];
                  $tahun = $dt->format('Y');
                  $jam = $dt->format('H:i');

                  echo "$tanggal $bulan $tahun $jam";
              } else {
                  echo '-';
              }
            ?>
          </td>
          <?php if (Yii::app()->session['user_role'] === 'Admin'): ?>
            <td style="text-align: center;">
              <div class="action-btns">
                <a href="<?= Yii::app()->createUrl('site/editPasien', ['id' => $p->id]); ?>">
                  <button><i class="fas fa-pen"></i></button>
                </a>
                <a href="javascript:void(0);" class="btn-delete" data-id="<?= $p->id; ?>">
                  <button><i class="fas fa-trash"></i></button>
                </a>
              </div>
            </td>
          <?php endif; ?>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<script>
  $(document).ready(function () {
    $('#pasien-table').DataTable({
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
      const deleteUrl = '<?php echo Yii::app()->createUrl("site/deletePasien"); ?>' + '?id=' + id;

      Swal.fire({
        title: 'Yakin ingin menghapus?',
        text: "Data pasien akan dihapus secara permanen.",
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
