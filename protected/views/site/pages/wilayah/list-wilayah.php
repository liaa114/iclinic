<?php $this->pageTitle = 'Daftar Wilayah'; ?>

<div class="url-section">
    <h2>Daftar Wilayah</h2>
    <span>|</span>
    <a href="<?php echo Yii::app()->createUrl('site/dashboard'); ?>"><i class="fa-solid fa-house"></i></a>
    <span class="url-rout">></span>
    <a href="#">Wilayah</a>
</div>

<?php if (Yii::app()->user->hasFlash('success')): ?>
    <div class="alert alert-success">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php endif; ?>

<div class="add-btn">
    <a href="<?php echo Yii::app()->createUrl('site/addWilayah'); ?>" class="btn-add-user">
        Tambah Data
    </a>
</div>

<div class="table-container">
    <table class="table-style display" id="wilayah-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Provinsi</th>
                <th>Kabupaten</th>
                <th>Kecamatan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($wilayah as $index => $item): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= CHtml::encode($item->provinsi) ?></td>
                    <td><?= CHtml::encode($item->kabupaten) ?></td>
                    <td><?= CHtml::encode($item->kecamatan) ?></td>
                    <td style="text-align: center;">
                        <div class="action-btns">
                            <button class="btn btn-edit" onclick="window.location.href='<?= Yii::app()->createUrl('site/editWilayah', ['id' => $item->id]); ?>'">
                                <i class="fas fa-pen"></i>
                            </button>

                            <!-- Tambahkan tombol delete jika diperlukan -->

                            <button class="btn btn-delete" data-id="<?= $item->id; ?>">
                                <i class="fas fa-trash"></i>
                            </button>

                        </div>
                    </td>

                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        $('#wilayah-table').DataTable({
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

        $(document).on('click', '.btn-delete', function() {
            var id = $(this).data('id');

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#76BA99',
                cancelButtonText: 'Batal',
                confirmButtonText: 'Ya, hapus!',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '<?php echo Yii::app()->createUrl("site/deleteWilayah"); ?>',
                        type: 'POST',
                        data: {
                            id: id
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: 'Data telah dihapus.',
                                icon: 'success',
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload(); // reload halaman
                            });
                        },
                        error: function() {
                            Swal.fire(
                                'Gagal!',
                                'Terjadi kesalahan saat menghapus data.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    });
</script>