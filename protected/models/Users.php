<?php

class Users extends CActiveRecord
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'users';
    }
    public function rules()
    {
        return array(
            array('username, role, nama_lengkap', 'required'),
            array('username', 'length', 'max' => 50),
            array('role', 'in', 'range' => array('Admin', 'Pendaftaran', 'Dokter', 'Kasir')),
            array('nama_lengkap', 'length', 'max' => 100),
        );
    }
    public function safeAttributes()
    {
        return array('username', 'role', 'nama_lengkap');
    }
}
