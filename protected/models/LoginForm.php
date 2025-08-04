<?php

class LoginForm extends CFormModel
{
    public $role;
    public $username;
    public $password;

    private $_user;

    public function rules()
    {
        return array(
            array('role, username, password', 'required'),
            array('password', 'authenticate'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'role' => 'Role',
            'username' => 'Username',
            'password' => 'Password',
        );
    }

    public function authenticate($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = Users::model()->findByAttributes(['username' => $this->username]);

            if (!$user || !CPasswordHelper::verifyPassword($this->password, $user->password)) {
                $this->addError('password', 'Username atau password salah!');
            } else {
                if ($user->role !== $this->role) {
                    switch ($this->role) {
                        case 'Admin':
                            $this->addError('role', 'Role anda bukan Admin');
                            break;
                        case 'Pendaftaran':
                            $this->addError('role', 'Role anda bukan Petugas Pendaftaran');
                            break;
                        case 'Dokter':
                            $this->addError('role', 'Role anda bukan Dokter');
                            break;
                        case 'Kasir':
                            $this->addError('role', 'Role anda bukan Kasir');
                            break;
                        default:
                            $this->addError('role', 'Role tidak dikenali');
                            break;
                    }
                } else {
                    $this->_user = $user;
                }
            }
        }
    }


    public function login()
    {
        if ($this->_user !== null) {
            $identity = new UserIdentity($this->username, $this->password);
            if ($identity->authenticate()) {
                Yii::app()->user->login($identity);
                Yii::app()->session['user_role'] = $this->_user->role;
                return true;
            }

            Yii::app()->session['user_role'] = $this->_user->role;
            return true;
        }
        return false;
    }
}
