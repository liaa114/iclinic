<?php

class Pegawai extends CActiveRecord
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'pegawai';
    }

    public function rules()
    {
        return array(
            array('nama', 'required'),
            array('nama', 'length', 'max' => 100),
            array('jabatan', 'length', 'max' => 50),
            array('no_hp', 'length', 'max' => 20),
            array('email', 'length', 'max' => 100),
            array('email', 'email'),
            array('alamat', 'safe'),
            array('email', 'email', 'message' => 'Format email tidak valid.'),
        );
    }
}

