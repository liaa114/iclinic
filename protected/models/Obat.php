<?php

class Obat extends CActiveRecord
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'obat';
    }

    public function rules()
    {
        return [
            ['nama_obat, harga', 'required'],
            ['nama_obat', 'length', 'max' => 100],
            ['satuan', 'length', 'max' => 50],
            ['harga', 'numerical'],
            ['stok', 'numerical', 'integerOnly' => true],
            ['satuan, stok', 'safe'],
        ];
    }
}
