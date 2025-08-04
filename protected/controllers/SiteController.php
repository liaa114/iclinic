<?php

use Mpdf\Mpdf;
use Mpdf\Output\Destination;

class SiteController extends Controller
{
    public $layout = 'main';

    public function filters()
    {
        return array('accessControl');
    }

    public function accessRules()
    {
        return array(
            array(
                'allow',
                'actions' => array('index'),
                'users' => array('*'),
            ),
            array(
                'allow',
                'actions' => array(
                    'dashboard',
                    'userList',
                    'addUser',
                    'editUser',
                    'deleteUser',
                    'pegawai',
                    'addPegawai',
                    'editPegawai',
                    'deletePegawai',
                    'wilayah',
                    'addWilayah',
                    'editWilayah',
                    'deleteWilayah',
                    'pasien',
                    'addPasien',
                    'editPasien',
                    'deletePasien',
                    'tindakan',
                    'addTindakan',
                    'editTindakan',
                    'deleteTindakan',
                    'obat',
                    'addObat',
                    'editObat',
                    'deleteObat',
                    'kunjungan',
                    'addKunjungan',
                    'editKunjungan',
                    'deleteKunjungan',
                    'listTransaksi',
                    'addTransaksi',
                    'listInvoice',
                    'addInvoice',
                    'logout'
                ),
                'users' => array('@'),
            ),
            array(
                'deny',
                'users' => array('*'),
            ),
        );
    }


    public function actionIndex()
    {
        $model = new LoginForm();

        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            if ($model->validate() && $model->login()) {
                $this->redirect(['site/dashboard']);
            }
        }

