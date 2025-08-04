<?php

class Wilayah extends CActiveRecord
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'wilayah';
    }

    public function rules()
    {
        return array(
            array('provinsi, kabupaten, kecamatan', 'required'),
            array('provinsi, kabupaten, kecamatan', 'length', 'max' => 100),
        );
    }
}
