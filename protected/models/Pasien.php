<?php
class Pasien extends CActiveRecord
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'pasien';
    }

    public function rules()
    {
        return [
            ['nama, jenis_kelamin', 'required'],
            ['nama', 'length', 'max' => 100],
            ['nik', 'length', 'is' => 16],
            ['nik', 'match', 'pattern' => '/^[0-9]+$/', 'message' => 'NIK hanya boleh berisi angka.'],
            ['tanggal_lahir, alamat, keterangan_kunjungan', 'safe'],
            ['jenis_kelamin', 'in', 'range' => ['L', 'P']],
            ['kunjungan_id, user_id', 'numerical', 'integerOnly' => true],
        ];
    }

    public function relations()
    {
        return [
            'kunjungan' => [self::BELONGS_TO, 'Kunjungan', 'kunjungan_id'],
            'dokter' => [self::BELONGS_TO, 'Users', 'user_id'],
            'wilayah' => [self::BELONGS_TO, 'Wilayah', 'alamat'],
        ];
    }
}
