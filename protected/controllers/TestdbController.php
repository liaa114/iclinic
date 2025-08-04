<?php

class TestdbController extends Controller
{
    public function actionIndex()
    {
        try {
            $connection = Yii::app()->db;
            $connection->active = true;

            echo "Koneksi ke database PostgreSQL BERHASIL!";
        } catch (CDbException $e) {
            echo "Gagal koneksi: " . $e->getMessage();
        }
    }
}
