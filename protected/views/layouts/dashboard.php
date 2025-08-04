<?php
$user = Users::model()->findByAttributes(['username' => Yii::app()->user->name]);
?>
<?php
function isActive($controller, $actions = [])
{
    $currentController = Yii::app()->controller->id;
    $currentAction = Yii::app()->controller->action->id;

    if ($currentController !== $controller) {
        return '';
    }

    if (!is_array($actions)) {
        $actions = [$actions];
    }

    if (empty($actions)) {
        return 'active';
    }

    return in_array($currentAction, $actions) ? 'active' : '';
}

?>


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="dashboard">
        <aside class="search-wrap">
            <div class="user-actions">
                <?php if (!Yii::app()->user->isGuest): ?>
                    <div style="text-align: right; padding: 10px;">
                        <a href="<?php echo Yii::app()->createUrl('site/logout'); ?>" class="btn-logout">
                            <i class="fa fa-sign-out-alt"></i>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </aside>

        <header class="menu-wrap">
            <figure class="user">
                <div class="user-avatar">
                    <img src="<?php echo Yii::app()->request->baseUrl; ?>/css/img/Login.png" alt="Ilustrasi Klinik" />
                </div>

                <div class="userrole">
                    <figcaption>
                        <?php echo CHtml::encode($user ? $user->role : ''); ?>
                    </figcaption>
                    <figcaption>
                        <?php echo CHtml::encode($user ? $user->nama_lengkap : ''); ?>
                    </figcaption>
                </div>
            </figure>

            <nav>
                <?php
                $role = Yii::app()->session['user_role'];

                if ($role === 'Admin'): ?>
                    <section class="dicover">
                        <ul>
                            <li class="<?php echo isActive('site', 'dashboard'); ?>">
                                <a href="<?php echo  Yii::app()->createUrl('site/dashboard'); ?>">
                                    <i class="fa-solid fa-house"></i>
                                    Dashboard
                                </a>
                            </li>
                            <h3 class="role-title">Master Data</h3>

                            <li class="<?php echo isActive('site', ['wilayah', 'addWilayah', 'editWilayah']); ?>">
                                <a href="<?php echo Yii::app()->createUrl('site/wilayah'); ?>">
                                    <i class="fa-solid fa-user-tie"></i> Wilayah
                                </a>
                            </li>
                            <li class="<?php echo isActive('site', ['userList', 'addUser', 'editUser']); ?>">
                                <a href="<?php echo Yii::app()->createUrl('site/userList'); ?>">
                                    <i class="fa-solid fa-users"></i> Pengguna
                                </a>
                            </li>

                            <li class="<?php echo isActive('site', ['pegawai', 'addPegawai', 'editPegawai']); ?>">
                                <a href="<?php echo Yii::app()->createUrl('site/pegawai'); ?>">
                                    <i class="fa-solid fa-user-tie"></i> Pegawai
                                </a>
                            </li>

                            <li class="<?php echo isActive('site', ['kunjungan', 'addKunjungan', 'editKunjungan']); ?>">
                                <a href="<?php echo Yii::app()->createUrl('site/kunjungan'); ?>">
                                    <i class="fa-solid fa-book-medical"></i> Kunjungan
                                </a>
                            </li>


                            <li class="<?php echo isActive('site', ['tindakan', 'addTindakan', 'editTindakan']); ?>">
                                <a href="<?php echo Yii::app()->createUrl('site/tindakan'); ?>">
                                    <i class="fa-brands fa-artstation"></i> Tindakan
                                </a>
                            </li>

                            <li class="<?php echo isActive('site', ['obat', 'addObat', 'editObat']); ?>">
                                <a href="<?php echo Yii::app()->createUrl('site/obat'); ?>">
                                    <i class="fa-solid fa-pills"></i> Obat
                                </a>
                            </li>

                        </ul>
                    </section>
                <?php elseif ($role === 'Pendaftaran'): ?>
                    <section class="dicover">
                        <ul>
                            <li class="<?php echo isActive('site', 'dashboard'); ?>">
                                <a href="<?php echo  Yii::app()->createUrl('site/dashboard'); ?>">
                                    <i class="fa-solid fa-house"></i>
                                    Dashboard
                                </a>
                            </li>
                            <h3 class="role-title">Pendaftaran Pasien</h3>
                            <li class="<?php echo isActive('site', 'addPasien'); ?>">
                                <a href="<?php echo Yii::app()->createUrl('site/addPasien'); ?>">
                                    <i class="fa-solid fa-book"></i> Formulir Pendaftaran
                                </a>
                            </li>
                            <li class="<?php echo isActive('site', 'pasien'); ?>">
                                <a href="<?php echo Yii::app()->createUrl('site/pasien'); ?>">
                                    <i class="fa-solid fa-user"></i> Riwayat Kunjungan
                                </a>
                            </li>
                        </ul>
                    </section>
                <?php elseif ($role === 'Dokter'): ?>
                    <section class="dicover">
                        <ul>
                            <li class="<?php echo isActive('site', 'dashboard'); ?>">
                                <a href="<?php echo  Yii::app()->createUrl('site/dashboard'); ?>">
                                    <i class="fa-solid fa-house"></i>
                                    Dashboard
                                </a>
                            </li>
                            <h3 class="role-title">Tindakan</h3>
                            <li class="<?php echo isActive('site', ['addTransaksi']); ?>">
                                <a href="<?php echo Yii::app()->createUrl('site/addTransaksi'); ?>">
                                    <i class="fa-solid fa-notes-medical"></i> Transaksi Tindakan
                                </a>
                            </li>
                            <li class="<?php echo isActive('site', 'listTransaksi'); ?>">
                                <a href="<?php echo Yii::app()->createUrl('site/listTransaksi'); ?>">
                                    <i class="fa-solid fa-clock-rotate-left"></i>
                                    Riwayat Transaksi
                                </a>
                            </li>
                        </ul>
                    </section>
                <?php elseif ($role === 'Kasir'): ?>
                    <section class="dicover">
                        <ul>
                            <li class="<?php echo isActive('site', 'dashboard'); ?>">
                                <a href="<?php echo  Yii::app()->createUrl('site/dashboard'); ?>">
                                    <i class="fa-solid fa-house"></i>
                                    Dashboard
                                </a>
                            </li>
                            <h3 class="role-title">Invoice</h3>
                            <li class="<?php echo isActive('site', 'listInvoice'); ?>">
                                <a href="<?php echo Yii::app()->createUrl('site/listInvoice'); ?>">
                                    <i class="fa-solid fa-file-invoice"></i>
                                    List Invoice
                                </a>
                            </li>
                        </ul>
                    </section>
                <?php endif; ?>
            </nav>

        </header>

        <main class="content-wrap">
            <div class="content">
                <?php echo $content; ?>
            </div>
        </main>
         <footer class="footer-wrap">
        <div class="footer">
            <p>&copy; 2025 Klinik IClinic. All rights reserved.</p>
        </div>
    </footer>
    </div>
</body>

</html>