        $this->render('index', array('model' => $model));
    }

    public function actionHash()
    {
        echo CPasswordHelper::hashPassword('tutu123');
    }

    public function actionLogout()
    {
        Yii::app()->session->clear();
        Yii::app()->user->logout();
        $this->redirect(['site/index']);
    }

    public function actionDashboard()
    {
        $this->layout = 'dashboard';

        $totalObat = Obat::model()->count();
        $jumlahPasienHariIni = Pasien::model()->count("DATE(created_at) = CURRENT_DATE");
        $jumlahKunjunganBulanIni = Pasien::model()->count("
        EXTRACT(MONTH FROM created_at) = EXTRACT(MONTH FROM CURRENT_DATE)
        AND EXTRACT(YEAR FROM created_at) = EXTRACT(YEAR FROM CURRENT_DATE)
    ");
        // Hitung total transaksi sebagai total tindakan
        $totalTindakan = Yii::app()->db->createCommand("
        SELECT COUNT(*) FROM transaksi
    ")->queryScalar();

        $command = Yii::app()->db->createCommand("
        SELECT COUNT(DISTINCT pasien_id) AS jumlah_pasien
        FROM transaksi
        WHERE EXTRACT(MONTH FROM tanggal_kunjungan) = EXTRACT(MONTH FROM CURRENT_DATE)
          AND EXTRACT(YEAR FROM tanggal_kunjungan) = EXTRACT(YEAR FROM CURRENT_DATE)
    ");
        $result = $command->queryRow();
        $jumlahPasienBulanIni = $result ? (int)$result['jumlah_pasien'] : 0;

        $obatSering = Yii::app()->db->createCommand("
        SELECT o.nama_obat, SUM(to_.jumlah) AS total_resep
        FROM transaksi_obat to_
        JOIN obat o ON to_.obat_id = o.id
        GROUP BY o.nama_obat
        ORDER BY total_resep DESC
        LIMIT 5
    ")->queryAll();

        $kunjunganBulan = Yii::app()->db->createCommand("
        SELECT TO_CHAR(created_at, 'YYYY-MM') AS bulan, COUNT(*) AS jumlah
        FROM pasien
        WHERE created_at >= (CURRENT_DATE - INTERVAL '11 months')
        GROUP BY bulan
        ORDER BY bulan
    ")->queryAll();

        $tindakanTerbanyak = Yii::app()->db->createCommand("
        SELECT t.nama_tindakan, COUNT(tr.id) AS jumlah
        FROM transaksi tr
        JOIN tindakan t ON tr.tindakan_id = t.id
        GROUP BY t.nama_tindakan
        ORDER BY jumlah DESC
        LIMIT 5
    ")->queryAll();

        $this->render('pages/app', compact(
            'totalObat',
            'jumlahPasienHariIni',
            'jumlahKunjunganBulanIni',
            'totalTindakan',
            'jumlahPasienBulanIni',
            'obatSering',
            'kunjunganBulan',
            'tindakanTerbanyak'
        ));
    }



    public function actionUserList()
    {
        $this->layout = 'dashboard';
        $users = Users::model()->findAll(array(
            'order' => 'id ASC'
        ));
        $this->render('pages/user/user-list', ['users' => $users]);
    }

    public function actionAddUser()
    {
        $this->layout = 'dashboard';
        $model = new Users();

        if (isset($_POST['Users'])) {

            $model->username = $_POST['Users']['username'];
            $model->role = $_POST['Users']['role'];
            $model->nama_lengkap = $_POST['Users']['nama_lengkap'];

            if ($model->role === 'Admin') {
                throw new CHttpException(403, 'Tidak diperbolehkan menambahkan pengguna dengan role Admin.');
            }
            if (!empty($_POST['Users']['password'])) {
                $model->password = CPasswordHelper::hashPassword($_POST['Users']['password']);
            } else {
                $model->addError('password', 'Password tidak boleh kosong.');
                $this->render('pages/user/add-user', ['model' => $model]);
                return;
            }


            if ($model->save()) {
                $this->redirect(['site/userList']);
            } else {
                echo "<pre>";
                print_r($model->getErrors());
                echo "</pre>";
                Yii::app()->end();
            }
        }

        $this->render('pages/user/add-user', ['model' => $model]);
    }


    public function actionEditUser($id)
    {
        $this->layout = 'dashboard';

        $model = Users::model()->findByPk($id);
        if (!$model) throw new CHttpException(404, 'User tidak ditemukan.');

        if ($model->role === 'Admin') {
            throw new CHttpException(403, 'User dengan role Admin tidak dapat diedit.');
        }

        if (isset($_POST['Users'])) {
            $oldPassword = $model->password;

            $model->username = $_POST['Users']['username'];
            $model->role = $_POST['Users']['role'];
            $model->nama_lengkap = $_POST['Users']['nama_lengkap'];

            if (!empty($_POST['Users']['password'])) {
                $model->password = CPasswordHelper::hashPassword($_POST['Users']['password']);
            } else {
                $model->password = $oldPassword;
            }

            if ($model->save()) {
                $this->redirect(['site/userList']);
            } else {
                echo "<pre>";
                print_r($model->getErrors());
                echo "</pre>";
                Yii::app()->end();
            }
        }

        $this->render('pages/user/edit-user', ['model' => $model]);
    }

    public function actionDeleteUser($id)
    {
        $user = Users::model()->findByPk($id);

        if (!$user) {
            Yii::app()->user->setFlash('error', 'Pengguna tidak ditemukan.');
            $this->redirect(['site/userList']);
            return;
        }

        if ($user->role === 'Admin') {
            Yii::app()->user->setFlash('error', 'Tidak bisa menghapus pengguna dengan role Admin.');
            $this->redirect(['site/userList']);
            return;
        }

        // Cek apakah user masih digunakan dalam transaksi
        $transaksiTerhubung = Transaksi::model()->countByAttributes(['user_id' => $id]);

        if ($transaksiTerhubung > 0) {
            Yii::app()->user->setFlash('warning', 'Pengguna tidak dapat dihapus karena masih digunakan dalam data transaksi.');
            $this->redirect(['site/userList']);
            return;
        }

        // Lanjut hapus user
        if ($user->delete()) {
            Yii::app()->user->setFlash('success', 'Pengguna berhasil dihapus.');
        } else {
            Yii::app()->user->setFlash('error', 'Terjadi kesalahan saat menghapus pengguna.');
        }

        $this->redirect(['site/userList']);
    }


    public function actionPegawai()
    {
        $this->layout = 'dashboard';
        $pegawai = Pegawai::model()->findAll();
        $this->render('pages/pegawai/list-pegawai', ['pegawai' => $pegawai]);
    }

    public function actionAddPegawai()
    {
        $this->layout = 'dashboard';
        $model = new Pegawai();

        if (isset($_POST['Pegawai'])) {
            $model->attributes = $_POST['Pegawai'];
            if ($model->save()) {
                $this->redirect(['site/pegawai']);
            }
        }

        $this->render('pages/pegawai/add-pegawai', ['model' => $model]);
    }

    public function actionEditPegawai($id)
    {
        $this->layout = 'dashboard';
        $model = Pegawai::model()->findByPk($id);

        if (!$model) throw new CHttpException(404, 'Data pegawai tidak ditemukan.');

        if (isset($_POST['Pegawai'])) {
            $model->attributes = $_POST['Pegawai'];
            if ($model->save()) {
                $this->redirect(['site/pegawai']);
            }
        }

        $this->render('pages/pegawai/edit-pegawai', ['model' => $model]);
    }

    public function actionDeletePegawai($id)
    {
        $model = Pegawai::model()->findByPk($id);

        if (!$model) throw new CHttpException(404, 'Data pegawai tidak ditemukan.');

        $model->delete();
        $this->redirect(['site/pegawai']);
    }

    public function actionWilayah()
    {
        $this->layout = 'dashboard';
        $wilayah = Wilayah::model()->findAll(array(
            'order' => 'id ASC'
        ));
        $this->render('pages/wilayah/list-wilayah', ['wilayah' => $wilayah]);
    }

    public function actionAddWilayah()
    {
        $this->layout = 'dashboard';
        $model = new Wilayah();

        if (isset($_POST['Wilayah'])) {
            $model->attributes = $_POST['Wilayah'];
            if ($model->save()) {
                $this->redirect(['site/wilayah']);
            }
        }

        $this->render('pages/wilayah/add-wilayah', ['model' => $model]);
    }

    public function actionEditWilayah($id)
    {
        $this->layout = 'dashboard';
        $model = Wilayah::model()->findByPk($id);

        if (!$model) throw new CHttpException(404, 'Data wilayah tidak ditemukan.');

        if (isset($_POST['Wilayah'])) {
            $model->attributes = $_POST['Wilayah'];
            if ($model->save()) {
                $this->redirect(['site/wilayah']);
            }
        }

        $this->render('pages/wilayah/edit-wilayah', ['model' => $model]);
    }

    public function actionDeleteWilayah()
    {
        if (Yii::app()->request->isPostRequest && isset($_POST['id'])) {
            $id = (int)$_POST['id'];
            $wilayah = Wilayah::model()->findByPk($id);
            if ($wilayah !== null) {
                $wilayah->delete();
                echo json_encode(['status' => 'success']);
            } else {
                throw new CHttpException(404, 'Data tidak ditemukan.');
            }
        } else {
            throw new CHttpException(400, 'Permintaan tidak valid.');
        }
    }



    public function actionPasien()
    {
        $this->layout = 'dashboard';
        $pasien = Pasien::model()->findAll(array(
            'order' => 'id ASC'
        ));
        $this->render('pages/pasien/list-pasien', ['pasien' => $pasien]);
    }

    public function actionAddPasien()
    {
        $this->layout = 'dashboard';
        $model = new Pasien();

        if (isset($_POST['Pasien'])) {
            $model->attributes = $_POST['Pasien'];
            if ($model->save()) {
                $this->redirect(['site/pasien']);
            }
        }

        $this->render('pages/pasien/add-pasien', ['model' => $model]);
    }

    public function actionEditPasien($id)
    {
        $this->layout = 'dashboard';
        $model = Pasien::model()->findByPk($id);

        if (!$model) throw new CHttpException(404, 'Data pasien tidak ditemukan.');

        if (isset($_POST['Pasien'])) {
            $model->attributes = $_POST['Pasien'];
            if ($model->save()) {
                $this->redirect(['site/pasien']);
            }
        }

        $this->render('pages/pasien/edit-pasien', ['model' => $model]);
    }

    public function actionDeletePasien($id)
    {
        $model = Pasien::model()->findByPk($id);

        if (!$model) throw new CHttpException(404, 'Data pasien tidak ditemukan.');

        $model->delete();
        $this->redirect(['site/pasien']);
    }


    public function actionTindakan()
    {
        $this->layout = 'dashboard';
        $tindakan = Tindakan::model()->findAll(array(
            'order' => 'id ASC'
        ));
        $this->render('pages/tindakan/list-tindakan', ['tindakan' => $tindakan]);
    }

    public function actionAddTindakan()
    {
        $this->layout = 'dashboard';
        $model = new Tindakan();

        if (isset($_POST['Tindakan'])) {
            $model->attributes = $_POST['Tindakan'];
            if ($model->save()) {
                $this->redirect(['site/tindakan']);
            }
        }

        $this->render('pages/tindakan/add-tindakan', ['model' => $model]);
    }

    public function actionEditTindakan($id)
    {
        $this->layout = 'dashboard';
        $model = Tindakan::model()->findByPk($id);
        if (!$model) throw new CHttpException(404, 'Data tindakan tidak ditemukan.');

        if (isset($_POST['Tindakan'])) {
            $model->attributes = $_POST['Tindakan'];
            if ($model->save()) {
                $this->redirect(['site/tindakan']);
            }
        }

        $this->render('pages/tindakan/edit-tindakan', ['model' => $model]);
    }

    public function actionDeleteTindakan($id)
    {
        $model = Tindakan::model()->findByPk($id);
        if (!$model) {
            throw new CHttpException(404, 'Data tindakan tidak ditemukan.');
        }
        $model->delete();
        $this->redirect(['site/tindakan']);
    }


    public function actionObat()
    {
        $this->layout = 'dashboard';
        $obat = Obat::model()->findAll();
        $this->render('pages/obat/list-obat', ['obat' => $obat]);
    }

    public function actionAddObat()
    {
        $this->layout = 'dashboard';
        $model = new Obat();

        if (isset($_POST['Obat'])) {
            $model->attributes = $_POST['Obat'];
            if ($model->save()) {
                $this->redirect(['site/obat']);
            }
        }

        $this->render('pages/obat/add-obat', ['model' => $model]);
    }

    public function actionEditObat($id)
    {
        $this->layout = 'dashboard';
        $model = Obat::model()->findByPk($id);

        if (!$model) throw new CHttpException(404, 'Data obat tidak ditemukan.');

        if (isset($_POST['Obat'])) {
            $model->attributes = $_POST['Obat'];
            if ($model->save()) {
                $this->redirect(['site/obat']);
            }
        }

        $this->render('pages/obat/edit-obat', ['model' => $model]);
    }

    public function actionDeleteObat($id)
    {
        $model = Obat::model()->findByPk($id);
        if (!$model) throw new CHttpException(404, 'Data obat tidak ditemukan.');
        $model->delete();
        $this->redirect(['site/obat']);
    }

    public function actionKunjungan()
    {
        $this->layout = 'dashboard';
        $kunjungan = Kunjungan::model()->findAll(array(
            'order' => 'id ASC'
        ));
        $this->render('pages/kunjungan/list-kunjungan', ['kunjungan' => $kunjungan]);
    }

    public function actionAddKunjungan()
    {
        $this->layout = 'dashboard';
        $model = new Kunjungan();

        if (isset($_POST['Kunjungan'])) {
            $model->attributes = $_POST['Kunjungan'];
            if ($model->save()) {
                $this->redirect(['site/kunjungan']);
            }
        }

        $this->render('pages/kunjungan/add-kunjungan', ['model' => $model]);
    }

    public function actionEditKunjungan($id)
    {
        $this->layout = 'dashboard';
        $model = Kunjungan::model()->findByPk($id);

        if (!$model) {
            throw new CHttpException(404, 'Data kunjungan tidak ditemukan.');
        }

        if (isset($_POST['Kunjungan'])) {
            $model->attributes = $_POST['Kunjungan'];
            if ($model->save()) {
                $this->redirect(['site/kunjungan']);
            }
        }

        $this->render('pages/kunjungan/edit-kunjungan', ['model' => $model]);
    }

    public function actionDeleteKunjungan($id)
    {
        $model = Kunjungan::model()->findByPk($id);
        if (!$model) {
            throw new CHttpException(404, 'Data kunjungan tidak ditemukan.');
        }

        $model->delete();
        $this->redirect(['site/kunjungan']);
    }

    public function actionListTransaksi()
    {
        $this->layout = 'dashboard';

        $userId = Yii::app()->user->id;

        $transaksiList = Transaksi::model()->with([
            'pasien',
            'tindakan',
            'transaksiObats.obat',
            'users'
        ])->findAllByAttributes([
            'user_id' => $userId
        ], [
            'order' => 't.id ASC'
        ]);



        $this->render('pages/transaksi/list-transaksi', [
            'transaksiList' => $transaksiList
        ]);
    }


    public function actionAddTransaksi()
    {
        $this->layout = 'dashboard';

        $model = new Transaksi();
        $modelObat = new TransaksiObat();

        $user = Users::model()->findByAttributes(['username' => Yii::app()->user->name]);
        $pasienList = Pasien::model()->findAllByAttributes(['user_id' => $user->id]);
        $tindakanList = Tindakan::model()->findAll();
        $obatList = Obat::model()->findAll();

        if (isset($_POST['Transaksi'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes = $_POST['Transaksi'];
                $model->tanggal_kunjungan = new CDbExpression('NOW()');
                $model->user_id = Yii::app()->user->id;


                $totalHargaTindakan = 0;
                if (!empty($model->tindakan_id)) {
                    $tindakan = Tindakan::model()->findByPk($model->tindakan_id);
                    if ($tindakan) {
                        $totalHargaTindakan = $tindakan->harga;
                    }
                }

                if ($model->save()) {
                    $errors = [];
                    $messages = [];
                    $obatData = [];

                    if (isset($_POST['obat_id']) && isset($_POST['jumlah_obat'])) {
                        foreach ($_POST['obat_id'] as $i => $obatId) {
                            $jumlah = (int) $_POST['jumlah_obat'][$i];

                            if ($obatId && $jumlah > 0) {
                                $obat = Obat::model()->findByPk($obatId);
                                if ($obat) {
                                    $obatData[] = [
                                        'model' => $obat,
                                        'jumlah' => $jumlah,
                                    ];

                                    if ($obat->stok < $jumlah) {
                                        $messages[] = "Jumlah obat '{$obat->nama_obat}' tidak mencukupi. Stok tersedia: {$obat->stok}";
                                    } else {
                                        $messages[] = "Jumlah obat '{$obat->nama_obat}' cukup";
                                    }
                                }
                            }
                        }

                        $kurang = array_filter($messages, fn($m) => strpos($m, 'tidak mencukupi') !== false);

                        if (!empty($kurang)) {
                            $msg = "Terjadi kesalahan saat menyimpan transaksi: " . implode(" tapi ", $messages);
                            throw new CException($msg);
                        }

                        foreach ($obatData as $item) {
                            $obat = $item['model'];
                            $jumlah = $item['jumlah'];

                            $obatTransaksi = new TransaksiObat();
                            $obatTransaksi->transaksi_id = $model->id;
                            $obatTransaksi->obat_id = $obat->id;
                            $obatTransaksi->jumlah = $jumlah;
                            $obatTransaksi->total_harga = $obat->harga * $jumlah;

                            if (!$obatTransaksi->save()) {
                                throw new CException("Gagal menyimpan detail obat.");
                            }

                            $obat->stok -= $jumlah;
                            if (!$obat->save()) {
                                throw new CException("Gagal memperbarui stok obat.");
                            }
                        }
                    }

                    $model->total_harga = $totalHargaTindakan;
                    $model->save(false);
                }

                $transaction->commit();
                Yii::app()->user->setFlash('success', 'Transaksi berhasil ditambahkan.');
                $this->redirect(['site/listTransaksi']);
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', 'Terjadi kesalahan saat menyimpan transaksi: ' . $e->getMessage());

                return $this->render('pages/transaksi/add-transaksi', [
                    'model' => $model,
                    'modelObat' => $modelObat,
                    'pasienList' => $pasienList,
                    'tindakanList' => $tindakanList,
                    'obatList' => $obatList,
                    'postData' => $_POST,
                ]);
            }
        }

        $this->render('pages/transaksi/add-transaksi', [
            'model' => $model,
            'modelObat' => $modelObat,
            'pasienList' => $pasienList,
            'tindakanList' => $tindakanList,
            'obatList' => $obatList,
        ]);
    }

    public function actionListInvoice()
    {
        $this->layout = 'dashboard';

        $invoices = Transaksi::model()->with([
            'pasien',
            'tindakan',
            'transaksiObats.obat',
            'invoice'
        ])->findAll([
            'order' => 'tanggal_kunjungan ASC',
        ]);

        $this->render('pages/invoice/list-invoice', ['transaksiList' => $invoices]);
    }


    public function actionAddInvoice($id)
    {
        $this->layout = 'dashboard';

        $transaksi = Transaksi::model()->with(['transaksiObats', 'pasien', 'tindakan', 'users'])->findByPk($id);
        if (!$transaksi) throw new CHttpException(404, 'Transaksi tidak ditemukan.');

        $model = new Invoice();

        if (isset($_POST['Invoice'])) {
            $model->transaksi_id = $transaksi->id;
            $model->user_id = Yii::app()->user->id;
            $model->metode_bayar = $_POST['Invoice']['metode_bayar'];
            $model->total_bayar = $_POST['Invoice']['total_bayar'];
            $model->status = true;

            if ($model->save()) {

                require_once(Yii::getPathOfAlias('webroot.vendor') . '/autoload.php');

                $mpdf = new Mpdf();



                $folderPath = Yii::getPathOfAlias('webroot.invoices');
                if (!is_dir($folderPath)) {
                    mkdir($folderPath, 0777, true);
                }

                $html = $this->renderPartial('pages/pdf/invoice', [
                    'model' => $model,
                    'transaksi' => $transaksi
                ], true);

                $filename = 'invoice_' . $model->id . '.pdf';
                $fullPath = $folderPath . '/' . $filename;
                $mpdf->WriteHTML($html);
                $mpdf->Output($fullPath, Destination::FILE);

                $model->file_invoice = $filename;
                $model->save(false);

                Yii::app()->user->setFlash('success', 'Invoice berhasil ditambahkan & file PDF dibuat.');
                $this->redirect(['site/listInvoice']);
            }
        }

        $this->render('pages/invoice/add-invoice', [
            'model' => $model,
            'transaksi' => $transaksi
        ]);
    }
}
