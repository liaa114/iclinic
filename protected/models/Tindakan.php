<?php

class Tindakan extends CActiveRecord
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'tindakan';
    }

    public function rules()
    {
        return [
            ['nama_tindakan, harga', 'required'],
            ['nama_tindakan', 'length', 'max' => 100],
            ['harga', 'numerical'],
            ['deskripsi', 'safe'],
        ];
    }
}
