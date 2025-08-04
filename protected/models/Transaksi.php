<?php

class Transaksi extends CActiveRecord
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'transaksi';
    }

    public function rules()
    {
        return [
            ['pasien_id', 'required'],
            ['tindakan_id', 'safe'],
            ['total_harga', 'numerical'],
            ['tanggal_kunjungan', 'safe'],
            ['user_id', 'numerical', 'integerOnly' => true],

        ];
    }

    public function relations()
    {
        return array(
            'pasien' => array(self::BELONGS_TO, 'Pasien', 'pasien_id'),
            'tindakan' => array(self::BELONGS_TO, 'Tindakan', 'tindakan_id'),
            'transaksiObats' => array(self::HAS_MANY, 'TransaksiObat', 'transaksi_id'),
            'invoice' => [self::HAS_ONE, 'Invoice', 'transaksi_id'],
            'users' => array(self::BELONGS_TO, 'Users', 'user_id'),

        );
    }
}

class TransaksiObat extends CActiveRecord
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'transaksi_obat';
    }

    public function rules()
    {
        return [
            ['transaksi_id, obat_id, jumlah', 'required'],
            ['jumlah', 'numerical', 'integerOnly' => true],
        ];
    }

    public function relations()
    {
        return [
            'transaksi' => [self::BELONGS_TO, 'Transaksi', 'transaksi_id'],
            'obat' => [self::BELONGS_TO, 'Obat', 'obat_id'],
            'invoice' => [self::HAS_ONE, 'Invoice', 'transaksi_id'],
        ];
    }
}
