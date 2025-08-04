<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice PDF</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12pt; }
        .header { text-align: center; margin-bottom: 20px; }
        .section { margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; }
        td, th { border: 1px solid #000; padding: 5px; }
        th { background: #eee; }
    </style>
</head>
<body>
    <div class="header">
        <h2>INVOICE PEMBAYARAN</h2>
    </div>

    <div class="section">
        <strong>Pasien:</strong> <?= CHtml::encode($transaksi->pasien->nama); ?><br>
        <strong>Dokter:</strong> <?= CHtml::encode($transaksi->users ? $transaksi->users->nama_lengkap : '-'); ?><br>
        <strong>Tanggal:</strong> <?= date('Y-m-d H:i:s', strtotime($transaksi->tanggal_kunjungan)); ?><br>
    </div>

    <div class="section">
        <h4>Detail Tindakan</h4>
        <table>
            <tr><th>Nama Tindakan</th><th>Harga</th></tr>
            <tr>
                <td><?= $transaksi->tindakan ? $transaksi->tindakan->nama_tindakan : '-'; ?></td>
                <td>Rp <?= number_format($transaksi->total_harga, 0, ',', '.'); ?></td>
            </tr>
        </table>
    </div>

    <div class="section">
        <h4>Obat</h4>
        <table>
            <tr><th>No</th><th>Nama Obat</th><th>Jumlah</th><th>Harga Total</th></tr>
            <?php foreach ($transaksi->transaksiObats as $i => $to): ?>
            <tr>
                <td><?= $i + 1 ?></td>
                <td><?= CHtml::encode($to->obat->nama_obat); ?></td>
                <td><?= $to->jumlah; ?></td>
                <td>Rp <?= number_format($to->total_harga, 0, ',', '.'); ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <div class="section">
        <strong>Total Bayar:</strong> Rp <?= number_format($model->total_bayar, 0, ',', '.'); ?><br>
        <strong>Metode Bayar:</strong> <?= CHtml::encode($model->metode_bayar); ?>
    </div>

    <p style="text-align:center; margin-top:30px;">-- Terima kasih telah berkunjung --</p>
</body>
</html>
