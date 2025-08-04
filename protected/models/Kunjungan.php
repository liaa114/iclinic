<?php

class Kunjungan extends CActiveRecord
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'kunjungan';
    }

    public function rules()
    {
        return array(
            array('jenis_kunjungan', 'required'),
            array('jenis_kunjungan', 'length', 'max' => 50),
            array('keterangan', 'safe'),
        );
    }

    public function relations()
    {
        return array(
            'pasien' => array(self::HAS_MANY, 'Pasien', 'kunjungan_id'),
        );
    }
}
