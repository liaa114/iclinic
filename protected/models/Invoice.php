<?php
class Invoice extends CActiveRecord
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'invoice';
    }

    public function rules()
    {
        return [
            ['transaksi_id, user_id, metode_bayar, total_bayar', 'required'],
            ['status', 'boolean'],
            ['total_bayar', 'numerical'],
        ];
    }

    public function relations()
    {
        return [
            'transaksi' => [self::BELONGS_TO, 'Transaksi', 'transaksi_id'],
            'user' => [self::BELONGS_TO, 'Users', 'user_id'],
        ];
    }
}
